<?php

namespace stp\spsr\message;

use stp\spsr\response\AddOrder;
use SimpleXMLElement;


/**
 * @property string $ICN ИКН
 * @property string $Login логин
 * @property string $NecesseryDate дата сбора, YYYY-MM-DDT00:00:00.000,
 * @property string $NecesseryTime время сбора, see self::NECESSERY_TIME_*
 * @property int $DeliveryMode идентификатор вида сервиса для доставки собираемого отправления, (from WAGetServices)
 * @property string $FIO ФИО отправителя
 * @property int $SborAddr_ID идентификатор адреса сбора
 * @property int $SborAddr_Owner_ID идентификатор адреса сбора
 * @property int $ReceiverCity_ID идентификаторы города получателя
 * @property int $ReceiverCity_Owner_ID идентификаторы города получателя
 * @property int $PlacesCount количество мест отправления
 * @property int $Weight вес отправления
 * @property int $Description описание отправления
 * @property int $OrderType периодичность сбора (0 – разовый сбор)
 * @property int $Length длина отправления в cm
 * @property int $Width ширина отправления в cm
 * @property int $Depth глубина отправления в cm
 */
class CreateOrderMessage extends BaseMessage
{
    /**
     * from 9:00 to 13:00
     */
    const NECESSERY_TIME_AM = 'AM';

    /**
     * from 13:00 to 18:00
     */
    const NECESSERY_TIME_PM = 'PM';

    /**
     * from 9:00 to 18:00
     */
    const NECESSERY_TIME_FM = 'FM';

    public function getRoot()
    {
        return 'AddOrder';
    }

    /**
     * Return XML method string and version, e.g. DataEditManagment/CreateOrder
     * @return string
     */
    public function getMethodString()
    {
        return 'DataEditManagment/CreateOrder';
    }

    /**
     * Return XML method string and version, e.g. 1.0
     * @return string
     */
    public function getMethodVersion()
    {
        return '1.0';
    }

    /**
     * @return AddOrder
     */
    public function buildResponse(SimpleXMLElement $response)
    {
        $result = null;
        $root = $this->getRoot();
        $attr = (array)$response->$root->attributes();
        $result = new AddOrder($attr['@attributes']);
        $result->setResponse($response);

        return $result;
    }

}
