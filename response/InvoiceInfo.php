<?php

namespace stp\spsr\response;

use stp\spsr\type\ShipperType;
use stp\spsr\type\ReceiverType;
use stp\spsr\type\PieceType;

/**
 * Ответ на запрос по накладной
 *
 * @property string $ContractNumber ИКН
 * @property string $Action режим работы с накладной (в ответе на запрос всегда "R" - Response)
 * @property string $ShipmentNumber номер накладной СПСР
 * @property string $ShipRefNum номер присвойки (номер заказ клиента)
 * @property string $PickUpType вид приема отправления (С - вызов курьера, W - самопривоз на склад СПСР)
 * @property string $ProductCode вид сервиса (режим доставки)
 * @property string $FullDescription полная информация о вложимом
 * @property string $InsuranceSum сумма страхования
 * @property string $DeclaredSum объявленная ценность
 * @property string $CODGoodsSum cтоимость товара наложенным платежом в рублях
 * @property string $CODDeliverySum cтоимость доставки наложенным платежом в рублях
 * @property string $SBits служебная информация, может быть удалена в следующих версиях
 * @property string $OrderNumber номер заказа на вызов курьера
 * @property string $CurState текущий статус Обработка/Доставлено/Не доставлено
 * @property string $DeliveryDT дата и время доставки в случае, если статус не «Обработка» (в противном случае – пусто)
 * @property string $AgreedDate – дата согласованной даты доставки (в формате ГГГГ- ММ-ДД)
 * @property ShipperType $Shipper информация об отправителе
 * @property ReceiverType $Receiver информация о получателе
 * @property PieceType[] $Pieces информация о вложимых накладной
 */
class InvoiceInfo extends BaseResponse
{
    const STATE_IN_PROGRESS = 'Обработка';
    const STATE_FINISHED = 'Доставлено';

    /**
     * @return bool
     */
    public function isDelivered()
    {
        return $this->CurState && mb_strpos($this->CurState, self::STATE_FINISHED, null, 'utf-8') !== false;
    }

}
