<?php


namespace NFePHP\MDFe\Tests\Helpers;


use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapInterface;
use Psr\Log\LoggerInterface;

/**
 * Classe criada com o objetivo de interceptar as comunicações com o webservice real viabilizando testes
 *
 * @package NFePHP\MDFe\Tests\Helpers
 */
class FakeSoap implements SoapInterface
{
    /** @var \NFePHP\MDFe\Tests\Helpers\FakeSoapSendParams|null */
    public $sendParams;
    public $sendReturnValue = "";

    public function loadCertificate(Certificate $certificate)
    {
        // TODO: Implement loadCertificate() method.
    }

    public function loadLogger(LoggerInterface $logger)
    {
        // TODO: Implement loadLogger() method.
    }

    public function timeout($timesecs)
    {
        // TODO: Implement timeout() method.
    }

    public function protocol($protocol = self::SSL_DEFAULT)
    {
        // TODO: Implement protocol() method.
    }

    public function proxy($ip, $port, $user, $password)
    {
        // TODO: Implement proxy() method.
    }

    public function httpVersion($version = null)
    {
        // TODO: Implement httpVersion() method.
    }

    public function disableSecurity($flag = false)
    {
        // TODO: Implement disableSecurity() method.
    }

    public function disableCertValidation($flag = true)
    {
        // TODO: Implement disableCertValidation() method.
    }

    public function setEncriptPrivateKey($encript = true)
    {
        // TODO: Implement setEncriptPrivateKey() method.
    }

    public function setTemporaryFolder($folderRealPath = null)
    {
        // TODO: Implement setTemporaryFolder() method.
    }

    public function setDebugMode($value = false)
    {
        // TODO: Implement setDebugMode() method.
    }

    public function setSoapPrefix($prefixes = [])
    {
        // TODO: Implement setSoapPrefix() method.
    }

    public function send($url, $operation = '', $action = '', $soapver = SOAP_1_2, $parameters = [], $namespaces = [], $request = '', $soapheader = null)
    {
        $this->sendParams = new FakeSoapSendParams($url, $operation, $action, $soapver, $parameters, $namespaces, $request, $soapheader);
        return $this->sendReturnValue;
    }

    public function setSendReturnValue($value)
    {
        $this->sendReturnValue = $value;
    }

    /**
     * @return \NFePHP\MDFe\Tests\Helpers\FakeSoapSendParams|null
     */
    public function getSendParams()
    {
        return $this->sendParams;
    }
}
