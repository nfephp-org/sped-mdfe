<?php

namespace Test\NFePHP\MDFe;

/**
 * Class MakeMDFeTest
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\MDFe\Make;
use PHPUnit_Framework_TestCase;

class MakeTest extends PHPUnit_Framework_TestCase
{
    public function testOMetodoTagemitDeveGerenciarCamposOpcionais()
    {
        $makeMdfe = new Make();
        $emitDOMElement = $makeMdfe->tagemit(
            $CNPJ = '06539526000392',
            $IE = '9057800426',
            $xNome = 'CT-E EMITIDO EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL',
            $xFant = 'CT-E EMITIDO'
        );

        $expectedXml = "<emit>
            <CNPJ>$CNPJ</CNPJ>
            <IE>$IE</IE>
            <xNome>$xNome</xNome>
            <!--Optional:-->
            <xFant>$xFant</xFant>
        </emit>";
        $actualXml = $emitDOMElement->ownerDocument->saveXML($emitDOMElement);
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml);

        $xFant = null;
        $emitDOMElement = $makeMdfe->tagemit($CNPJ, $IE, $xNome, $xFant);
        $actualXml = $emitDOMElement->ownerDocument->saveXML($emitDOMElement);
        $this->assertXmlStringNotEqualsXmlString($expectedXml, $actualXml);

        $expectedXml = "<emit>
            <CNPJ>$CNPJ</CNPJ>
            <IE>$IE</IE>
            <xNome>$xNome</xNome>
        </emit>";
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml);
    }
}
