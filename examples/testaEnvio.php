<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

header("Content-type: text/plain");

include_once '../bootstrap.php';

use NFePHP\Common\Certificate;
use NFePHP\MDFe\Common\Standardize;
use NFePHP\MDFe\Tools;

$config = [
    "atualizacao" => date('Y-m-d H:i:s'),
    "tpAmb" => 2,
    "razaosocial" => 'FÁBRICA DE SOFTWARE MATRIZ',
    "cnpj" => '',
    "ie" => '',
    "siglaUF" => 'PR',
    "versao" => '3.00'
];

try {
    $certificate = Certificate::readPfx(
        '',
        ''
    );

    $xml = '<?xml version="1.0" encoding="UTF-8"?><MDFe xmlns="http://www.portalfiscal.inf.br/mdfe"><infMDFe Id="MDFe41190822545265000108580260000000081326846774" versao="3.00"><ide><cUF>41</cUF><tpAmb>2</tpAmb><tpEmit>2</tpEmit><mod>58</mod><serie>26</serie><nMDF>8</nMDF><cMDF>32684677</cMDF><cDV>4</cDV><modal>1</modal><dhEmi>2019-08-14T11:35:01-03:00</dhEmi><tpEmis>2</tpEmis><procEmi>0</procEmi><verProc>3.9.8</verProc><UFIni>PR</UFIni><UFFim>RS</UFFim><infMunCarrega><cMunCarrega>4108403</cMunCarrega><xMunCarrega>Francisco Beltrao</xMunCarrega></infMunCarrega><infPercurso><UFPer>SC</UFPer></infPercurso></ide><emit><CNPJ>22545265000108</CNPJ><IE>9069531021</IE><xNome>EMPRESA DEMONSTRACAO LTDA</xNome><xFant>FABRICA DE SOFTWARE MATRIZ</xFant><enderEmit><xLgr>AVENIDA JULIO ASSIS CAVALHEIRO</xLgr><nro>1</nro><xBairro>CENTRO</xBairro><cMun>4108403</cMun><xMun>Francisco Beltrao</xMun><CEP>85601000</CEP><UF>PR</UF><fone>4635230686</fone></enderEmit></emit><infModal versaoModal="3.00"><rodo xmlns="http://www.portalfiscal.inf.br/mdfe"><infANTT><RNTRC>12345678</RNTRC><infContratante><CPF>01234567890</CPF></infContratante></infANTT><veicTracao><placa>ABC1011</placa><RENAVAM>32132132131</RENAVAM><tara>0</tara><prop><CPF>01234567890</CPF><RNTRC>88888888</RNTRC><xNome>ALISSON</xNome><IE/><UF>PR</UF><tpProp>0</tpProp></prop><condutor><xNome>CLEITON</xNome><CPF>06844990960</CPF></condutor><tpRod>01</tpRod><tpCar>01</tpCar><UF>PR</UF></veicTracao><veicReboque><placa>ABC1012</placa><RENAVAM>12313213213</RENAVAM><tara>0</tara><capKG>20000</capKG><capM3>180</capM3><prop><CPF>01234567890</CPF><RNTRC>88888888</RNTRC><xNome>ALISSON</xNome><IE/><UF>PR</UF><tpProp>0</tpProp></prop><tpCar>03</tpCar><UF>PR</UF></veicReboque></rodo></infModal><infDoc><infMunDescarga><cMunDescarga>4314902</cMunDescarga><xMunDescarga>Porto Alegre</xMunDescarga><infNFe><chNFe>41190122545265000108550270000004491369658540</chNFe></infNFe></infMunDescarga><infMunDescarga><cMunDescarga>4300208</cMunDescarga><xMunDescarga>Ajuricaba</xMunDescarga><infNFe><chNFe>41190522545265000108550270000005731334929373</chNFe></infNFe></infMunDescarga></infDoc><tot><qNFe>2</qNFe><vCarga>72.04</vCarga><cUnid>01</cUnid><qCarga>3.0000</qCarga></tot><lacres><nLacre>3113213213213213213213</nLacre></lacres></infMDFe></MDFe>';

    $tools = new Tools(json_encode($config), $certificate);
    
    $xmlAssinado = $tools->signMDFe($xml);

    header('Content-type: text/plain; charset=UTF-8');
    echo $xmlAssinado;
    
    //$resp = $tools->sefazEnviaLote([$xmlAssimado], rand(1, 10000));

    
    //$st = new Standardize();
    //$std = $st->toStd($resp);

    //sleep(3);

    //$resp = $tools->sefazConsultaRecibo($std->infRec->nRec);
    //$std = $st->toStd($resp);

    //echo '<pre>';
    //print_r($std);
    //echo "</pre>";
} catch (Exception $e) {
    echo $e->getMessage();
}
