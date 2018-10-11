<?php

/**
 * Class WebservicesTest
 * @author Diogo Bemfica <diogo.fragabemfica@gmail.com>
 */

use NFePHP\MDFe\Common\Webservices;
use PHPUnit\Framework\TestCase;

class WebservicesTest extends TestCase
{
    /**
     * @var Webservices
     */
    protected $webservices;

    protected function setUp()
    {
        $this->webservices = new Webservices();
    }

    public function testGet()
    {
        $std = $this->webservices->get('RS','homologacao','MDFeRecepcao');

        $this->assertInstanceOf(\StdClass::class, $std);
        $this->assertEquals('mdfeRecepcaoLote', $std->method);
        $this->assertEquals('MDFeRecepcao', $std->operation);
        $this->assertEquals('3.00', $std->version);
        $this->assertEquals('https://mdfe-homologacao.svrs.rs.gov.br/ws/MDFerecepcao/MDFeRecepcao.asmx', $std->url);
    }
}
