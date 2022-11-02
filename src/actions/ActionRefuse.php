<?php

namespace Taskforce\actions;

class ActionRefuse extends AbstractAction
{
    public static function getName(): string
    {
        return 'Отказаться';
    }

    public static function checkRights(int $user_id, int $customer_id, int $executor_id): bool
    {
        return $user_id === $executor_id;
    }
}
