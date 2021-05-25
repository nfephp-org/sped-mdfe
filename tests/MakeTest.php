<?php


namespace NFePHP\MDFe\Tests;

use NFePHP\MDFe\Make;
use NFePHP\MDFe\Tests\Helpers\FakeToolsTrait;
use PHPUnit\Framework\TestCase;
use \stdClass;


class MakeTest extends TestCase
{
    use FakeToolsTrait;

    public function test_valid_xml()
    {
        $make = $this->getMake();
        $xml = $make->getXML();
        $this->assertNotEmpty($xml);
        $tools = $this->getFakeTools();
        $signedXml = $tools->signMDFe($xml);
        $tools->sefazEnviaLote([$signedXml], 1);
        $params = $tools->getSendParams();
        $this->assertEquals('mdfeRecepcaoLote', $params->getOperation());
    }

    public function test_tag_inf_pag_v_adiant()
    {
        $make = $this->getMake();
        $xml = $make->getXML();
        $this->assertStringContainsString("<vAdiant>0.50</vAdiant>", $xml);
    }

    /**
     * @return \NFePHP\MDFe\Make
     */
    private function getMake()
    {
        $mdfe = new Make();
        $mdfe->setOnlyAscii(true);

        /*
         * Grupo ide ( Identificação )
         */
        $ide = new \stdClass();
        $ide->cUF = '35';
        $ide->tpAmb = '1';
        $ide->tpEmit = '1';
        $ide->tpTransp = 1; //ETC
        $ide->mod = '58';
        $ide->serie = '0';
        $ide->nMDF = '5766';
        $ide->cMDF = '00025563';
        $ide->cDV = '5';
        $ide->modal = '1';
        $ide->dhEmi = '2019-04-23T06:00:48-03:00';
        $ide->tpEmis = '2';
        $ide->procEmi = '0';
        $ide->verProc = '1.6';
        $ide->UFIni = 'SP';
        $ide->UFFim = 'PA';
        $ide->dhIniViagem = '2019-04-23T06:00:48-03:00';
        $ide->indCanalVerde = '1';
        $ide->indCarregaPosterior = '1';
        $mdfe->tagide($ide);

        $infMunCarrega = new stdClass();
        $infMunCarrega->cMunCarrega = '3518800';
        $infMunCarrega->xMunCarrega = 'GUARULHOS';
        $mdfe->taginfMunCarrega($infMunCarrega);

        $infPercurso = new \stdClass();
        $infPercurso->UFPer = "PR";
        $mdfe->taginfPercurso($infPercurso);

        /*
         * fim ide
         */

        /*
         * Grupo emit ( Emitente )
         */
        $emit = new \stdClass();
        $emit->CNPJ = '00000000000000';
        $emit->IE = '111111111111';
        $emit->xNome = 'SIMULADA LOGISTICA LTDA- EPP';
        $emit->xFant = 'SIMULADA LOGISTICA LTDA- EPP';
        $mdfe->tagemit($emit);

        $enderEmit = new \stdClass();
        $enderEmit->xLgr = 'RUA CENTRAL';
        $enderEmit->nro = '0001';
        $enderEmit->xBairro = 'CENTRO';
        $enderEmit->cMun = '3518800';
        $enderEmit->xMun = 'GUARULHOS';
        $enderEmit->CEP = '07000000';
        $enderEmit->UF = 'SP';
        $enderEmit->fone = '1125252424';
        $enderEmit->email = 'simulada@simulada.com.br';
        $mdfe->tagenderEmit($enderEmit);

        /*
         * Grupo rodo ( Rodoviário )
         */

        /* Grupo infANTT */
        $infANTT = new \stdClass();
        $infANTT->RNTRC = '12345678';
        $mdfe->taginfANTT($infANTT);

        /* informações do CIOT */
        $infCIOT = new \stdClass();
        $infCIOT->CIOT = '123456789012';
        $infCIOT->CPF = '11122233344';
        $infCIOT->CNPJ = '11222333444455';
        $mdfe->taginfCIOT($infCIOT);

        /* informações do Vale Pedágio */
        $valePed = new \stdClass();
        $valePed->CNPJForn = '11222333444455';
        $valePed->CNPJPg = '66777888999900';
        //$valePed->CPFPg = '11122233355';
        $valePed->nCompra = '777778888999999';
        $valePed->vValePed = '100.00';
        $mdfe->tagdisp($valePed);

        /* informações do contratante */
        $infContratante = new \stdClass();
        $infContratante->CNPJ = '09230232000372';
        $mdfe->taginfContratante($infContratante);

        /* fim infANTT */

        /* Grupo veicTracao */
        $veicTracao = new \stdClass();
        $veicTracao->cInt = '01';
        $veicTracao->placa = 'DBL6040';
        $veicTracao->tara = '8350';
        $veicTracao->capKG = '8350';
        $veicTracao->tpRod = '03';
        $veicTracao->tpCar = '02';
        $veicTracao->UF = 'PA';

        $condutor = new \stdClass();
        $condutor->xNome = 'JOAO DA SILVA';
        $condutor->CPF = '11122233344';
        $veicTracao->condutor = [$condutor];

        $prop = new \stdClass();
        $prop->CPF = '01234567890';
        $prop->CNPJ = '';
        $prop->RNTRC = '12345678';
        $prop->xNome = 'JOAO DA SILVA';
        $prop->IE = '03857164';
        $prop->UF = 'PR';
        $prop->tpProp = '1';
        $veicTracao->prop = $prop;

        $mdfe->tagveicTracao($veicTracao);

        /* fim veicTracao */

        /* Grupo veicReboque */
        $veicReboque = new \stdClass();
        $veicReboque->cInt = '02';
        $veicReboque->placa = 'XXX1111';
        $veicReboque->tara = '8350';
        $veicReboque->capKG = '15000';
        $veicReboque->tpCar = '02';
        $veicReboque->UF = 'SP';

        $prop = new \stdClass();
        $prop->CPF = '01234567890';
        $prop->CNPJ = '';
        $prop->RNTRC = '12345678';
        $prop->xNome = 'JOAO DA SILVA';
        $prop->IE = '03857164';
        $prop->UF = 'PR';
        $prop->tpProp = '1';
        $veicReboque->prop = $prop;

        $mdfe->tagveicReboque($veicReboque);
        /* fim veicReboque */

        $lacRodo = new \stdClass();
        $lacRodo->nLacre = '1502400';
        $mdfe->taglacRodo($lacRodo);
        /* fim rodo */

        /*
         * Grupo infDoc ( Documentos fiscais )
         */
        $infMunDescarga = new \stdClass();
        $infMunDescarga->cMunDescarga = '1502400';
        $infMunDescarga->xMunDescarga = 'CASTANHAL';
        $infMunDescarga->nItem = 0;
        $mdfe->taginfMunDescarga($infMunDescarga);

        /* infCTe */
        $infCte = new \stdClass();
        $infCte->chCTe = '35310800000000000372570010001999091000027765';
        $infCte->SegCodBarra = '012345678901234567890123456789012345';
        $infCte->indReentrega = '1';
        $infCte->nItem = 0;

        /* Informações das Unidades de Transporte (Carreta/Reboque/Vagão) */
        $stdinfUnidTransp = new \stdClass();
        $stdinfUnidTransp->tpUnidTransp = '1';
        $stdinfUnidTransp->idUnidTransp = 'AAA1111';

        /* Lacres das Unidades de Transporte */
        $stdlacUnidTransp = new \stdClass();
        $stdlacUnidTransp->nLacre = ['00000001', '00000002'];

        $stdinfUnidTransp->lacUnidTransp = $stdlacUnidTransp;

        /* Informações das Unidades de Carga (Containeres/ULD/Outros) */
        $stdinfUnidCarga = new \stdClass();
        $stdinfUnidCarga->tpUnidCarga = '1';
        $stdinfUnidCarga->idUnidCarga = '01234567890123456789';

        /* Lacres das Unidades de Carga */
        $stdlacUnidCarga = new \stdClass();
        $stdlacUnidCarga->nLacre = ['00000001', '00000002'];

        $stdinfUnidCarga->lacUnidCarga = $stdlacUnidCarga;
        $stdinfUnidCarga->qtdRat = '3.50';

        $stdinfUnidTransp->infUnidCarga = [$stdinfUnidCarga];
        $stdinfUnidTransp->qtdRat = '3.50';



        /* transporte de produtos classificados pela ONU como perigosos */
        $stdperi = new \stdClass();
        $stdperi->nONU = '1234';
        $stdperi->xNomeAE = 'testeNome';
        $stdperi->xClaRisco = 'testeClaRisco';
        $stdperi->grEmb = 'teste';
        $stdperi->qTotProd = '1';
        $stdperi->qVolTipo = '1';

        /* Grupo de informações da Entrega Parcial (Corte de Voo) */
        $stdinfEntregaParcial = new \stdClass();
        $stdinfEntregaParcial->qtdTotal = '1234.56';
        $stdinfEntregaParcial->qtdParcial = '1234.56';
        $infCte->infEntregaParcial = $stdinfEntregaParcial;

        $mdfe->taginfCTe($infCte);

        $infMunDescarga = new \stdClass();
        $infMunDescarga->cMunDescarga = '1502400';
        $infMunDescarga->xMunDescarga = 'CASTANHAL';
        $infMunDescarga->nItem = 1;
        $mdfe->taginfMunDescarga($infMunDescarga);

        $infNfe = new \stdClass();
        $infNfe->chNFe = '35310800000000000372570010001999091000099999';
        $infNfe->SegCodBarra = '012345678901234567890123456789012345';
        $infNfe->indReentrega = '1';
        $infNfe->nItem = 0;

        $mdfe->taginfNFe($infNfe);

        $infMdfeTransp = new \stdClass();
        $infMdfeTransp->chMDFe = '35310800000000000372570010001999091000088888';
        $infMdfeTransp->indReentrega = '1';
        $infMdfeTransp->nItem = 0;
        $infMdfeTransp->infUnidTransp = [$stdinfUnidTransp];
        $infMdfeTransp->peri = [$stdperi];

        $mdfe->taginfMDFeTransp($infMdfeTransp);

        /* fim grupo infDoc */

        /* Grupo do Seguro */
        $seguro = new \stdClass();
        $seguro->respSeg = '1';

        /* Informações da seguradora */
        $infSeg = new \stdClass();
        $infSeg->xSeg = 'SOMPO SEGUROS';
        $infSeg->CNPJ = '11222333444455';

        $seguro->infSeg = $infSeg;
        $seguro->nApol = '11223344555';
        $seguro->nAver = ['0572012190000000000007257001000199899140', '0572012190000000000007257001000199708140'];
        $mdfe->tagseg($seguro);
        /* fim grupo Seguro */

        /* grupo de totais */
        $totais = new \stdClass();
        $totais->vCarga = '580042.92';
        $totais->cUnid = '01';
        $totais->qCarga = '35454.9400';
        $mdfe->tagtot($totais);
        /* fim grupo de totais */

        /* grupo de lacres */
        $lacre = new \stdClass();
        $lacre->nLacre = '0000001';
        $mdfe->taglacres($lacre);
        /* fim grupo de lacres */

        /* grupo Autorizados para download do XML do DF-e */
        $autorizados = new \stdClass();
        $autorizados->CNPJ = '11122233344455';
        $mdfe->tagautXML($autorizados);

        $prodPred = new \stdClass();
        $prodPred->tpCarga = '01';
        $prodPred->xProd = 'teste';
        $prodPred->cEAN = null;
        $prodPred->NCM = null;

        $localCarrega = new \stdClass();
        $localCarrega->CEP = '00000000';
        $localCarrega->latitude = null;
        $localCarrega->longitude = null;

        $localDescarrega = new \stdClass();
        $localDescarrega->CEP = '00000000';
        $localDescarrega->latitude = null;
        $localDescarrega->longitude = null;

        $lotacao = new \stdClass();
        $lotacao->infLocalCarrega = $localCarrega;
        $lotacao->infLocalDescarrega = $localDescarrega;

        $prodPred->infLotacao = $lotacao;

        $mdfe->tagprodPred($prodPred);


        $infPag = new \stdClass();
        $infPag->xNome = 'JOSE';
        $infPag->CPF = '01234567890';
        $infPag->CNPJ = null;
        $infPag->idEstrangeiro = null;
        $infPag->vAdiant = 0.5;

        $componentes = [];

        $Comp = new \stdClass();
        $Comp->tpComp = '01';
        $Comp->vComp = 10.00;
        $Comp->xComp = 'NADA';
        $componentes[] = $Comp;

        $infPag->Comp = $componentes;
        $infPag->vContrato = 10.00;
        $infPag->indPag = 1;

        $parcelas = [];

        $infPrazo = new \stdClass();
        $infPrazo->nParcela = '001';
        $infPrazo->dVenc = '2020-04-30';
        $infPrazo->vParcela = 10.00;
        $parcelas[] = $infPrazo;

        $infPag->infPrazo = $parcelas;

        $infBanc = new \stdClass();
        $infBanc->codBanco = '341';
        $infBanc->codAgencia = '12345';
        $infBanc->CNPJIPEF = null;
        $infPag->infBanc = $infBanc;

        $mdfe->taginfPag($infPag);


        /* grupo Informações Adicionais */
        $infAdic = new \stdClass();
        $infAdic->infCpl = "Contrato No 007018 2 CARR \nBBB1111";
        $infAdic->infAdFisco = 'Contrato No 007018 2 CARR BBB1111';
        $mdfe->taginfAdic($infAdic);
        return $mdfe;
    }
}
