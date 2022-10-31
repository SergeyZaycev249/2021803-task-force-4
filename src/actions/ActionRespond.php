<?php

namespace Taskforce\actions;

class ActionRespond extends AbstractAction
{
    public static function getName(): string
    {
        return 'Откликнуться';
    }

    public static function checkRights(int $user_id, int $customer_id, int $executor_id): bool
    {
        return $user_id === $executor_id;
    }
}
