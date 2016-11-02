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

    public function testOMetodoTagenderemitDeveGerenciarCamposOpcionais()
    {
        $makeMdfe = new Make();
        $enderEmitDOMElement = $makeMdfe->tagenderEmit(
            $xLgr = 'ALD TITO MUFFATO',
            $nro = '290',
            $xCpl = 'SALA 04',
            $xBairro = 'JARDIM ITAMARATY',
            $cMun = '4108304',
            $xMun = 'Foz do Iguacu',
            $CEP = '85863070',
            $UF = 'PR',
            $fone = '1148869000',
            $email = 'contato@otimizy.com.br'
        );

        $expectedXml = "<enderEmit>
                <xLgr>$xLgr</xLgr>
                <nro>$nro</nro>
                <!--Optional:-->
                <xCpl>$xCpl</xCpl>
                <xBairro>$xBairro</xBairro>
                <cMun>$cMun</cMun>
                <xMun>$xMun</xMun>
                <!--Optional:-->
                <CEP>$CEP</CEP>
                <UF>$UF</UF>
                <!--Optional:-->
                <fone>$fone</fone>
                <!--Optional:-->
                <email>$email</email>
            </enderEmit>";
        $actualXml = $enderEmitDOMElement->ownerDocument->saveXML($enderEmitDOMElement);
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml);

        $xCpl = null;
        $CEP = null;
        $fone = null;
        $email = null;
        $enderEmitDOMElement = $makeMdfe->tagenderEmit($xLgr, $nro, $xCpl, $xBairro, $cMun, $xMun, $CEP, $UF, $fone, $email);
        $actualXml = $enderEmitDOMElement->ownerDocument->saveXML($enderEmitDOMElement);
        $this->assertXmlStringNotEqualsXmlString($expectedXml, $actualXml);

        $expectedXml = "<enderEmit>
                <xLgr>$xLgr</xLgr>
                <nro>$nro</nro>
                <xBairro>$xBairro</xBairro>
                <cMun>$cMun</cMun>
                <xMun>$xMun</xMun>
                <UF>$UF</UF>
            </enderEmit>";
        $actualXml = $enderEmitDOMElement->ownerDocument->saveXML($enderEmitDOMElement);
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml);
    }
}
