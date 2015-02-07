<?php

namespace stp\spsr;

use stp\spsr\message\BaseMessage;
use SimpleXMLElement;


class SpsrApi
{
    const _TEST_URL = 'https://api.spsr.ru/test';

    const _URL = 'https://api.spsr.ru/';

    protected $xmlUrl = null;

    protected $login = null;
    protected $password = null;
    protected $sid = null;

    /**
     * @var \Closure|null
     */
    protected $_onSessionStart = null;

    protected $companyAgent = 'Spsr Api Agent v1.0.0';

    public function __construct($login = 'test', $password = 'test', $testMode = true)
    {
        $this->login = $login;
        $this->password = $password;
        $this->xmlUrl = $testMode ? self::_TEST_URL : self::_URL;
    }

    public function setSid($sid)
    {
        $this->sid = $sid;
    }

    /**
     * При необходимости создает сессию
     * @throws SpsrException
     * @return string|null
     */
    public function session()
    {
        if ($this->login && $this->password) {
            $agent = $this->companyAgent;
            $login = $this->login;
            $password = $this->password;
            $xml = "<root xmlns=\"http://spsr.ru/webapi/usermanagment/login/1.0\">
                    <p:Params Name=\"WALogin\" Ver=\"1.0\" xmlns:p=\"http://spsr.ru/webapi/WA/1.0\" />
                    <Login  Login=\"$login\" Pass=\"$password\" UserAgent=\"$agent\" /></root>";
            $response = $this->_request($this->xmlUrl, $xml);
            $response->Login && $this->sid = (string)$response->Login['SID'];
            if (!$this->sid) {
                $errMsg = $response->error ? (string)$response->error['ErrorMessageRU'] : '';
                throw new SpsrException('Unable to start session: ' . $errMsg);
            }
            if ($this->_onSessionStart && $this->_onSessionStart instanceof \Closure) {
                $callback = $this->_onSessionStart;
                $callback($this->sid);
            }
        }

        return $this->sid;
    }

    public function _request($url, $postData = null)
    {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);
        if ($postData) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        }

		$result = curl_exec($curl);
        if ($result === false) {
            $err = curl_error($curl);
            curl_close($curl);
            throw new SpsrException('Error on request: ' . $err);
        }
		curl_close($curl);
        libxml_use_internal_errors(true);
        $xmlResult = new SimpleXMLElement($result);
		return $xmlResult;
    }

    /**
     * @param BaseMessage $message
     * @param string|null $sid session id
     * @return response\BaseResponse
     * @throws SpsrException
     */
    public function request(BaseMessage $message, $sid = null)
    {
        $sid || $sid = $this->session();
        $message->setSid($sid);
        $response = $this->_request($this->xmlUrl, $message->asXml()->asXML());
        $this->checkError($response);
        return $message->buildResponse($response);
    }

    /**
     * Check is API response contains errors
     * @param SimpleXMLElement $response
     * @throws SpsrException
     */
    protected function checkError(SimpleXMLElement $response)
    {
        if (!isset($response->Result['RC']) || (int)$response->Result['RC'] == 0) return;
        $errorMessageEN = isset($response->error['ErrorMessageEN']) ? (string)$response->error['ErrorMessageEN'] : '';
        $errorMessageRU = isset($response->error['ErrorMessageRU']) ? (string)$response->error['ErrorMessageRU'] : '';
        $errorMessage = isset($response->error['ErrorMessage']) ? (string)$response->error['ErrorMessage'] : '';

        throw new SpsrException($errorMessageEN ?: $errorMessageRU ?: $errorMessage ?: 'Unknown Error', (int)$response->Result);
    }

}