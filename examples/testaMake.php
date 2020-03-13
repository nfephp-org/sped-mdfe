<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../bootstrap.php';

use NFePHP\MDFe\Make;
use NFePHP\Common\Certificate;
use NFePHP\MDFe\Common\Standardize;
use NFePHP\MDFe\Tools;

$config = [
    "atualizacao" => "2019-06-15 08:29:21",
    "tpAmb" => 2,
    "razaosocial" => "TG RIO SUL TRANSPORTES LTDA",
    "siglaUF" => "SC",
    "cnpj" => "05388274000113",
    "inscricaomunicipal" => "11223",
    "codigomunicipio" => "4204301",
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
$std->cUF = '42';
$std->tpAmb = '2';
$std->tpEmit = '1';
$std->tpTransp = '1';
$std->mod = '58';
$std->serie = '4';
$std->nMDF = '11';
$std->cMDF = '00000002';
$std->cDV = '2';
$std->modal = '1';
$std->dhEmi = '2020-03-13T11:20:00-03:00';
$std->tpEmis = '1';
$std->procEmi = '0';
$std->verProc = 'SysconWeb_1.0';
$std->UFIni = 'SC';
$std->UFFim = 'SC';
$std->dhIniViagem = '2020-03-13T11:30:00-03:00';
//$std->indCanalVerde = '1';
//$std->indCarregaPosterior = '1';
$mdfe->tagide($std);

// for {
$infMunCarrega = new stdClass();
$infMunCarrega->cMunCarrega = '4201257';
$infMunCarrega->xMunCarrega = 'APIUNA';
$mdfe->taginfMunCarrega($infMunCarrega);
// }

// for
/*
$infPercurso = new \stdClass();
$infPercurso->UFPer = "PR";
$mdfe->taginfPercurso($infPercurso);*/
// }

/*
 * fim ide
 */

/*
 * Grupo emit ( Emitente )
 */
$std = new \stdClass();
$std->CNPJ = '05388274000113';
$std->IE = '254504671';
$std->xNome = 'TG RIO SUL TRANSPORTES LTDA';
$std->xFant = 'TG RIO SUL TRANSPORTES LTDA';
$mdfe->tagemit($std);

$std = new \stdClass();
$std->xLgr = 'AREA RURAL';
$std->nro = '0001';
$std->xBairro = 'AREA RURAL';
$std->cMun = '4204301';
$std->xMun = 'CONCORDIA';
$std->CEP = '89709000';
$std->UF = 'SC';
$std->fone = '49991804520';
$std->email = 'CAVASSIN.VANDERLEI@GMAIL.COM';
$mdfe->tagenderEmit($std);
/*
 * fim emit
 */

/*
 * Grupo rodo ( Rodoviário )
 */

/* Grupo infANTT */
$infANTT = new \stdClass();
$infANTT->RNTRC = '01299770';
$mdfe->taginfANTT($infANTT);

/* informações do CIOT */
// for {
/*
$infCIOT = new \stdClass();
$infCIOT->CIOT = '123456789012';
$infCIOT->CPF = '11122233344';
$infCIOT->CNPJ = '11222333444455';
$mdfe->taginfCIOT($infCIOT);
*/
// }

/* informações do Vale Pedágio */
// for {
/*
$valePed = new \stdClass();
$valePed->CNPJForn = '11222333444455';
$valePed->CNPJPg = '66777888999900';
$valePed->CPFPg = '11122233355';
$valePed->nCompra = '777778888999999';
$valePed->vValePed = '100.00';
$mdfe->tagdisp($valePed);
*/
// }

/* informações do contratante */
// for {
$infContratante = new \stdClass();

$infContratante->CNPJ = '09230232000372';
$mdfe->taginfContratante($infContratante);


$pagto = new \stdClass();
$pagto->xNome = "VANDE TESTE";
$pagto->CPF = "00000000000";
$pagto->vContrato = "135.00";
$pagto->indPag = 1;
//$pagto->idEstrangeiro = "VANDE TESTE";

$infCom = new \stdClass();
$infCom->tpComp = '03';
$infCom->vComp = '134.55';
$infCom->xComp = 'descricao teste';
$pagto->Comp = [$infCom];

$infPrazo = new \stdClass();
$infPrazo->vParcela = 134.55;
$pagto->infPrazo = [$infPrazo];

$banco = new \stdClass();
$banco->codBanco = "001";
$banco->codAgencia = "1";
//$banco->CNPJIPEF = "39207541000120";
$pagto->infBanc = [$banco];


$mdfe->taginfPag($pagto);


// }

/* fim infANTT */

/* Grupo veicTracao */
$veicTracao = new \stdClass();
$veicTracao->cInt = '01';
$veicTracao->placa = 'DSA4854';
$veicTracao->tara = '8350';
$veicTracao->capKG = '8350';
$veicTracao->tpRod = '03';
$veicTracao->tpCar = '02';
$veicTracao->UF = 'SC';

$condutor = new \stdClass();
$condutor->xNome = 'VANDERLEI CAVASSIN';
$condutor->CPF = '07040551985';
$veicTracao->condutor = [$condutor];

$prop = new \stdClass();
$prop->CPF = '';
$prop->CNPJ = '05388274000113';
$prop->RNTRC = '01299770';
$prop->xNome = 'TG RIO SUL TRANSPORTES LTDA';
$prop->IE = '254504671';
$prop->UF = 'SC';
$prop->tpProp = '1';
$veicTracao->prop = $prop;

$mdfe->tagveicTracao($veicTracao);

/* fim veicTracao */

/* fim rodo */

/*
 * Grupo infDoc ( Documentos fiscais )
 */
$infMunDescarga = new \stdClass();
$infMunDescarga->cMunDescarga = '4204301';
$infMunDescarga->xMunDescarga = 'CONCORDIA';
$infMunDescarga->nItem = 0;
$mdfe->taginfMunDescarga($infMunDescarga);


$std = new \stdClass();
$std->chCTe = '42200305388274000113570040000000111000000029';
$std->indReentrega = '0';
$std->nItem = 0;
/*
$std->chCTe = '42200305388274000113570040000000121000000050';
$std->indReentrega = '1';
$std->nItem = 1;*/

$mdfe->taginfCTe($std);


$infMunDescarga = new \stdClass();
$infMunDescarga->cMunDescarga = '4204301';
$infMunDescarga->xMunDescarga = 'CONCORDIA';
$infMunDescarga->nItem = 0;
$mdfe->taginfMunDescarga($infMunDescarga);

$stda = new \stdClass();
$stda->chCTe = '42200305388274000113570040000000121000000050';
$stda->indReentrega = '0';
$stda->nItem = 1;


$mdfe->taginfCTe($stda);

/* fim grupo infDoc */

/* Grupo do Seguro */
$std = new \stdClass();
$std->respSeg = '1';

/* Informações da seguradora */
$stdinfSeg = new \stdClass();
$stdinfSeg->xSeg = 'BRADESCO SEGUROS';
$stdinfSeg->CNPJ = '60746948000112';

$std->infSeg = $stdinfSeg;
$std->nApol = '99999';
$std->nAver = ['99999'];
$mdfe->tagseg($std);
/* fim grupo Seguro */

$prodpre = new \stdClass();
$prodpre->tpCarga = "03";
$prodpre->xProd = "produto teste";
//$prodpre->cEAN = "";
//$prodpre->NCM = "0123456";
$mdfe->tagprodPred($prodpre);



/* grupo de totais */
$std = new \stdClass();
$std->vCarga = '1200.00';
$std->cUnid = '01';
$std->qCarga = '1.0000';
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
$std->CNPJ = '04898488000177';
$mdfe->tagautXML($std);
// }

/* grupo Informações Adicionais */
$std = new \stdClass();
$std->infCpl = 'COMPLEMENTAR';
$std->infAdFisco = 'FISCO';
$mdfe->taginfAdic($std);
/* fim grupo Informações Adicionais */

try {
    //$xml = $mdfe->getXML(); // O conteúdo do XML fica armazenado na variável $xml
    header("Content-type: text/xml");
    $xml = $mdfe->getXML(); 


    echo $xml;exit;
    $caminhoCrt = "certificado.pfx";
    $content = file_get_contents($caminhoCrt);
    $certificate = Certificate::readPfx($content, '1234');
    $tools = new Tools(json_encode($config), $certificate);
    $xmlAssinado = $tools->signMDFe($xml);

    //echo $xmlAssinado;
    $resp = $tools->sefazEnviaLote([$xmlAssinado], rand(1, 10000));

    
    $st = new Standardize();
    $std = $st->toStd($resp);

    sleep(3);

    $resp = $tools->sefazConsultaRecibo($std->infRec->nRec);
    $std = $st->toStd($resp);

    echo '<pre>';
    print_r($std);
    echo "</pre>";
} catch (Exception $e) {
    echo $e->getMessage();
    var_dump($mdfe->getErrors());
}
