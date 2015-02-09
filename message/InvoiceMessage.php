<?php

namespace stp\spsr\message;

use stp\spsr\response\Invoice;
use stp\spsr\type\InvoiceType;
use SimpleXMLElement;

/**
 * @property int $ContractNumber ICN
 * @property int|null $TotalShipments Общее количество накладных в реестре
 * @property float|null $TotalInsurance Суммарная оценочная стоимость (в рублях) - сумма значений атрибутов InsuranceSum по всем накладным, для которых для атрибута InsuranceType задано значение "INS"
 * @property float|null $TotalDeclared Суммарная объявленная ценность (в рублях) - сумма значений атрибутов InsuranceSum по всем накладным, для которых для атрибута InsuranceType задано значение "VAL"
 * @property float|null $TotalCOD Сумма наложенного платежа в рублях по накладным с дополнительной услугой "Оплата товара в момент вручения". Если заданы значения атрибутов и TotalCOD и Cost, то значение атрибута TotalCOD игнорируется
 * @property int|null $TotalPieces Общее количество вложимых во всех накладных
 * @property float|null $TotalWeight Общий вес (в кг) всех вложимых во всех накладных
 * @property InvoiceType[] $Invoices Общий вес (в кг) всех вложимых во всех накладных
 *
 */
class InvoiceMessage extends BaseMessage
{
    public function isRequiredICN()
    {
        return 'ContractNumber';
    }

    public function isRequiredLogin()
    {
        return false;
    }

    public function getRoot()
    {
        return 'XmlConverter';
    }

    /**
     * Return XML method name e.g. DataEditManagment/CreateOrder
     * @return string
     */
    public function getMethodString()
    {
        return 'xmlconverter';
    }

    public function getMethodVersion()
    {
        return '1.3';
    }

    public function getParamName()
    {
        return 'WAXmlConverter';
    }

    protected function buildContentNode(SimpleXMLElement $xmlNode)
    {
        $content = $xmlNode->addChild($this->getRoot());
        $info = $content->addChild('GeneralInfo');

        foreach($this->_dataRaw as $attr => $value) {
            if ($attr == 'Invoices') continue;
            $info->addAttribute($attr, $value);
        }
        if (!$this->Invoices) {
            throw new \RuntimeException('Invoice attribute should be not empty');
        }
        foreach($this->Invoices as $invoice) {
            $this->xml_append($info, $invoice->asXml($this->getXmlNs()));
        }
    }

    /**
     * @return Invoice[]
     */
    public function buildResponse(SimpleXMLElement $response)
    {
        $result = [];
        foreach($response->Invoice as $invoice) {
            $attr = (array)$invoice->attributes();
            $result[] = new Invoice($attr['@attributes']);
        }

        return $result;
    }

}
