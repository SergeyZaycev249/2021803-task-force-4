<?php

namespace Taskforce\actions;

class ActionRefuse extends AbstractAction
{
    public static function getName(): string
    {
        return 'Отказаться';
    }

    public static function getInternalName(): string
    {
        return 'refuse';
    }

    public static function checkRights(int $user_id, int $executor_id, int $customer_id): bool
    {
        return $user_id === $executor_id;
    }
}
