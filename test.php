<?php

require_once "vendor/autoload.php";

use Taskforce\routes\Task;

$status1 = 'new';
$status2 = 'at_work';
$status3 = 'cancelled';
$status4 = 'done';

$task1 = new Task(3,1,$status1);
$task2 = new Task(1,2,$status2);
$task3 = new Task(5,6,$status3);
$task4 = new Task(6,2,$status4);


assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);

// Создание обработчика
function my_assert_handler($file, $line, $code, $desc = null)
{
    echo "Неудачная проверка утверждения в $file:$line: $code";
    if ($desc) {
        echo ": $desc";
    }
    echo "\n";
}

// Подключение callback-функции
assert_options(ASSERT_CALLBACK, 'my_assert_handler');

// Выполнение проверки утверждения, которое завершится неудачей
assert($task1->getAvailableActions(3,Task::STATUS_NEW) === [ActionCancel::class]);
assert($task1->getAvailableActions(1,Task::STATUS_WORK) === [ActionRefuse::class]);
assert($task2->getAvailableActions(3,Task::STATUS_NEW) === [ActionCancel::class]);
assert($task2->getAvailableActions(1,Task::STATUS_WORK) === [ActionDone::class]);
assert($task3->getAvailableActions(5,Task::STATUS_NEW) === [ActionRefuse::class]);
assert($task3->getAvailableActions(6,Task::STATUS_WORK) === [ActionRespond::class]);
assert($task4->getAvailableActions(2,Task::STATUS_NEW) === [ActionDone::class]);
assert($task4->getAvailableActions(6,Task::STATUS_WORK) === [ActionRespond::class]);