<?php

namespace Taskforce\routes;

use Taskforce\actions\ActionCancel;
use Taskforce\actions\ActionDone;
use Taskforce\actions\ActionRefuse;
use Taskforce\actions\ActionRespond;


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
            ActionCancel::class => ActionCancel::getName(),
            ActionRespond::class => ActionRespond::getName(),
            ActionDone::class => ActionDone::getName(),
            ActionRefuse::class => ActionRefuse::getName(),
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
            ActionCancel::class => self::STATUS_CANCELLED,
            ActionRespond::class => self::STATUS_WORK,
            ActionDone::class => self::STATUS_DONE,
            ActionRefuse::class => self::STATUS_FAILED
        ];
        return $changeStatus[$action];
    }

    //Доступные действия
    function getAvailableActions(int $user_id, string $current_status): string
    {
        if ($this->current_status === self::STATUS_NEW && ActionCancel::checkRights($user_id, $this->customer_id)) return new ActionCancel();
        if ($this->current_status === self::STATUS_NEW && ActionRespond::checkRights($user_id, $this->customer_id, $this->executor_id)) return new ActionRespond();
        if ($this->current_status === self::STATUS_WORK && ActionDone::checkRights($user_id, $this->customer_id, $this->executor_id)) return new ActionDone();
        if ($this->current_status === self::STATUS_WORK && ActionRefuse::checkRights($user_id, $this->customer_id, $this->executor_id)) return new ActionRefuse();
        
        return 'Пользователь не определён';
    }
}
