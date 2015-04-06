<?php

namespace stp\spsr\message;
use SimpleXMLElement;
use stp\spsr\response\City;

/**
 * Class GetCitiesMessage
 * @property string $CityName Первые буквы наименования города или его полное название
 */
class GetCitiesMessage extends BaseXmlMessage
{
    public function getRoot()
    {
        return 'GetCities';
    }

    public function isRequiredICN()
    {
        return false;
    }

    public function isRequiredLogin()
    {
        return false;
    }

    public function isRequiredLoginNode()
    {
        return false;
    }


    /**
     * Return XML method name e.g. DataEditManagment/CreateOrder
     * @return string
     */
    public function getMethodString()
    {
        return 'Info/GetCities';
    }

    /**
     * @param SimpleXMLElement $response
     * @return City[]
     */
    public function buildResponse(SimpleXMLElement $response)
    {
        $result = [];
        foreach($response->City->Cities as $city) {
            $result[] = self::xmlNode2Type($city, City::className());
        }

        return $result;
    }

}
