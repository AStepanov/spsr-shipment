<?php

namespace stp\spsr\message;

/**
 * Метод позволяет сделать связь между активным заказом и накладными.
 *
 * @property string $ICN
 * @property string $Login
 * @property string $InvoiceNumber номер накладной в ИС «СПСР-Экспресс»
 * @property int $Order_ID идентификатор активного заказа (см GetActiveOrders)
 * @property int $Order_Owner_ID идентификатор активного заказа (см GetActiveOrders)
 */
class BindOrderToInvoiceMessage extends BaseXmlMessage
{
    public function getRoot()
    {
        return 'Invoice';
    }

    /**
     * Return XML method name e.g. DataEditManagment/CreateOrder
     *
     * @return string
     */
    public function getMethodString()
    {
        return 'DataEditManagment/BindOrderToInvoice';
    }

}
