<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../bootstrap.php';

use NFePHP\MDFe\Make;

$config = [
    "atualizacao" => "2019-06-15 08:29:21",
    "tpAmb" => 2,
    "razaosocial" => "SOFTWARE & HARDWARE INFORMATICA - ME",
    "siglaUF" => "SP",
    "cnpj" => "11222333444455",
    "inscricaomunicipal" => "11223",
    "codigomunicipio" => "3518800",
    "schemes" => "PL_MDFe_300a",
    "versao" => "3.00"
];

$configJson = json_encode($config);

$mdfe = new Make();
$mdfe->setOnlyAscii(true);

/*
 * Grupo ide ( Identificação )
 */

$std = new \stdClass();
$std->cUF = '35';
$std->tpAmb = '1';
$std->tpEmit = '1';
$std->tpTransp = 'ETC';
$std->mod = '58';
$std->serie = '0';
$std->nMDF = '5766';
$std->cMDF = '00025563';
$std->cDV = '5';
$std->modal = '1';
$std->dhEmi = '2019-04-23T06:00:48-03:00';
$std->tpEmis = '2';
$std->procEmi = '0';
$std->verProc = '1.6';
$std->UFIni = 'SP';
$std->UFFim = 'PA';
$std->dhIniViagem = '2019-04-23T06:00:48-03:00';
$std->indCanalVerde = '1';
$std->indCarregaPosterior = '1';
$mdfe->tagide($std);

// for {
$infMunCarrega = new stdClass();
$infMunCarrega->cMunCarrega = '3518800';
$infMunCarrega->xMunCarrega = 'GUARULHOS';
$mdfe->taginfMunCarrega($infMunCarrega);
// }

// for
$infPercurso = new \stdClass();
$infPercurso->UFPer = "PR";
$mdfe->taginfPercurso($infPercurso);
// }

/*
 * fim ide
 */

/*
 * Grupo emit ( Emitente )
 */
$std = new \stdClass();
$std->CNPJ = '00000000000000';
$std->IE = '111111111111';
$std->xNome = 'SIMULADA LOGISTICA LTDA- EPP';
$std->xFant = 'SIMULADA LOGISTICA LTDA- EPP';
$mdfe->tagemit($std);

$std = new \stdClass();
$std->xLgr = 'RUA CENTRAL';
$std->nro = '0001';
$std->xBairro = 'CENTRO';
$std->cMun = '3518800';
$std->xMun = 'GUARULHOS';
$std->CEP = '07000000';
$std->UF = 'SP';
$std->fone = '1125252424';
$std->email = 'simulada@simulada.com.br';
$mdfe->tagenderEmit($std);
/*
 * fim emit
 */

/*
 * Grupo rodo ( Rodoviário )
 */

/* Grupo infANTT */
$infANTT = new \stdClass();
$infANTT->RNTRC = '12345678';
$mdfe->taginfANTT($infANTT);

/* informações do CIOT */
// for {
$infCIOT = new \stdClass();
$infCIOT->CIOT = '123456789012';
$infCIOT->CPF = '11122233344';
$infCIOT->CNPJ = '11222333444455';
$mdfe->taginfCIOT($infCIOT);
// }

/* informações do Vale Pedágio */
// for {
$valePed = new \stdClass();
$valePed->CNPJForn = '11222333444455';
$valePed->CNPJPg = '66777888999900';
$valePed->CPFPg = '11122233355';
$valePed->nCompra = '777778888999999';
$valePed->vValePed = '100.00';
$mdfe->tagdisp($valePed);
// }

/* informações do contratante */
// for {
$infContratante = new \stdClass();
$infContratante->CNPJ = '09230232000372';
$mdfe->taginfContratante($infContratante);
// }

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
$std = new \stdClass();
$std->chCTe = '35310800000000000372570010001999091000027765';
$std->SegCodBarra = '012345678901234567890123456789012345';
$std->indReentrega = '1';
$std->nItem = 0;

/* Informações das Unidades de Transporte (Carreta/Reboque/Vagão) */
$stdinfUnidTransp = new \stdClass();
$stdinfUnidTransp->tpUnidTransp = '1';
$stdinfUnidTransp->idUnidTransp = 'AAA-1111';

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

$std->infUnidTransp = [$stdinfUnidTransp];

/* transporte de produtos classificados pela ONU como perigosos */
$stdperi = new \stdClass();
$stdperi->nONU = '1234';
$stdperi->xNomeAE = 'testeNome';
$stdperi->xClaRisco = 'testeClaRisco';
$stdperi->grEmb = 'testegrEmb';
$stdperi->qTotProd = '1';
$stdperi->qVolTipo = '1';
$std->peri = [$stdperi];

/* Grupo de informações da Entrega Parcial (Corte de Voo) */
$stdinfEntregaParcial = new \stdClass();
$stdinfEntregaParcial->qtdTotal = '1234.56';
$stdinfEntregaParcial->qtdParcial = '1234.56';
$std->infEntregaParcial = $stdinfEntregaParcial;

$mdfe->taginfCTe($std);

$infMunDescarga = new \stdClass();
$infMunDescarga->cMunDescarga = '1502400';
$infMunDescarga->xMunDescarga = 'CASTANHAL';
$infMunDescarga->nItem = 1;
$mdfe->taginfMunDescarga($infMunDescarga);

/* infCTe */
$std = new \stdClass();
$std->chCTe = '35310800000000000372570010001998991000614492';
$std->nItem = 1;
$mdfe->taginfCTe($std);

/* infNFe */

$std = new \stdClass();
$std->chNFe = '35310800000000000372570010001999091000099999';
$std->SegCodBarra = '012345678901234567890123456789012345';
$std->indReentrega = '1';
$std->nItem = 0;

// Informações das Unidades de Transporte (Carreta/Reboque/Vagão)
$stdinfUnidTransp = new \stdClass();
$stdinfUnidTransp->tpUnidTransp = '1';
$stdinfUnidTransp->idUnidTransp = 'AAA-1111';

// Lacres das Unidades de Transporte
$stdlacUnidTransp = new \stdClass();
$stdlacUnidTransp->nLacre = ['00000001', '00000002'];

$stdinfUnidTransp->lacUnidTransp = $stdlacUnidTransp;

// Informações das Unidades de Carga (Containeres/ULD/Outros)
$stdinfUnidCarga = new \stdClass();
$stdinfUnidCarga->tpUnidCarga = '1';
$stdinfUnidCarga->idUnidCarga = '01234567890123456789';

// lacres das Unidades de Carga
$stdlacUnidCarga = new \stdClass();
$stdlacUnidCarga->nLacre = ['00000001', '00000002'];

$stdinfUnidCarga->lacUnidCarga = $stdlacUnidCarga;
$stdinfUnidCarga->qtdRat = '3.50';

$stdinfUnidTransp->infUnidCarga = [$stdinfUnidCarga];
$stdinfUnidTransp->qtdRat = '3.50';

$std->infUnidTransp = [$stdinfUnidTransp];

// transporte de produtos classificados pela ONU como perigosos
$stdperi = new \stdClass();
$stdperi->nONU = '1234';
$stdperi->xNomeAE = 'testeNome';
$stdperi->xClaRisco = 'testeClaRisco';
$stdperi->grEmb = 'testegrEmb';
$stdperi->qTotProd = '1';
$stdperi->qVolTipo = '1';
$std->peri = [$stdperi];

$mdfe->taginfNFe($std);

/* infMDFeTransp */

$std = new \stdClass();
$std->chMDFe = '35310800000000000372570010001999091000088888';
$std->indReentrega = '1';
$std->nItem = 0;

// Informações das Unidades de Transporte (Carreta/Reboque/Vagão)
$stdinfUnidTransp = new \stdClass();
$stdinfUnidTransp->tpUnidTransp = '1';
$stdinfUnidTransp->idUnidTransp = 'AAA-1111';

// Lacres das Unidades de Transporte
$stdlacUnidTransp = new \stdClass();
$stdlacUnidTransp->nLacre = ['00000001', '00000002'];

$stdinfUnidTransp->lacUnidTransp = $stdlacUnidTransp;

// Informações das Unidades de Carga (Containeres/ULD/Outros)
$stdinfUnidCarga = new \stdClass();
$stdinfUnidCarga->tpUnidCarga = '1';
$stdinfUnidCarga->idUnidCarga = '01234567890123456789';

// lacres das Unidades de Carga
$stdlacUnidCarga = new \stdClass();
$stdlacUnidCarga->nLacre = ['00000001', '00000002'];

$stdinfUnidCarga->lacUnidCarga = $stdlacUnidCarga;
$stdinfUnidCarga->qtdRat = '3.50';

$stdinfUnidTransp->infUnidCarga = [$stdinfUnidCarga];
$stdinfUnidTransp->qtdRat = '3.50';

$std->infUnidTransp = [$stdinfUnidTransp];

// transporte de produtos classificados pela ONU como perigosos
$stdperi = new \stdClass();
$stdperi->nONU = '1234';
$stdperi->xNomeAE = 'testeNome';
$stdperi->xClaRisco = 'testeClaRisco';
$stdperi->grEmb = 'testegrEmb';
$stdperi->qTotProd = '1';
$stdperi->qVolTipo = '1';
$std->peri = [$stdperi];

$mdfe->taginfMDFeTransp($std);

/* fim grupo infDoc */

/* Grupo do Seguro */
$std = new \stdClass();
$std->respSeg = '1';

/* Informações da seguradora */
$stdinfSeg = new \stdClass();
$stdinfSeg->xSeg = 'SOMPO SEGUROS';
$stdinfSeg->CNPJ = '11222333444455';

$std->infSeg = $stdinfSeg;
$std->nApol = '11223344555';
$std->nAver = ['0572012190000000000007257001000199899140', '0572012190000000000007257001000199708140'];
$mdfe->tagseg($std);
/* fim grupo Seguro */

/* grupo de totais */
$std = new \stdClass();
$std->vCarga = '580042.92';
$std->cUnid = '01';
$std->qCarga = '35454.9400';
$mdfe->tagtot($std);
/* fim grupo de totais */

/* grupo de lacres */
// for {
$std = new \stdClass();
$std->nLacre = '0000001';
$mdfe->taglacres($std);
// }
/* fim grupo de lacres */

/* grupo Autorizados para download do XML do DF-e */
// for {
$std = new \stdClass();
$std->CNPJ = '11122233344455';
$mdfe->tagautXML($std);
// }

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

$componentes = [];
// {
$Comp = new \stdClass();
$Comp->tpComp = '01';
$Comp->vComp = 10.00;
$Comp->xComp = 'NADA';
$componentes[] = $Comp;
// }
$infPag->Comp = $componentes;
$infPag->vContrato = 10.00;
$infPag->indPag = 1;

$parcelas = [];
// {
$infPrazo = new \stdClass();
$infPrazo->nParcela = '001';
$infPrazo->dVenc = '2020-04-30';
$infPrazo->vParcela = 10.00;
$parcelas[] = $infPrazo;
// }
$infPag->infPrazo = $parcelas;

$infBanc = new \stdClass();
$infBanc->codBanco = '341';
$infBanc->codAgencia = '12345';
$infBanc->CNPJIPEF = null;
$infPag->infBanc = $infBanc;

$mdfe->taginfPag($infPag);


/* grupo Informações Adicionais */
$std = new \stdClass();
$std->infCpl = "Contrato No 007018 2 CARR \nBBB1111";
$std->infAdFisco = 'Contrato No 007018 2 CARR BBB1111';
$mdfe->taginfAdic($std);
/* fim grupo Informações Adicionais */

$xml = $mdfe->getXML(); // O conteúdo do XML fica armazenado na variável $xml
header("Content-type: text/xml");
echo $mdfe->getXML();