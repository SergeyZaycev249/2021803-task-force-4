<?php

namespace Taskforce\actions;

class ActionDone extends AbstractAction
{
    public static function getName(): string
    {
        return "Выполнено";
    }

    public static function getInternalName(): string
    {
        return 'done';
    }

    public static function checkRights(int $user_id, int $executor_id, int $customer_id): bool
    {
        return $user_id === $customer_id;
    }
}
