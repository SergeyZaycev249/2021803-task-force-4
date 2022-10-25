<?php

namespace Taskforce\actions;

class ActionRespond extends AbstractAction
{
    public static function getName(): string
    {
        return 'Откликнуться';
    }

    public static function getInternalName(): string
    {
        return 'respond';
    }

    public static function checkRights(int $user_id, int $executor_id, int $customer_id): bool
    {
        return $user_id === $executor_id;
    }
}
