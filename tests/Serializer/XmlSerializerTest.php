<?php

namespace Tests\NFePHP\MDFe\Serializer;

use NFePHP\MDFe\Serializer\XmlSerializer;
use NFePHP\MDFe\XsdType\MDFe\TEndeEmiType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\AutXMLType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\EmitType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfAdicType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfCTeType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfModalType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\TotType;
use NFePHP\MDFe\XsdType\Rodo\Rodo;
use NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType;
use NFePHP\MDFe\XsdType\Rodo\Rodo\VeicReboqueType;
use NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType;
use NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\CondutorType;

class XmlSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testASerializacaoDeveDefinirONomeDoElementoRaizParaMdfe()
    {
        $infAdicType = new InfAdicType();
        $infAdicType
            ->setInfAdFisco('Informações adicionais de interesse do Fisco')
            ->setInfCpl('Informações complementares de interesse do Contribuinte');
        $infMDFeType = new InfMDFeType();
        $infMDFeType->setInfAdic($infAdicType);
        $TMDFeType = new TMDFeType();
        $TMDFeType->setInfMDFe($infMDFeType);

        $xmlSerializer = new XmlSerializer();
        $actualXml = $xmlSerializer->serialize($TMDFeType);
        $expectedXml = "<MDFe xmlns='http://www.portalfiscal.inf.br/mdfe'>
            <infMDFe Id='' versao=''>
                <!--Optional:-->
                <infAdic>
                    <!--Optional:-->
                    <infAdFisco>{$infAdicType->getInfAdFisco()}</infAdFisco>
                    <!--Optional:-->
                    <infCpl>{$infAdicType->getInfCpl()}</infCpl>
                </infAdic>
            </infMDFe>
        </MDFe>";
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml);
    }

    public function testASerializacaoDeveRemoverElementosVazios()
    {
        $infAdicType = new InfAdicType();
        $infAdicType
            ->setInfAdFisco('Informações adicionais de interesse do Fisco')
            ->setInfCpl('Informações complementares de interesse do Contribuinte');

        $xmlSerializer = new XmlSerializer();
        $rootNodeName = 'infAdic';
        $actualXml = $xmlSerializer->serialize($infAdicType, $rootNodeName);
        $expectedXml = "<infAdic>
            <!--Optional:-->
            <infAdFisco>{$infAdicType->getInfAdFisco()}</infAdFisco>
            <!--Optional:-->
            <infCpl>{$infAdicType->getInfCpl()}</infCpl>
        </infAdic>";
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml);

        $infAdicType->setInfCpl(null);
        $actualXml = $xmlSerializer->serialize($infAdicType, $rootNodeName);
        $expectedXml = "<infAdic>
            <!--Optional:-->
            <infAdFisco>{$infAdicType->getInfAdFisco()}</infAdFisco>
        </infAdic>";
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml);
    }

    public function testAsPropriedadesIdEVersaoDoTipoInfmdfeDevemSerConvertidasEmAtributos()
    {
        $infMDFeType = new InfMDFeType();
        $infMDFeType
            ->setId('MDFe34343434343434343434343434343434343434343434')
            ->setVersao('3.00');

        $autXMLType = new AutXMLType();
        $autXMLType->setCNPJ('06539526000392');
        $infMDFeType->addToAutXML($autXMLType);

        $TMDFeType = new TMDFeType();
        $TMDFeType->setInfMDFe($infMDFeType);

        $xmlSerializer = new XmlSerializer();
        $actualXml = $xmlSerializer->serialize($TMDFeType);

        $expectedXml = "<MDFe xmlns='http://www.portalfiscal.inf.br/mdfe'>
            <infMDFe Id='{$infMDFeType->getId()}' versao='{$infMDFeType->getVersao()}'>
                <!--0 to 10 repetitions:-->
                <autXML>
                    <CNPJ>{$autXMLType->getCNPJ()}</CNPJ>
                </autXML>
            </infMDFe>
        </MDFe>";
        $this->assertXmlStringEqualsXmlString($expectedXml, $actualXml);
    }

    public function testOResultadoDaSerializacaoDeveSerIgualAoArquivoXml()
    {
        $TMDFeType = new TMDFeType();

        $infMDFeType = new InfMDFeType();
        $infMDFeType
            ->setId('MDFe34343434343434343434343434343434343434343434')
            ->setVersao('3.00');
        $TMDFeType->setInfMDFe($infMDFeType);

        $ideType = new IdeType();
        $ideType
            ->setCUF('41')
            ->setTpAmb('2')
            ->setTpEmit('1')
            ->setMod(58)
            ->setSerie('1')
            ->setNMDF('28')
            ->setCMDF('61174316')
            ->setCDV('6')
            ->setModal('1')
            ->setDhEmi('2016-01-01T00:00:00-02:00')
            ->setTpEmis('1')
            ->setProcEmi('0')
            ->setVerProc('1.6')
            ->setUFIni('MG')
            ->setUFFim('RO')
            ->setInfMunCarrega([
                (new IdeType\InfMunCarregaType())
                    ->setCMunCarrega('4127700')
                    ->setXMunCarrega('TOLEDO')
            ]);
        $infMDFeType->setIde($ideType);

        $emitType = new EmitType();
        $emitType
            ->setCNPJ('81452880000139')
            ->setIE('3280006873')
            ->setXNome('COMERCIO E TRANSPORTES WESSLING LTDA')
            ->setXFant('COMERCIO E TRANSPORTES WESSLING LTDA');
        $tEndeEmiType = new TEndeEmiType();
        $tEndeEmiType
            ->setXLgr('AV. JOAQUIM BONETTI')
            ->setNro('985')
            ->setXCpl('SALA 201')
            ->setXBairro('CENTRO')
            ->setCMun('4107405')
            ->setXMun('ENEAS MARQUES')
            ->setCEP('85630000')
            ->setUF('PR')
            ->setFone('004635441252');
        $emitType->setEnderEmit($tEndeEmiType);
        $infMDFeType->setEmit($emitType);

        $infDocType = new InfDocType();
        $infMunDescargaType = new InfMunDescargaType();
        $infMunDescargaType
            ->setCMunDescarga('4114609')
            ->setXMunDescarga('MARECHAL CANDIDO RONDON');
        $infCTeType = new InfCTeType();
        $infCTeType->setChCTe('41130181452880000139570010000018971536074822');
        $infMunDescargaType->addToInfCTe($infCTeType);
        $infDocType->addToInfMunDescarga($infMunDescargaType);
        $infMDFeType->setInfDoc($infDocType);

        $totType = new TotType();
        $totType
            ->setQCTe(count($infMunDescargaType->getInfCTe()))
            ->setVCarga('1000.00')
            ->setCUnid('01')
            ->setQCarga('1129.9400');
        $infMDFeType->setTot($totType);

        $xmlSerializer = new XmlSerializer();
        $actualXml = $xmlSerializer->serialize($TMDFeType);
        $expectedFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR . 'MDFe34343434343434343434343434343434343434343434.xml';
        $this->assertXmlStringEqualsXmlFile($expectedFile, $actualXml);
    }

    public function test()
    {
        $TMDFeType = new TMDFeType();

        $infMDFeType = new InfMDFeType();
        $infMDFeType
            ->setId('MDFe35353535353535353535353535353535353535353535')
            ->setVersao('3.00');
        $TMDFeType->setInfMDFe($infMDFeType);

        $ideType = new IdeType();
        $ideType
            ->setCUF('41')
            ->setTpAmb('2')
            ->setTpEmit('1')
            ->setMod(58)
            ->setSerie('1')
            ->setNMDF('28')
            ->setCMDF('61174316')
            ->setCDV('6')
            ->setModal('1')
            ->setDhEmi('2016-01-01T00:00:00-02:00')
            ->setTpEmis('1')
            ->setProcEmi('0')
            ->setVerProc('1.6')
            ->setUFIni('MG')
            ->setUFFim('RO')
            ->setInfMunCarrega([
                (new IdeType\InfMunCarregaType())
                    ->setCMunCarrega('4127700')
                    ->setXMunCarrega('TOLEDO')
            ]);
        $infMDFeType->setIde($ideType);

        $emitType = new EmitType();
        $emitType
            ->setCNPJ('81452880000139')
            ->setIE('3280006873')
            ->setXNome('COMERCIO E TRANSPORTES WESSLING LTDA')
            ->setXFant('COMERCIO E TRANSPORTES WESSLING LTDA');
        $tEndeEmiType = new TEndeEmiType();
        $tEndeEmiType
            ->setXLgr('AV. JOAQUIM BONETTI')
            ->setNro('985')
            ->setXCpl('SALA 201')
            ->setXBairro('CENTRO')
            ->setCMun('4107405')
            ->setXMun('ENEAS MARQUES')
            ->setCEP('85630000')
            ->setUF('PR')
            ->setFone('004635441252');
        $emitType->setEnderEmit($tEndeEmiType);
        $infMDFeType->setEmit($emitType);

        $infModalType = new InfModalType();
        $infModalType->setVersaoModal('3.00');

        $rodo = new Rodo();
        $infANTTType = new InfANTTType();
        $infANTTType->setRNTRC('01263488');
        $rodo->setInfANTT($infANTTType);

        $veicTracaoType = new VeicTracaoType();
        $veicTracaoType
            ->setCInt('6')
            ->setPlaca('ARU7174')
            ->setTara('100000')
            ->setCapKG('280000')
            ->setCapM3('840')
            ->setTpRod('01')
            ->setTpCar('00')
            ->setUF('PR');
        $condutorType = new CondutorType();
        $condutorType
            ->setXNome('ADAO JERRY BITENCOURT')
            ->setCPF('79341373972');
        $veicTracaoType->addToCondutor($condutorType);
        $rodo->setVeicTracao($veicTracaoType);

        $veicReboqueType = new VeicReboqueType();
        $veicReboqueType
            ->setCInt('7')
            ->setPlaca('AMG5790')
            ->setTara('100000')
            ->setCapKG('280000')
            ->setCapM3('840')
            ->setTpCar('00')
            ->setUF('PR');
        $rodo->addToVeicReboque($veicReboqueType);
        $infModalType->setRodo($rodo);
        $infMDFeType->setInfModal($infModalType);

        $infDocType = new InfDocType();
        $infMunDescargaType = new InfMunDescargaType();
        $infMunDescargaType
            ->setCMunDescarga('4114609')
            ->setXMunDescarga('MARECHAL CANDIDO RONDON');
        $infCTeType = new InfCTeType();
        $infCTeType->setChCTe('41130181452880000139570010000018971536074822');
        $infMunDescargaType->addToInfCTe($infCTeType);
        $infDocType->addToInfMunDescarga($infMunDescargaType);
        $infMDFeType->setInfDoc($infDocType);

        $totType = new TotType();
        $totType
            ->setQCTe(count($infMunDescargaType->getInfCTe()))
            ->setVCarga('1000.00')
            ->setCUnid('01')
            ->setQCarga('1129.9400');
        $infMDFeType->setTot($totType);

        $xmlSerializer = new XmlSerializer();
        $actualXml = $xmlSerializer->serialize($TMDFeType);
        $expectedFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR . 'MDFe35353535353535353535353535353535353535353535.xml';
        $this->assertXmlStringEqualsXmlFile($expectedFile, $actualXml);
    }
}
