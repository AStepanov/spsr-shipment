<?php

namespace stp\spsr\type;


use stp\spsr\BaseType;

/**
 *
 * @property string|null $PostCode Почтовый индекс отправителя
 * @property string|null $Country Страна получателя
 * @property string $Region	Название региона, полученное методом WAGetCities.
 * @property string $City Населенный пункт получателя. Город, указанный в атрибуте City, должен находиться в регионе, указанном в данном атрибуте (для проверки соответствия необходимо использовать метод WAGetCities)
 * @property string $Address Адрес получателя в формате: улица, дом, строение, квартира/офис, код домофона
 * @property string|null $CompanyName Наименование организации-получателя
 * @property string|null $ContactName Ф. И. О. (полностью с пробелами) получателя
 * @property string|null $Phone Контактные телефоны получателя: номера телефонов с "8" и кодом города через запятую. Желательно указывать мобильный и стационарный телефоны. Первый номер телефона должен быть не длинее 20 символов
 */
class ShipperType extends BaseType
{

}