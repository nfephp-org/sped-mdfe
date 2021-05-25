<?php


namespace NFePHP\MDFe\Tests\Helpers;

/**
 * Essa classe tem o objetivo de encapsular os parâmetros enviados para o método SoapInterface::send
 *
 * @package NFePHP\MDFe\Tests\Helpers
 */
class FakeSoapSendParams
{
    public $url;
    public $operation;
    public $action;
    public $soapver;
    public $parameters;
    public $namespaces;
    public $request;
    public $soapheader;

    public function __construct($url, $operation, $action, $soapver, $parameters, $namespaces, $request, $soapheader)
    {
        $this->url = $url;
        $this->operation = $operation;
        $this->action = $action;
        $this->soapver = $soapver;
        $this->parameters = $parameters;
        $this->namespaces = $namespaces;
        $this->request = $request;
        $this->soapheader = $soapheader;
    }


    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getSoapver()
    {
        return $this->soapver;
    }

    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return mixed
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getSoapheader()
    {
        return $this->soapheader;
    }



}
