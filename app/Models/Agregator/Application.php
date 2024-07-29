<?php

namespace App\Models\Agregator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $connection = 'mysql_grch';

    protected $table = 'application';

    public $timestamps = true;

    const STATUS_UNDEFINED = 0;
    const STATUS_RESERV_APPLICATED = 1;
    const STATUS_RESERV_AWAIT_FOR_APPROVAL = 2;
    const STATUS_RESERV_APPROVED_BY_DEVELOPER = 3;
    const STATUS_RESERV_APPROVED_BY_ADMIN = 4;
    const STATUS_APPLICATION_IN_WORK = 5;
    const STATUS_DDU_UPLOADED = 6;
    const STATUS_INVOICE_TO_DEVELOPER_ISSUED = 7;
    //const STATUS_RESERV_CANCEL_APPLICATED = 6;
    //const STATUS_RESERV_CANCELLED_BY_ADMIN = 7;
    const STATUS_APPLICATION_CANCELED_BY_ADMIN = 8;
    const STATUS_APPLICATION_APPROVAL_REQUEST = 9;
    const STATUS_APPLICATION_APPROVAL_PROCESS = 10;
    const STATUS_APPLICATION_SUCCESS = 11;
    const STATUS_SELF_RESERVED = 12;
    const STATUS_COMISSION_PAY_CONFIRMED_BY_DEVELOPER = 13;
    const STATUS_COMISSION_PAY_CONFIRMED_BY_ADMIN = 14;
    const STATUS_REPORT_ACT_UPLOADED = 15;
    const STATUS_APPLICATION_IN_WORK_AGENT_DOCPACK_PROVIDED = 16;
    const STATUS_APPLICATION_IN_WORK_DEVELOPER_DOCPACK_PROVIDED = 17;

    public static $status = [
        self::STATUS_UNDEFINED => 'Статус заявки неопределён',
        self::STATUS_RESERV_APPLICATED => 'Заявка на бронирование подана',
        self::STATUS_RESERV_AWAIT_FOR_APPROVAL => 'Заявка на бронирование ожидает подтверждения от застройщика',
        self::STATUS_RESERV_APPROVED_BY_DEVELOPER => 'Бронирование подтверждено застройщиком',
        self::STATUS_RESERV_APPROVED_BY_ADMIN => 'Бронирование подтверждено, ожидается приём заявки в работу',
        self::STATUS_APPLICATION_IN_WORK => 'Заявка в работе',
        self::STATUS_DDU_UPLOADED => 'ДДУ загружен, ожидается выставление счёта застройщику',
        self::STATUS_INVOICE_TO_DEVELOPER_ISSUED => 'Ожидается оплата от застройщика',
        //self::STATUS_RESERV_CANCEL_APPLICATED => 'Заявка на отмену брони',
        //self::STATUS_RESERV_CANCELLED_BY_ADMIN => 'Бронирование прекращено',
        self::STATUS_APPLICATION_CANCELED_BY_ADMIN => 'Заявка прекращена',
        self::STATUS_APPLICATION_APPROVAL_REQUEST => 'Подтверждающие документы (отчёт-акт) отправлены',
        self::STATUS_APPLICATION_APPROVAL_PROCESS => 'Документы получены, ожидается подтверждение и оплата',
        self::STATUS_APPLICATION_SUCCESS => 'Сделка успешно завершена',
        self::STATUS_SELF_RESERVED => 'Самостоятельное бронирование',
        self::STATUS_COMISSION_PAY_CONFIRMED_BY_DEVELOPER => 'Застройщик подтвердил выплату вознаграждения',
        self::STATUS_COMISSION_PAY_CONFIRMED_BY_ADMIN => 'Администратор подтвердил получение вознаграждения от застройщика',
        self::STATUS_APPLICATION_IN_WORK_AGENT_DOCPACK_PROVIDED => 'Заявка в работе. Пакет документов от агента загружен.',
        self::STATUS_APPLICATION_IN_WORK_DEVELOPER_DOCPACK_PROVIDED => 'Заявка в работе. Пакет документов от застройщика загружен.',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    public function agency()
    {
        return $this->hasOneThrough(
            Agency::class,
            User::class,
            'id',
            'id',
            'applicant_id',
            'agency_id'
        );
    }
}
