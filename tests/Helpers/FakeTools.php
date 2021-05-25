<?php


namespace NFePHP\MDFe\Tests\Helpers;


use NFePHP\Common\Certificate;
use NFePHP\MDFe\Tools;

/**
 * Class FakeTools
 * Tem o objetivo de encapsular a classe Tools para que não haja a comunicação com o webservice REAL
 *
 * @package NFePHP\MDFe\Tests\Helpers
 */
class FakeTools extends Tools
{
    public function __construct($configJson, Certificate $certificate)
    {
        parent::__construct($configJson, $certificate);
        $this->loadSoapClass(new FakeSoap());
    }

    /**
     * @return \NFePHP\MDFe\Tests\Helpers\FakeSoapSendParams
     */
    public function getSendParams()
    {
        /** @var \NFePHP\MDFe\Tests\Helpers\FakeSoap $soap */
        $soap = $this->soap;
        return $soap->getSendParams();
    }
}
