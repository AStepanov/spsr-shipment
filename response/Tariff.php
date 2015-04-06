<?php

namespace stp\spsr\response;

/**
 * Ответ описания тарифа
 *
 * @property string $TariffType наименование тарифа
 * @property float $Total_Dost сумма тарифа сумма за дополнительные услуги (смс и т.д)
 * @property float $Total_DopUsl сумма страховки
 * @property float $worth тариф за объявленную стоимость
 * @property string $DP сроки доставки (<min> - <max>)
 */
class Tariff extends BaseResponse
{

}
