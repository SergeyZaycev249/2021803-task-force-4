<?php
class Task
{
    //Статусы
    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_WORK = 'at work';
    const STATUS_DONE = 'done';
    const STATUS_FAILED = 'failed';

    //Действия
    const ACTION_CANCEL = 'cancel';
    const ACTION_RESPOND = 'respond';
    const ACTION_DONE = 'done';
    const ACTION_REFUSE = 'refuse';

    private $id_customer;
    private $id_executor;
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
    function __construct(int $id_customer, int $id_executor, string $current_status)
    {
        $this->customerId = $id_customer;
        $this->executorId = $id_executor;
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
    function getAvailableActions(int $id_user, string $current_status): string
    {
        if ($id_user === $this->id_customer) {
            $availableActions = [
                self::STATUS_NEW => self::ACTION_CANCEL,
                self::STATUS_WORK => self::ACTION_DONE
            ];
            return $availableActions[$current_status];
        }
        if ($id_user === $this->id_executor) {
            $availableActions = [
                self::STATUS_NEW => self::ACTION_RESPOND,
                self::STATUS_WORK => self::ACTION_REFUSE
            ];
            return $availableActions[$current_status];
        }
        return 'Пользователь не определён';
    }
}
