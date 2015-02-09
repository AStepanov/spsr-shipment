<?php


namespace stp\spsr\message;

use stp\spsr\response\Address;

/**
 * @property string $Login
 * @property string $ICN
 * @property int $AddressType
 */
class GetAddressMessage extends BaseMessage
{

    public function getRoot()
    {
        return 'AddrList';
    }

    /**
     * Return XML method name e.g. DataEditManagment/CreateOrder
     * @return string
     */
    public function getMethodString()
    {
        return 'DataEditManagment/GetAddress';
    }

    /**
     * @return Address[]
     */
    public function buildResponse(\SimpleXMLElement $response)
    {
        $result = [];
        $root = $this->getRoot();
        foreach($response->$root->Address as $addr) {
            $result[] = self::xmlNode2Type($addr, Address::className());
        }

        return $result;
    }

}