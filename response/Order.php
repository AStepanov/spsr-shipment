<?php

namespace stp\spsr\response;

/**
 * Информация по заказу
 *
 * @property string $Order_ID идентификаторы заказа
 * @property string $Order_Owner_ID идентификаторы заказа
 * @property string $OrderNumber номер заказа
 * @property string $OrderState состояние заказа
 * @property string $DateOfCreate дата создания заказа
 * @property string $PlaningDT_From планируемая дата и время сбора
 * @property string $PlaningDT_To планируемая дата и время сбора
 * @property string $FIO ФИО оператора
 * @property string $CityName наименование города сбора
 * @property string $Address адрес сбора
 */
class Order extends BaseResponse
{

}