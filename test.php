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


$mapAction = $task1->getStatusTask();
$mapStatus = $task1->getActionTask();
var_dump($mapAction,$mapStatus);
$availableAction1 = $task1 ->getAvailableActions(3,$status1);
$availableAction2 = $task1 ->getAvailableActions(1,$status1);
$availableAction3 = $task2 ->getAvailableActions(1,$status2);
$availableAction4 = $task2 ->getAvailableActions(2,$status2);
$availableAction5 = $task3 ->getAvailableActions(5,$status3);
$availableAction6 = $task3 ->getAvailableActions(6,$status3);
$availableAction7 = $task4 ->getAvailableActions(6,$status4);
$availableAction8 = $task4 ->getAvailableActions(2,$status4);

var_dump($availableAction1,$availableAction2,$availableAction3,$availableAction4,$availableAction5,$availableAction6,$availableAction7,$availableAction8);