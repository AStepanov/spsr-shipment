<?php


namespace stp\spsr\type;

use stp\spsr\BaseType;


/**
 * СМС оповещения
 *
 * @property int|null $SMStoShipper	Дополнительная услуга "SMS-оповещение Отправителя".
 * @property string|null $SMSNumberShipper Номер телефона для SMS-оповещения Отправителя в формате: "8" плюс код города плюс семь цифр телефона без разделителей между ними
 * @property int|null $SMStoReceiver Дополнительная услуга "SMS-оповещение Получателя".
 * @property string|null $SMSNumberReceiver Номер телефона для SMS-оповещения получателя, в формате: "84950000000", eсли телефон не указан, то  сохраняется номер, указанный в атрибуте Phone тега <Receiver>
 */
class SMSType extends BaseType
{

}
