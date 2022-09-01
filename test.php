<?php

require_once 'classes/task.php';

$task = new Task(1, 2, 'new');

// Создание обработчика
function my_assert_handler($file, $line, $code)
{
    echo "<hr>Неудачная проверка утверждения:
        Файл '$file'<br />
        Строка '$line'<br />
        Код '$code'<br /><hr />";
}

// Подключение callback-функции
assert_options(ASSERT_CALLBACK, 'my_assert_handler');

assert($task->getChangeStatus(Task::ACTION_CANCEL) === Task::STATUS_FAILED, 'failed');
assert($task->getAvailableActions(2, Task::STATUS_NEW) === Task::ACTION_RESPOND, 'respond');
assert($task->getAvailableActions(1, Task::STATUS_WORK) === Task::ACTION_DONE, 'done');
