<?php

namespace stp\spsr;

use SimpleXMLElement;

class BaseType
{

    protected $_dataRaw = [];

    function __construct(array $data = null)
    {
        $data && $this->_dataRaw = $data;
    }

    function __get($name)
    {
        return isset($this->_dataRaw[$name]) ? $this->_dataRaw[$name] : null;
    }

    function __set($name, $value)
    {
        $this->_dataRaw[$name] = $value;
    }

    /**
     * Add element to collection
     * @param string $name
     * @param mixed $value
     */
    public function push($name, $value)
    {
        if (!isset($this->_dataRaw[$name])) $this->_dataRaw[$name] = [];
        array_push($this->_dataRaw[$name], $value);
    }

    /**
     *
     * @param string|null $forceXmlNs
     * @return SimpleXMLElement
     */
    public function asXml($forceXmlNs = null)
    {
        $xmlNs = $forceXmlNs ? "xmlns=\"$forceXmlNs\"" : '';
        $fullName = substr(get_called_class(), 0, -4);
        $nodeName = explode('\\', $fullName);
        $nodeName = end($nodeName);
        $xml = new SimpleXMLElement("<$nodeName $xmlNs />");
        foreach($this->_dataRaw as $attr => $value) {
            if (is_scalar($value)) {
                $xml->addAttribute($attr, $value);
            } elseif ($value instanceof BaseType) {
                $this->xml_append($xml, $value->asXml($forceXmlNs));
            } elseif(is_array($value)) {
                $listNode = $xml->addChild($attr);
                foreach ($value as $subValue) {
                    $this->xml_append($listNode, $subValue instanceof BaseType ? $subValue->asXml($forceXmlNs) : $value);
                }
            }
        }

        return $xml;
    }

    /**
     * @param SimpleXMLElement $to
     * @param SimpleXMLElement $from
     */
    protected function xml_append(SimpleXMLElement $to, SimpleXMLElement $from) {
        $toDom = dom_import_simplexml($to);
        $fromDom = dom_import_simplexml($from);
        $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
    }

    /**
     * @return string the fully qualified name of this class.
     */
    public static function className()
    {
        return get_called_class();
    }

    /**
     * @param SimpleXMLElement $node
     * @param string $typeName BaseType class name
     * @return BaseType
     */
    static protected function xmlNode2Type(SimpleXMLElement $node, $typeName)
    {
        $attr = (array)$node->attributes();
        return new $typeName($attr['@attributes']);
    }

}
