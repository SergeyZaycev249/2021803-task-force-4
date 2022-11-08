<?php

declare(strict_types=1);

namespace Taskforce\data;

use SplFileObject;
use RuntimeException;
use Taskforce\exceptions\TaskException;

class DataConverter
{
    private string $csvFileName;
    private array $columns;
    private object $fileObject;
    private string $tableSqlName;
    private string $sqlFileName;

    public function __construct(string $csvFileName, array $columns, string $tableSqlName, string $sqlFileName)
    {
        $this->csvFileName = $csvFileName;
        $this->columns = $columns;
        $this->tableSqlName = $tableSqlName;
        $this->sqlFileName = $sqlFileName;
    }

    public function import(): void
    {
        if (!$this->validateColumns($this->columns)) {
            throw new TaskException('Заданы неверные заголовки столбцов');
        }
        if (!file_exists($this->csvFileName)) {
            throw new TaskException('Файл не существует');
        }

        try {
            $this->fileObject = new SplFileObject($this->csvFileName);
        } catch (RuntimeException $exception) {
            throw new TaskException('Не удалось открыть файл на чтение');
        }

        $headerData = $this->getHeaderData();
        if ($headerData !== $this->columns) {
            throw new TaskException('Исходный файл не содержит необходимых столбцов');
        }

        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }
    }

    public function getData(): array
    {
        return $this->result;
    }

    private function getHeaderData(): ?array
    {
        $this->fileObject->rewind();
        $data = $this->fileObject->fgetcsv();

        return $data;
    }

    private function getNextLine(): ?iterable
    {
        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }
        return null;
    }

    private function validateColumns(array $columns): bool
    {
        $result = true;

        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                }
            }
        } else {
            $result = false;
        }

        return $result;
    }

    //Конвертация в SQL
    private function convertToSql(): void
    {
        $sqlQuery = 'INSERT INTO ' . $this->tableSqlName;
        $sqlQueryArray = [];

        foreach ($this->getData() as $values) {
            if ($values !== []) {
                foreach ($this->getHeaderData() as $key) {
                    $newKey[] = '`' . $key . '`';
                }
                foreach ($values as $value) {
                    $newValues[] = '"' . $value . '"';
                }
                $sqlQueryArray[] = $sqlQuery . ' (' . implode(', ', $newKey) . ') VALUE ' .
                    '(' . implode(', ', $newValues) . ');' . PHP_EOL;
                $newKey = [];
                $newValues = [];
            }
        }
        $this->sqlQueries = $sqlQueryArray;
    }

    //Сохранение SQL файла
    private function saveSqlFile(): void
    {
        $sqlFile = new SplFileObject($this->sqlFileName . '.sql', 'w');

        foreach ($this->sqlQueries as $query) {
            $sqlFile->fwrite($query);
        }
    }

    //Импорт, конвертация и сохранение файла
    public function converting(): void
    {
        $this->import();
        $this->convertToSql();
        $this->saveSqlFile();
    }
}
