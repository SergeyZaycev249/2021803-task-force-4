<?php

namespace Taskforce\routes;

class Task
{
    //Статусы
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_WORK = 'at_work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    //Действия
    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_DONE = 'done';
    const ACTION_REFUSE = 'refuse';

    private $customer_id;
    private $executor_id;
    private $current_status;

    //Карта статусов
    function getStatusTask(): array
    {
        return [
            self::STATUS_NEW => 'Новое',
            self::STATUS_CANCELLED => 'Отменено',
            self::STATUS_WORK => 'В работе',
            self::STATUS_DONE => 'Выполнено',
            self::STATUS_FAILED => 'Провалено'
        ];
    }

    //Карта действий
    function getActionTask(): array
    {
        return [
            self::ACTION_CANCEL => 'Отменить',
            self::ACTION_RESPOND => 'Откликнуться',
            self::ACTION_DONE => 'Выполнено',
            self::ACTION_REFUSE => 'Отказаться',
        ];
    }

    //ID заказчика, исполнителя и текущий статус задачи
    function __construct(int $customer_id, int $executor_id, string $current_status)
    {
        $this->customer_id = $customer_id;
        $this->executor_id = $executor_id;
        $this->current_status = $current_status;
    }

    //Изменение статуса
    function getChangeStatus(string $action): string
    {

        $changeStatus = [
            self::ACTION_CANCEL => self::STATUS_CANCELLED,
            self::ACTION_RESPOND => self::STATUS_WORK,
            self::ACTION_DONE => self::STATUS_DONE,
            self::ACTION_REFUSE => self::STATUS_FAILED
        ];
        return $changeStatus[$action];
    }

    //Доступные действия
    function getAvailableActions(int $user_id, string $current_status): string
    {
        if ($user_id === $this->customer_id) {
            $availableActions = [
                self::STATUS_NEW => self::ACTION_CANCEL,
                self::STATUS_WORK => self::ACTION_DONE
            ];
            return $availableActions[$current_status];
        }
        if ($user_id === $this->executor_id) {
            $availableActions = [
                self::STATUS_NEW => self::ACTION_RESPOND,
                self::STATUS_WORK => self::ACTION_REFUSE
            ];
            return $availableActions[$current_status];
        }
        return 'Пользователь не определён';
    }
}
