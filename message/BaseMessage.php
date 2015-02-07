<?php

namespace stp\spsr\message;

use SimpleXMLElement;
use stp\spsr\BaseType;
use stp\spsr\response\BaseResponse;

abstract class BaseMessage extends BaseType
{
    protected $sid;

    abstract public function getRoot();

    /**
     * Return XML method name e.g. DataEditManagment/CreateOrder
     * @return string
     */
    abstract public function getMethodString();

    public function getParamName()
    {
        $fullName = get_called_class();
        $names = explode('\\', $fullName);
        return 'WA' . substr(end($names), 0, -7);
    }

    /**
     * Return XML method version, e.g. 1.0
     * @return string
     */
    public function getMethodVersion()
    {
        return '1.0';
    }

    public function setSid($sid)
    {
        $this->sid = $sid;
    }

    protected function buildContentNode(SimpleXMLElement $xmlNode)
    {
        $el = $xmlNode->addChild($this->getRoot());
        foreach($this->_dataRaw as $attr => $value) {
            $el->addAttribute($attr, $value);
        }
    }

    /**
     * @return string
     */
    protected function getXmlNs()
    {
        return sprintf("http://spsr.ru/webapi/%s/%s", $this->getMethodString(), $this->getMethodVersion());
    }

    /**
     * @return SimpleXMLElement
     */
    public function asXml()
    {
        $version = $this->getMethodVersion();
        $xmlNode = new SimpleXMLElement("<root xmlns=\"{$this->getXmlNs()}\"/>");

        $params = $xmlNode->addChild('p:Params', null, 'http://spsr.ru/webapi/WA/1.0');
        $params->addAttribute('Name', $this->getParamName());
        $params->addAttribute('Ver', $version);

        $login = $xmlNode->addChild('Login');
        $login->addAttribute('SID', $this->sid);
        $this->buildContentNode($xmlNode);

        return $xmlNode;
    }

    /**
     * Create response object
     *
     * @param SimpleXMLElement $response
     * @return BaseResponse
     */
    public function buildResponse(SimpleXMLElement $response)
    {
        $res = new BaseResponse();
        $res->setResponse($response);
        return $res;
    }

}
