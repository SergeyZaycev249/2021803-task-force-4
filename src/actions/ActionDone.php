<?php

namespace Taskforce\actions;

class ActionDone extends AbstractAction
{
    public static function getName(): string
    {
        return "Выполнено";
    }

    public static function checkRights(int $user_id, int $customer_id, int $executor_id): bool
    {
        return $user_id === $customer_id;
    }
}
