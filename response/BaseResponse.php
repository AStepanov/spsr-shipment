<?php

namespace stp\spsr\response;

use stp\spsr\BaseType;
use SimpleXMLElement;

class BaseResponse extends BaseType
{
    /**
     * @var SimpleXMLElement
     */
    protected $_response;

    /**
     * @param SimpleXMLElement $response
     */
    public function setResponse(SimpleXMLElement $response)
    {
        $this->_response = $response;
    }

    /**
     * @return SimpleXMLElement|null
     */
    public function getResponse()
    {
        return $this->_response;
    }


}