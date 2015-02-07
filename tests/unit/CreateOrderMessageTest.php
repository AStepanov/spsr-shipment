<?php


class CreateOrderMessageTest extends \Codeception\TestCase\Test
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

    // tests
    public function testMinimalDocument()
    {

        $msg = new stp\spsr\message\CreateOrderMessage();
        $msg->ICN = 7600010711;
        $msg->Login = 'test';
        $msg->NecesseryDate = '2015-02-07T00:00:00.000';
        $msg->NecesseryTime = 'PM';
        $msg->DeliveryMode = 0;
        $msg->FIO = 'Aaren Aarenson';
        $msg->PlacesCount = 1;
        $msg->SborAddr_ID = 1443433906;
        $msg->SborAddr_Owner_ID = 11;
        $msg->Description = 'Some documents description';
        $msg->OrderType = 0;
        $msg->Length = 1;
        $msg->Width = 1;
        $msg->Weight = 1;
        $msg->Depth = 1;

        $this->assertInternalType('string', $msg->asXml()->asXML());
    }

}