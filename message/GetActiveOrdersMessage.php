<?php

namespace stp\spsr\message;

use stp\spsr\response\Order;

/**
 * Просмотр списка активных заказов на сбор.
 *
 * Позволяет получить список активных заказов на сбор.
 *
 * @property string $ICN
 * @property string $Login
 */
class GetActiveOrdersMessage extends BaseMessage
{
    public function getRoot()
    {
        return 'ActiveOrders';
    }

    /**
     * Return XML method name e.g. DataEditManagment/CreateOrder
     * @return string
     */
    public function getMethodString()
    {
        return 'DataEditManagment/GetActiveOrders';
    }

    /**
     * @param \SimpleXMLElement $response
     * @return \stp\spsr\response\Order[]
     */
    public function buildResponse(\SimpleXMLElement $response)
    {
        $result = [];
        foreach($response->Orders->Order as $order) {
            $result[] = self::xmlNode2Type($order, Order::className());
        }

        return $result;
    }

}
