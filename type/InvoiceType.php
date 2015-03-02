<?php
namespace stp\spsr\type;

use SimpleXMLElement;
use stp\spsr\BaseType;

/**
 * @property string $Action Invoice action (create/update), see InvoiceType::ACTION_*.
 * Если для накладной, которая отсутствует в ИС, задано значение "U", то в ИС будет создана новая накладная.
 * Если задано значение "U" для накладной, которая уже существует в ИС, то в теге <Invoice> должен быть задан один из атрибутов: ShipmentNumber или ShipRefNum, а также указана информация по всем вложимым этой накладной
 * @property int|null $ShipmentNumber Номер накладной
 * @property string|null $ShipRefNum Уникальный номер отправления, присвоенный отправителем
 * @property string $PickUpType Вид приема (Вызов курьера (C) или самопривоз на склад СПСР (W)), see InvoiceType::PICKUP_TYPE_*
 * @property string $ProductCode Вид сервиса (режим доставки)
 * @property string|null $FullDescription Полная информация о содержимом отправления - вложимом
 * @property int $PiecesCount Количество вложимых в накладной
 * @property string|null $DeliveryDate Желаемая дата доставки. Окончательная дата будет согласована в с получателем (ГГГГММДД)
 * @property string|null $DeliveryTime Удобное время доставки. Окончательное время будет согласовано в с получателем. Интервалы "AM1", "PM1", "PM2", "WD1" возможны при COD="1" с доставкой по Москве и весом по накладной менее 10кг.
 * @property string $InsuranceType "VAL"- заявлена услуга "Доставка отправлений с объявленной ценностью". Если в файле хотя бы для одного атрибута Description тега <Piece> задано значение "18" -  драгоценности, то в данном атрибуте может быть задано только значение "INS"                                                             "	Дополнительные услуги "Страхование отправлений/грузов" и "Доставка отправлений с объявленной ценностью". Услуги доступны только для определенных сервисов (см. таблицу "Использование дополнительных услуг для сервисов" на листе "Доп. услуги и вложимое сервисов"). Если не требуется страхование и услуга доставка с объявленной ценностью, то данный атрибут всё равно должен быть заполнен, но при этом укажите в InsuranceSum значение ="0.00"
 * @property float $InsuranceSum Если для атрибута InsuranceType задано значение "VAL", то максимальное значение стоимости - "499999.99"	Стоимость оценки отправления. Может иметь значение ="0.00"
 * @property float $CODGoodsSum Стоимость товара наложенным платежом в рублях. Данный атрибут может быть задан, если для атрибута COD задано значение "1". Если для атрибута COD задано значение "0" или оно опустое, то значение атрибута CODDeliverySum игнорируется
 * @property float $CODDeliverySum Сумма - сумма, которая взымается с получателя и передается отправителю, "0" или пусто - деньги за доставку с получателя не берутся"	Стоимость доставки наложенным платежом в рублях, вы можете указать желаемую стоимость доставки, которую курьер будет брать с получателя. Она может отличаться от стоимости доставки по тарифам СПСР. Данный атрибут может быть задан, если для атрибута COD задано значение "1". Если для атрибута COD задано значение "0" или оно опустое, то значение атрибута CODDeliverySum игнорируется *
 *
 * @property ReceiverType $Receiver
 * @property ShipperType $Shipper
 * @property CustomerInfoType $CustomerInfo
 * @property AdditionalServicesType $AdditionalServices
 * @property SMSType $SMS
 * @property PieceType[] $Pieces
 */
class InvoiceType extends BaseType
{
    /**
     * New Invoice Action
     */
    const ACTION_NEW = 'N';

    /**
     * Update Invoice Action
     */
    const ACTION_UPDATE = 'U';

    /**
     * Cамопривоз на склад СПСР
     */
    const PICKUP_TYPE_SELF = 'W';

    /**
     * Вызов курьера
     */
    const PICKUP_TYPE_COURIER = 'C';

    const PRODUCT_DOX = 'Dox';
    const PRODUCT_GEP_13 = 'Gep13';
    const PRODUCT_GEP_18 = 'Gep18';
    const PRODUCT_GEP_EX = 'GepEx';
    const PRODUCT_PEL_ST = 'PelSt';
    const PRODUCT_PEL_EC = 'PelEc';
    const PRODUCT_PEL_ON = 'PelOn';
    const PRODUCT_BIS_AV = 'BisAv';
    const PRODUCT_BIS_CA = 'BisCa';
    const PRODUCT_FREIG = 'Freig';

    static $productTypes = [
        self::PRODUCT_DOX => 'Колибри-документ',
        self::PRODUCT_GEP_13 => 'Гепард-Экспресс 13',
        self::PRODUCT_GEP_18 => 'Гепард-Экспресс 18',
        self::PRODUCT_GEP_EX => 'Гепард-Экспресс',
        self::PRODUCT_PEL_ST => 'Пеликан-Стандарт',
        self::PRODUCT_PEL_EC => 'Пеликан-Эконом',
        self::PRODUCT_PEL_ON => 'Пеликан-Онлайн',
        self::PRODUCT_BIS_AV => 'Бизон-Авиа',
        self::PRODUCT_BIS_CA => 'Бизон-Карго',
        self::PRODUCT_FREIG => 'Фрахт'
    ];

    /**
     * Страхование отправлений/грузов
     */
    const INSURANCE_INS = 'INS';

    /**
     * Доставка отправлений с объявленной ценностью
     */
    const INSURANCE_VAL = 'VAL';

}
