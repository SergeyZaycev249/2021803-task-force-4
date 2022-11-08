<?php

require_once "vendor/autoload.php";

use Taskforce\routes\Task;
use Taskforce\actions\ActionCancel;
use Taskforce\actions\ActionDone;
use Taskforce\actions\ActionRefuse;
use Taskforce\actions\ActionRespond;

$status1 = Task::STATUS_NEW;
$status2 = Task::STATUS_WORK;
$status3 = Task::STATUS_CANCELLED;
$status4 = Task::STATUS_DONE;

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
assert(get_class($task1->getAvailableActions(3,Task::STATUS_NEW)) === ActionCancel::class);
assert(get_class($task1->getAvailableActions(1,Task::STATUS_WORK)) === ActionRefuse::class);
assert(get_class($task2->getAvailableActions(2,Task::STATUS_NEW)) === ActionRespond::class);
assert(get_class($task2->getAvailableActions(1,Task::STATUS_WORK)) === ActionDone::class);
assert(get_class($task3->getAvailableActions(5,Task::STATUS_NEW)) === ActionCancel::class);
assert(get_class($task3->getAvailableActions(6,Task::STATUS_WORK)) === ActionRefuse::class);
assert(get_class($task4->getAvailableActions(2,Task::STATUS_NEW)) === ActionRespond::class);
assert(get_class($task4->getAvailableActions(6,Task::STATUS_WORK)) === ActionDone::class);

var_dump($task1->getChangeStatus('Taskforce\actions\ActionCancel'));