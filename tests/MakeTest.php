<?php

/**
 * Class MakeMDFeTest
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use PHPUnit\Framework\TestCase;
use NFePHP\MDFe\Make;

class MakeTest extends TestCase
{
    /**
     * @var Make
     */
    protected $make;

    protected function setUp()
    {
        $this->make = new Make();
    }

    public function testTagInfMdfe()
    {
        $std = new \stdClass();
        $std->versao = '3.00';

        $mdfe = $this->make->taginfMDFe($std);
        $this->assertInstanceOf(\DOMElement::class, $mdfe);
        $this->assertEquals('3.00', $mdfe->getAttribute('versao'));
    }

    public function testTagIde()
    {
        $std = new \stdClass();
        $std->cUF = '31';
        $std->tpAmb = '2';
        $std->tpEmit = '1';
        $std->tpTransp  = '1';
        $std->mod = '58';
        $std->serie = '1';
        $std->nMDF = '3345678';
        $std->cMDF = '09835783';
        $std->cDV = '8';
        $std->modal = '1';
        $std->dhEmi = '2017-10-09T10:24:00-03:00';
        $std->tpEmis = '1';
        $std->procEmi = '0';
        $std->verProc = '2.0';
        $std->ufIni = 'MG';
        $std->ufFim = 'DF';
        $std->dhIniViagem = '2017-12-12T10:24:00-03:00';

        $ide = $this->make->tagide($std);
        $this->assertInstanceOf(\DOMElement::class, $ide);
        $this->assertEquals('31', $ide->getElementsByTagName('cUF')->item(0)->nodeValue);
        $this->assertEquals('2', $ide->getElementsByTagName('tpAmb')->item(0)->nodeValue);
        $this->assertEquals('1', $ide->getElementsByTagName('tpEmit')->item(0)->nodeValue);
        $this->assertEquals('1', $ide->getElementsByTagName('tpTransp')->item(0)->nodeValue);
        $this->assertEquals('1', $ide->getElementsByTagName('serie')->item(0)->nodeValue);
        $this->assertEquals('3345678', $ide->getElementsByTagName('nMDF')->item(0)->nodeValue);
        $this->assertEquals('1', $ide->getElementsByTagName('modal')->item(0)->nodeValue);
        $this->assertEquals('2017-10-09T10:24:00-03:00', $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue);
        $this->assertEquals('1', $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue);
        $this->assertEquals('0', $ide->getElementsByTagName('procEmi')->item(0)->nodeValue);
        $this->assertEquals('2.0', $ide->getElementsByTagName('verProc')->item(0)->nodeValue);
        $this->assertEquals('MG', $ide->getElementsByTagName('UFIni')->item(0)->nodeValue);
        $this->assertEquals('DF', $ide->getElementsByTagName('UFFim')->item(0)->nodeValue);
        $this->assertEquals('2017-12-12T10:24:00-03:00', $ide->getElementsByTagName('dhIniViagem')->item(0)->nodeValue);
    }

    public function testTagInfMunCarrega()
    {
        $std = new \stdClass();
        $std->cMunCarrega = '3106200';
        $std->xMunCarrega = 'BELO HORIZONTE';

        $infMunCarrega = $this->make->tagInfMunCarrega($std);
        $this->assertInstanceOf(\DOMElement::class, $infMunCarrega);
        $this->assertEquals('3106200', $infMunCarrega->getElementsByTagName('cMunCarrega')->item(0)->nodeValue);
        $this->assertEquals('BELO HORIZONTE', $infMunCarrega->getElementsByTagName('xMunCarrega')->item(0)->nodeValue);
    }

    public function testTagInfPercurso()
    {
        $std = new \stdClass();
        $std->ufPer  = 'GO';

        $infPercurso = $this->make->tagInfPercurso($std);
        $this->assertInstanceOf(\DOMElement::class, $infPercurso);
        $this->assertEquals('GO', $infPercurso->getElementsByTagName('UFPer')->item(0)->nodeValue);
    }

    public function testTagEmit()
    {
        $std = new \stdClass();
        $std->CNPJ = '09204054000143';
        $std->IE = '0010526120088';
        $std->xNome = 'NOME DO CLIENTE';
        $std->xFant = 'FANTASIA';

        $emit = $this->make->tagemit($std);
        $this->assertInstanceOf(\DOMElement::class, $emit);
        $this->assertEquals('09204054000143', $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals('0010526120088', $emit->getElementsByTagName('IE')->item(0)->nodeValue);
        $this->assertEquals('NOME DO CLIENTE', $emit->getElementsByTagName('xNome')->item(0)->nodeValue);
        $this->assertEquals('FANTASIA', $emit->getElementsByTagName('xFant')->item(0)->nodeValue);
    }

    public function testTagEnderEmit()
    {
        $std = new \stdClass();
        $std->xLgr = 'R. ONTINENTINO';
        $std->nro = '1313';
        $std->xCpl = '';
        $std->xBairro = 'CAICARAS';
        $std->cMun = '3106200';
        $std->xMun = 'Belo Horizonte';
        $std->CEP = '30770180';
        $std->UF = 'MG';
        $std->fone = '31988998899';
        $std->email = 'email@hotmail.com';

        $enderEmit = $this->make->tagenderEmit($std);
        $this->assertInstanceOf(\DOMElement::class, $enderEmit);
        $this->assertEquals('R. ONTINENTINO', $enderEmit->getElementsByTagName('xLgr')->item(0)->nodeValue);
        $this->assertEquals('1313', $enderEmit->getElementsByTagName('nro')->item(0)->nodeValue);
        $this->assertEquals('', $enderEmit->getElementsByTagName('xCpl')->item(0)->nodeValue);
        $this->assertEquals('CAICARAS', $enderEmit->getElementsByTagName('xBairro')->item(0)->nodeValue);
        $this->assertEquals('3106200', $enderEmit->getElementsByTagName('cMun')->item(0)->nodeValue);
        $this->assertEquals('Belo Horizonte', $enderEmit->getElementsByTagName('xMun')->item(0)->nodeValue);
        $this->assertEquals('30770180', $enderEmit->getElementsByTagName('CEP')->item(0)->nodeValue);
        $this->assertEquals('MG', $enderEmit->getElementsByTagName('UF')->item(0)->nodeValue);
        $this->assertEquals('31988998899', $enderEmit->getElementsByTagName('fone')->item(0)->nodeValue);
        $this->assertEquals('email@hotmail.com', $enderEmit->getElementsByTagName('email')->item(0)->nodeValue);
    }

    public function testTagInfModal()
    {
        $std = new \stdClass();
        $std->versaoModal = '3.00';

        $infModal = $this->make->tagInfModal($std);
        $this->assertInstanceOf(\DOMElement::class, $infModal);
        $this->assertEquals('3.00', $infModal->getAttribute('versaoModal'));
    }

    public function testTagRodo()
    {
        $std = new \stdClass();
        $std->codAgPorto = '10167059';

        $rodo = $this->make->tagRodo($std);
        $this->assertInstanceOf(\DOMElement::class, $rodo);
        $this->assertEquals('10167059', $rodo->getElementsByTagName('codAgPorto')->item(0)->nodeValue);
    }

    public function testTagInfANTT()
    {
        $std = new \stdClass();
        $std->RNTRC = '9988877';

        $antt = $this->make->tagInfANTT($std);
        $this->assertInstanceOf(\DOMElement::class, $antt);
        $this->assertEquals('9988877', $antt->getElementsByTagName('RNTRC')->item(0)->nodeValue);
    }

    public function testTagInfCIOT()
    {
        $std = new \stdClass();
        $std->CIOT  = '9988877';
        $std->CNPJ  = '09204054000143';

        $ciot = $this->make->tagInfCIOT($std);
        $this->assertInstanceOf(\DOMElement::class, $ciot);
        $this->assertEquals('9988877', $ciot->getElementsByTagName('CIOT')->item(0)->nodeValue);
        $this->assertEquals('09204054000143', $ciot->getElementsByTagName('CNPJ')->item(0)->nodeValue);
    }

    public function testTagDisp()
    {
        $std = new \stdClass();
        $std->CNPJForn  = '09204054000143';
        $std->CNPJPg  = '09204054000143';
        $std->CPFPg  = '64884590074';
        $std->nCompra  = '34566';
        $std->vValePed  = '200';

        $disp = $this->make->tagDisp($std);
        $this->assertInstanceOf(\DOMElement::class, $disp);
        $this->assertEquals('09204054000143', $disp->getElementsByTagName('CNPJForn')->item(0)->nodeValue);
        $this->assertEquals('09204054000143', $disp->getElementsByTagName('CNPJPg')->item(0)->nodeValue);
        $this->assertEquals('64884590074', $disp->getElementsByTagName('CPFPg')->item(0)->nodeValue);
        $this->assertEquals('34566', $disp->getElementsByTagName('nCompra')->item(0)->nodeValue);
        $this->assertEquals('200', $disp->getElementsByTagName('vValePed')->item(0)->nodeValue);
    }

    public function testTagInfContratante()
    {
        $std = new \stdClass();
        $std->CPF  = '';
        $std->CNPJ  = '09204054000143';

        $contratante = $this->make->tagInfContratante($std);
        $this->assertInstanceOf(\DOMElement::class, $contratante);
        $this->assertEquals('09204054000143', $contratante->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals('', $contratante->getElementsByTagName('CPF')->item(0)->nodeValue);
    }

    public function testTagVeicTracao()
    {
        $std = new \stdClass();
        $std->cInt = '';
        $std->placa = 'ABC1234';
        $std->RENAVAM = '78541258';
        $std->tara = '10000';
        $std->capKG = '500';
        $std->capM3 = '60';
        $std->tpRod = '06';
        $std->tpCar = '02';
        $std->UF = 'MG';

        $veic = $this->make->tagVeicTracao($std);
        $this->assertInstanceOf(\DOMElement::class, $veic);
        $this->assertEquals('', $veic->getElementsByTagName('cInt')->item(0)->nodeValue);
        $this->assertEquals('ABC1234', $veic->getElementsByTagName('placa')->item(0)->nodeValue);
        $this->assertEquals('78541258', $veic->getElementsByTagName('RENAVAM')->item(0)->nodeValue);
        $this->assertEquals('10000', $veic->getElementsByTagName('tara')->item(0)->nodeValue);
        $this->assertEquals('500', $veic->getElementsByTagName('capKG')->item(0)->nodeValue);
        $this->assertEquals('60', $veic->getElementsByTagName('capM3')->item(0)->nodeValue);
        $this->assertEquals('06', $veic->getElementsByTagName('tpRod')->item(0)->nodeValue);
        $this->assertEquals('02', $veic->getElementsByTagName('tpCar')->item(0)->nodeValue);
        $this->assertEquals('MG', $veic->getElementsByTagName('UF')->item(0)->nodeValue);
    }

    public function testTagPropVeicTracao()
    {
        $std = new \stdClass();
        $std->xNome = 'Proprietario';

        $prop = $this->make->tagPropVeicTracao($std);
        $this->assertInstanceOf(\DOMElement::class, $prop);
        $this->assertEquals('Proprietario', $prop->getElementsByTagName('xNome')->item(0)->nodeValue);
    }

    public function testTagCondutor()
    {
        $std = new \stdClass();
        $std->xNome = 'Condutor 1';

        $condutor = $this->make->tagCondutor($std);
        $this->assertInstanceOf(\DOMElement::class, $condutor);
        $this->assertEquals('Condutor 1', $condutor->getElementsByTagName('xNome')->item(0)->nodeValue);
    }

    public function testTagVeicReboque()
    {
        $std = new \stdClass();
        $std->item = '1';
        $std->cInt = '1';
        $std->placa = 'ABC1234';
        $std->RENAVAM = '78541258';
        $std->tara = '10000';
        $std->capKG = '500';
        $std->capM3 = '60';
        $std->tpCar = '02';
        $std->UF = 'MG';

        $veic = $this->make->tagVeicReboque($std);
        $this->assertInstanceOf(\DOMElement::class, $veic);
        $this->assertEquals('1', $veic->getElementsByTagName('cInt')->item(0)->nodeValue);
        $this->assertEquals('ABC1234', $veic->getElementsByTagName('placa')->item(0)->nodeValue);
        $this->assertEquals('78541258', $veic->getElementsByTagName('RENAVAM')->item(0)->nodeValue);
        $this->assertEquals('10000', $veic->getElementsByTagName('tara')->item(0)->nodeValue);
        $this->assertEquals('500', $veic->getElementsByTagName('capKG')->item(0)->nodeValue);
        $this->assertEquals('60', $veic->getElementsByTagName('capM3')->item(0)->nodeValue);
        $this->assertEquals('02', $veic->getElementsByTagName('tpCar')->item(0)->nodeValue);
        $this->assertEquals('MG', $veic->getElementsByTagName('UF')->item(0)->nodeValue);
    }

    public function testTagPropVeicReboque()
    {
        $std = new \stdClass();
        $std->item = '1';
        $std->xNome = 'Proprietario';

        $prop = $this->make->tagPropVeicReboque($std);
        $this->assertInstanceOf(\DOMElement::class, $prop);
        $this->assertEquals('Proprietario', $prop->getElementsByTagName('xNome')->item(0)->nodeValue);
    }

    public function testTagLacRodo()
    {
        $std = new \stdClass();
        $std->nLacre = '6552';

        $lacre = $this->make->tagLacRodo($std);
        $this->assertInstanceOf(\DOMElement::class, $lacre);
        $this->assertEquals('6552', $lacre->getElementsByTagName('nLacre')->item(0)->nodeValue);
    }

    public function testTagAereo()
    {
        $std = new \stdClass();
        $std->nac = 'PP';
        $std->matr = '';
        $std->nVoo = 'AB1234';
        $std->cAerEmb = 'OACI';
        $std->cAerDes = 'OACI';
        $std->dVoo = '2017-12-12T10:24:00-03:00';

        $aereo = $this->make->tagAereo($std);
        $this->assertInstanceOf(\DOMElement::class, $aereo);
        $this->assertEquals('PP', $aereo->getElementsByTagName('nac')->item(0)->nodeValue);
        $this->assertEquals('', $aereo->getElementsByTagName('matr')->item(0)->nodeValue);
        $this->assertEquals('AB1234', $aereo->getElementsByTagName('nVoo')->item(0)->nodeValue);
        $this->assertEquals('OACI', $aereo->getElementsByTagName('cAerEmb')->item(0)->nodeValue);
        $this->assertEquals('OACI', $aereo->getElementsByTagName('cAerDes')->item(0)->nodeValue);
        $this->assertEquals('2017-12-12T10:24:00-03:00', $aereo->getElementsByTagName('dVoo')->item(0)->nodeValue);
    }

    public function testTagAquav()
    {
        $std = new \stdClass();
        $std->irin = '12';
        $std->tpEmb = '53';
        $std->cEmbar = '3352';
        $std->xEmbar = 'Embarcacao teste';
        $std->nViag = '8896';
        $std->cPrtEmb = 'BRADRARE0002';
        $std->cPrtDest = 'BRADRARE9999';
        $std->prtTrans = 'Porto Teste';
        $std->tpNav = 0;

        $aquav = $this->make->tagAquav($std);
        $this->assertInstanceOf(\DOMElement::class, $aquav);
        $this->assertEquals('12', $aquav->getElementsByTagName('irin')->item(0)->nodeValue);
        $this->assertEquals('53', $aquav->getElementsByTagName('tpEmb')->item(0)->nodeValue);
        $this->assertEquals('3352', $aquav->getElementsByTagName('cEmbar')->item(0)->nodeValue);
        $this->assertEquals('Embarcacao teste', $aquav->getElementsByTagName('xEmbar')->item(0)->nodeValue);
        $this->assertEquals('8896', $aquav->getElementsByTagName('nViag')->item(0)->nodeValue);
        $this->assertEquals('BRADRARE0002', $aquav->getElementsByTagName('cPrtEmb')->item(0)->nodeValue);
        $this->assertEquals('BRADRARE9999', $aquav->getElementsByTagName('cPrtDest')->item(0)->nodeValue);
        $this->assertEquals('Porto Teste', $aquav->getElementsByTagName('prtTrans')->item(0)->nodeValue);
        $this->assertEquals(0, $aquav->getElementsByTagName('tpNav')->item(0)->nodeValue);
    }

    public function testTagInfTermCarreg()
    {
        $std = new \stdClass();
        $std->cTermCarreg = '12';
        $std->xTermCarreg = 'Carga Teste';

        $carreg = $this->make->tagInfTermCarreg($std);
        $this->assertInstanceOf(\DOMElement::class, $carreg);
        $this->assertEquals('12', $carreg->getElementsByTagName('cTermCarreg')->item(0)->nodeValue);
        $this->assertEquals('Carga Teste', $carreg->getElementsByTagName('xTermCarreg')->item(0)->nodeValue);
    }

    public function testTagInfTermDescarreg()
    {
        $std = new \stdClass();
        $std->cTermDescarreg = '12';
        $std->xTermDescarreg = 'Carga Teste';

        $descarreg = $this->make->tagInfTermDescarreg($std);
        $this->assertInstanceOf(\DOMElement::class, $descarreg);
        $this->assertEquals('12', $descarreg->getElementsByTagName('cTermDescarreg')->item(0)->nodeValue);
        $this->assertEquals('Carga Teste', $descarreg->getElementsByTagName('xTermDescarreg')->item(0)->nodeValue);
    }

    public function testTagInfEmbComb()
    {
        $std = new \stdClass();
        $std->cEmbComb = '12';
        $std->xBalsa = 'balsa teste';

        $infEmbComb = $this->make->tagInfEmbComb($std);
        $this->assertInstanceOf(\DOMElement::class, $infEmbComb);
        $this->assertEquals('12', $infEmbComb->getElementsByTagName('cEmbComb')->item(0)->nodeValue);
        $this->assertEquals('balsa teste', $infEmbComb->getElementsByTagName('xBalsa')->item(0)->nodeValue);
    }

    public function testTagInfUnidCargaVazia()
    {
        $std = new \stdClass();
        $std->idUnidCargaVazia = 0;
        $std->tpUnidCargaVazia = '5300108';

        $unid = $this->make->tagInfUnidCargaVazia($std);
        $this->assertInstanceOf(\DOMElement::class, $unid);
        $this->assertEquals(0, $unid->getElementsByTagName('idUnidCargaVazia')->item(0)->nodeValue);
        $this->assertEquals('5300108', $unid->getElementsByTagName('tpUnidCargaVazia')->item(0)->nodeValue);
    }

    public function testTagTrem()
    {
        $std = new \stdClass();
        $std->xPref = 'NGA0115';
        $std->dhTrem = '2017-12-12T10:24:00-03:00';
        $std->xOri = 'EFVM';
        $std->xDest = 'EFA';
        $std->qVag = '6';

        $trem = $this->make->tagTrem($std);
        $this->assertInstanceOf(\DOMElement::class, $trem);
        $this->assertEquals('NGA0115', $trem->getElementsByTagName('xPref')->item(0)->nodeValue);
        $this->assertEquals('2017-12-12T10:24:00-03:00', $trem->getElementsByTagName('dhTrem')->item(0)->nodeValue);
        $this->assertEquals('EFVM', $trem->getElementsByTagName('xOri')->item(0)->nodeValue);
        $this->assertEquals('EFA', $trem->getElementsByTagName('xDest')->item(0)->nodeValue);
        $this->assertEquals('6', $trem->getElementsByTagName('qVag')->item(0)->nodeValue);
    }

    public function testTagVag()
    {
        $std = new \stdClass();
        $std->pesoBC = 1.000;
        $std->pesoR = 1.000;
        $std->tpVag = 'Gai';
        $std->serie = '1';
        $std->nVag = '3';
        $std->nSeq = '1';
        $std->TU = 1.000;

        $trem = $this->make->tagVag($std);
        $this->assertInstanceOf(\DOMElement::class, $trem);
        $this->assertEquals(1.000, $trem->getElementsByTagName('pesoBC')->item(0)->nodeValue);
        $this->assertEquals(1.000, $trem->getElementsByTagName('pesoR')->item(0)->nodeValue);
        $this->assertEquals('Gai', $trem->getElementsByTagName('tpVag')->item(0)->nodeValue);
        $this->assertEquals('1', $trem->getElementsByTagName('serie')->item(0)->nodeValue);
        $this->assertEquals('3', $trem->getElementsByTagName('nVag')->item(0)->nodeValue);
        $this->assertEquals('1', $trem->getElementsByTagName('nSeq')->item(0)->nodeValue);
        $this->assertEquals(1.000, $trem->getElementsByTagName('TU')->item(0)->nodeValue);
    }

    public function testTagInfMunDescarga()
    {
        $std = new \stdClass();
        $std->nItem = 0;
        $std->cMunDescarga = '5300108';
        $std->xMunDescarga = 'BRASILIA';

        $infMunDescarga = $this->make->tagInfMunDescarga($std);
        $this->assertInstanceOf(\DOMElement::class, $infMunDescarga);
        $this->assertEquals('5300108', $infMunDescarga->getElementsByTagName('cMunDescarga')->item(0)->nodeValue);
        $this->assertEquals('BRASILIA', $infMunDescarga->getElementsByTagName('xMunDescarga')->item(0)->nodeValue);
    }

    public function testTagInfCTe()
    {
        $std = new \stdClass();
        $std->nItem = 1;
        $std->chCTe = '31171009204054000143570010000015441090704345';
        $std->segCodBarra = '';
        $std->indReentrega = '';

        $infCTe = $this->make->tagInfCTe($std);
        $this->assertInstanceOf(\DOMElement::class, $infCTe);
        $this->assertEquals('31171009204054000143570010000015441090704345', $infCTe->getElementsByTagName('chCTe')->item(0)->nodeValue);
        $this->assertEquals('', $infCTe->getElementsByTagName('SegCodBarra')->item(0)->nodeValue);
        $this->assertEquals('', $infCTe->getElementsByTagName('indReentrega')->item(0)->nodeValue);
    }

    public function testTagInfNFe()
    {
        $std = new \stdClass();
        $std->nItem = 0;
        $std->chNFe = '31171009204054000143570010000015441090704345';
        $std->SegCodBarra = '';
        $std->indReentrega = '';

        $infNFe = $this->make->tagInfNFe($std);
        $this->assertInstanceOf(\DOMElement::class, $infNFe);
        $this->assertEquals('31171009204054000143570010000015441090704345', $infNFe->getElementsByTagName('chNFe')->item(0)->nodeValue);
        $this->assertEquals('', $infNFe->getElementsByTagName('SegCodBarra')->item(0)->nodeValue);
        $this->assertEquals('', $infNFe->getElementsByTagName('indReentrega')->item(0)->nodeValue);
    }

    public function testTagInfResp()
    {
        $std = new \stdClass();
        $std->respSeg = 'Joao';
        $std->CNPJ = '11095658000140';
        $std->CPF = '';

        $resp = $this->make->tagInfResp($std);
        $this->assertInstanceOf(\DOMElement::class, $resp);
        $this->assertEquals('Joao', $resp->getElementsByTagName('respSeg')->item(0)->nodeValue);
        $this->assertEquals('11095658000140', $resp->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals('', $resp->getElementsByTagName('CPF')->item(0)->nodeValue);
    }

    public function testTagInfSeg()
    {
        $std = new \stdClass();
        $std->xSeg = 'Joao';
        $std->CNPJ = '11095658000140';

        $seg = $this->make->tagInfSeg($std);
        $this->assertInstanceOf(\DOMElement::class, $seg);
        $this->assertEquals('Joao', $seg->getElementsByTagName('xSeg')->item(0)->nodeValue);
        $this->assertEquals('11095658000140', $seg->getElementsByTagName('CNPJ')->item(0)->nodeValue);
    }

    public function testTagSeg()
    {
        $std = new \stdClass();
        $std->nApol = '114';
        $std->nAver = '300';

        $seg = $this->make->tagSeg($std);
        $this->assertInstanceOf(\DOMElement::class, $seg);
        $this->assertEquals('114', $seg->getElementsByTagName('nApol')->item(0)->nodeValue);
        $this->assertEquals('300', $seg->getElementsByTagName('nAver')->item(0)->nodeValue);
    }

    public function testTagTot()
    {
        $std = new \stdClass();
        $std->qCTe = '1';
        $std->qNFe = '';
        $std->qMDFe = '';
        $std->vCarga = '157620.00';
        $std->cUnid = '01';
        $std->qCarga = '2323.0000';

        $tot = $this->make->tagTot($std);
        $this->assertInstanceOf(\DOMElement::class, $tot);
        $this->assertEquals('1', $tot->getElementsByTagName('qCTe')->item(0)->nodeValue);
        $this->assertEquals('', $tot->getElementsByTagName('qNFe')->item(0)->nodeValue);
        $this->assertEquals('', $tot->getElementsByTagName('qMDFe')->item(0)->nodeValue);
        $this->assertEquals('157620.00', $tot->getElementsByTagName('vCarga')->item(0)->nodeValue);
        $this->assertEquals('01', $tot->getElementsByTagName('cUnid')->item(0)->nodeValue);
        $this->assertEquals('2323.0000', $tot->getElementsByTagName('qCarga')->item(0)->nodeValue);
    }

    public function testTagLacres()
    {
        $std = new \stdClass();
        $std->nLacre = '1';

        $lacres = $this->make->tagLacres($std);
        $this->assertInstanceOf(\DOMElement::class, $lacres);
        $this->assertEquals('1', $lacres->getElementsByTagName('nLacre')->item(0)->nodeValue);
    }

    public function testTagAutXML()
    {
        $std = new \stdClass();
        $std->CNPJ = '';
        $std->CPF = '09835787667';

        $autXML = $this->make->tagautXML($std);
        $this->assertInstanceOf(\DOMElement::class, $autXML);
        $this->assertEquals('', $autXML->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals('09835787667', $autXML->getElementsByTagName('CPF')->item(0)->nodeValue);
    }

    public function testTagInfAdic()
    {
        $std = new \stdClass();
        $std->infAdFisco = 'Inf. Fisco';
        $std->infCpl = 'Inf. Complementar do contribuinte';

        $infAdic = $this->make->taginfAdic($std);
        $this->assertInstanceOf(\DOMElement::class, $infAdic);
        $this->assertEquals('Inf. Fisco', $infAdic->getElementsByTagName('infAdFisco')->item(0)->nodeValue);
        $this->assertEquals('Inf. Complementar do contribuinte', $infAdic->getElementsByTagName('infCpl')->item(0)->nodeValue);
    }
}
