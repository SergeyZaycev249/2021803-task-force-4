<?php

namespace Taskforce\actions;

abstract class AbstractAction
{
    abstract public static function getName(): string;
    abstract public static function checkRights(int $user_id, int $executor_id, int $customer_id): bool;
}
