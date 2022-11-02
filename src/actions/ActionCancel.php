<?php

namespace Taskforce\actions;

class ActionCancel extends AbstractAction
{
    public static function getName(): string
    {
        return 'Отменить';
    }

    public static function checkRights(int $user_id, int $customer_id, ?int $executor_id = null): bool
    {
        return $user_id === $customer_id;
    }
}
