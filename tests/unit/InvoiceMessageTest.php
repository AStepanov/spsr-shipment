<?php

namespace stp\spsr\tests;

use Codeception\Util\Stub;
use Codeception\Specify;
use stp\spsr\message\InvoiceMessage;
use stp\spsr\type\InvoiceType;
use stp\spsr\type\PieceType;
use stp\spsr\type\ReceiverType;
use stp\spsr\type\ShipperType;

class InvoiceMessageTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testMinimalDocument()
    {
        $message = new InvoiceMessage(['ContractNumber' => 7600010711]);
        $message->setSid('somesid32lensomesid32lensomesid32len');
        $piece = new PieceType(['Description' => PieceType::TYPE_DOC]);
        $invoice = new InvoiceType([
            'Action' => InvoiceType::ACTION_NEW,
            'PickUpType' => InvoiceType::PICKUP_TYPE_COURIER,
            'ProductCode' => InvoiceType::PRODUCT_DOX,
            'PiecesCount' => 1,
            'InsuranceType' => "VAL",
            'Pieces' => [$piece]
        ]);

        $addrExample = [
            'Region' => 'Москва',
            'City' => 'Москва',
            'Address' => 'SOme addr'
        ];

        $invoice->Shipper = new ShipperType($addrExample);
        $invoice->Receiver = new ReceiverType($addrExample);

        $message->Invoices = [$invoice];
        $dom = dom_import_simplexml($message->asXml());

        $this->assertTrue(
            $dom->ownerDocument->schemaValidate(codecept_data_dir('XmlConverter_13.xsd')),
            'Invalid xml document'
        );
        $dom->ownerDocument->schemaValidate(codecept_data_dir('XmlConverter_13.xsd'));



    }

}