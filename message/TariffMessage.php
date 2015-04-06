<?php

namespace stp\spsr\message;
use stp\spsr\response\Tariff;
use SimpleXMLElement;

/**
 * Запрос доступных тарифов
 *
 * @property string $ToCity Идентификаторы города получателя ID|Owner_ID
 * @property string $FromCity Идентификаторы города отправителя ID|Owner_ID
 * @property string $Weight Вес отправления, кг (граммы указываются через точку) – наибольшее значение между физическим и объемным весом
 * @property int|null $Nature Характер груза, см. TariffMessage::TYPE_*
 * @property string|null $Amount Оценочная стоимость, руб (Используется совместно с параметром AmountCheck)
 * @property int|null $AmountCheck Значение Amount по страхованию объявления или тариф за объявленную стоимость. см. INSURANCE_*
 * @property int|null $SMS CМС оповещение отправителя, 0 – нет, 1 – да
 * @property int|null $SMS_Recv CМС оповещение получателя, 0 – нет, 1 – да
 * @property int|null $PlatType Кто платит (по умолчанию отправитель) см. TariffMessage::PAY_BY_*
 * @property int|null $DuesOrder Сбор по заявке, 0 – нет, 1 – да
 * @property int|null $ByHand Доставка в руки, 0 – нет, 1 – да
 * @property int|null $icd Индивидуальный контроль доставки, 0 – нет, 1 – да
 * @property int|null $ToBeCalledFor Доп.услуга "До востребования", 0 – нет, 1 – да
 * @property int|null $Weight35 Есть хотя бы одно место весом больше 35 кг, 0 – нет, 1 – да
 * @property int|null $Weight80 Есть хотя бы одно место весом больше 35 кг, 0 – нет, 1 – да
 * @property int|null $Weight200 Есть хотя бы одно место весом больше 35 кг, 0 – нет, 1 – да
 * @property int|null $GabarythB Есть хотя бы одно место с габаритами (длина+ширина+высота) более 180 см, 0 – нет, 1 – да
 * @property string|null $SID Идентификатор сессии
 * @property string|null $ICN ИКН
 */
class TariffMessage extends BaseMessage
{
    static $url = 'http://www.cpcr.ru/cgi-bin/postxml.pl';

    /**
     * Документы и печатная продукция
     */
    const TYPE_DOC = 1;

    /**
     * Документы и печатная продукция
     */
    const TYPE_DOC_15 = 15;

    /**
     * Товары народного потребления (без техники)
     */
    const TYPE_FMCG = 2;

    /**
     * Товары народного потребления (без техники)
     */
    const TYPE_FMCG_16 = 16;

    /**
     * Техника и электроника без ГСМ (единичное количество)
     */
    const TYPE_ELECTRONICS = 17;

    /**
     * Драгоценности
     */
    const TYPE_JEWELRY = 18;

    /**
     * Медикаменты и БАДы
     */
    const TYPE_MEDICINES = 19;

    /**
     * Косметика и парфюмерия
     */
    const TYPE_COSMETICS = 20;

    /**
     * продукты питания (партия)
     */
    const TYPE_FOODSTUFFS = 21;

    /**
     * Техника и электроника c ГСМ (партия)
     */
    const TYPE_ELECTRONICS_LOT = 22;

    /**
     * опасные грузы
     */
    const TYPE_DANGEROUS_GOODS = 23;

    /**
     * товары народного потребления (без техники, партия)"
     */
    const TYPE_FMCG_LOT = 24;

    /**
     * Страхование отправлений/грузов
     */
    const INSURANCE_INS = 1;

    /**
     * Доставка отправлений с объявленной ценностью
     */
    const INSURANCE_VAL = 0;

    /**
     * Платит отправитель
     */
    const PAY_BY_SENDER = 1;

    /**
     * Платит получатель
     */
    const PAY_BY_RECEIVER = 2;

    public function isRequiredLogin()
    {
        return false;
    }

    /**
     * Return tariff request url
     * @return string
     */
    public function getRequestUrl()
    {
        $url = self::$url . '?TARIFFCOMPUTE_2&';
        if ($this->_dataRaw) {
            $url .= http_build_query($this->_dataRaw);
        }

        return $url;
    }

    /**
     * Create response object
     *
     * @param SimpleXMLElement $response
     * @return Tariff[]
     */
    public function buildResponse(SimpleXMLElement $response)
    {
        $result = [];
        foreach($response->Tariff as $tariff) {
            $result[] = new Tariff((array)$tariff);
        }

        return $result;
    }

}
