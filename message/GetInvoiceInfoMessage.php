<?php

namespace stp\spsr\message;

use stp\spsr\BaseType;
use stp\spsr\response\InvoiceInfo;
use stp\spsr\SpsrException;
use stp\spsr\type\InvoiceInfoType;
use stp\spsr\type\ShipperType;
use stp\spsr\type\ReceiverType;
use stp\spsr\type\PieceType;
use SimpleXMLElement;


/**
 * @property string $Login
 * @property string $ICN
 * @property InvoiceInfoType[] $InvoiceInfo
 * string|null $BarCode
 */
class GetInvoiceInfoMessage extends BaseXmlMessage
{
    public function getRoot()
    {
        return 'InvoiceInfo';
    }

    /**
     * Return XML method name e.g. DataEditManagment/GetInvoiceInfo
     * @return string
     */
    public function getMethodString()
    {
        return 'DataEditManagment/GetInvoiceInfo';
    }

    public function getMethodVersion()
    {
        return '1.1';
    }

    protected function buildContentNode(SimpleXMLElement $xmlNode)
    {
        $this->ICN && $xmlNode->Login->addAttribute('ICN', $this->ICN);
        $this->Login && $xmlNode->Login->addAttribute('Login', $this->Login);
        if (!$this->InvoiceInfo) {
            throw new \RuntimeException('InvoiceInfo attribute can\'t be empty');
        }
        foreach($this->InvoiceInfo as $invoice) {
            $this->xml_append($xmlNode, $invoice->asXml($this->getXmlNs()));
        }
    }

    /**
     * @param SimpleXMLElement $response
     * @return InvoiceInfo[]
     */
    public function buildResponse(SimpleXMLElement $response)
    {
        $result = [];
        foreach($response->GetInvoiceInfo->Invoice as $invoiceInfo) {
            /** @var InvoiceInfo $invoice */
            $invoice = self::xmlNode2Type($invoiceInfo, InvoiceInfo::className());
            $invoice->Shipper = self::xmlNode2Type($invoiceInfo->Shipper, ShipperType::className());
            $invoice->Receiver = self::xmlNode2Type($invoiceInfo->Receiver, ReceiverType::className());
            foreach($invoiceInfo->Pieces->Piece as $piece) {
                $invoice->push('Pieces', self::xmlNode2Type($piece, PieceType::className()));
            }
            $result[] = $invoice;
        }

        return $result;
    }

    /**
     * Добавляет Invoice в запрос для поиска
     * Необходимо указать как минимум один параметр
     *
     * @param string|null $InvoiceNumber
     * @param string|null $GCInvoiceNumber
     * @param string|null $BarCode
     * @return bool
     */
    public function addInvoice($InvoiceNumber = null, $GCInvoiceNumber = null, $BarCode = null)
    {
        if (!$InvoiceNumber && !$GCInvoiceNumber && !$BarCode) return false;
        $invoiceInfo = new InvoiceInfoType();
        $InvoiceNumber && $invoiceInfo->InvoiceNumber = $InvoiceNumber;
        $GCInvoiceNumber && $invoiceInfo->GCInvoiceNumber = $GCInvoiceNumber;
        $BarCode && $invoiceInfo->BarCode = $BarCode;
        $this->push('InvoiceInfo', $invoiceInfo);
        return true;
    }
}
