<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

header("Content-type: text/plain");

include_once '../bootstrap.php';

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
header("Content-type: text/xml");
try {
    $caminhoCrt = "certificado.pfx";
    $content = file_get_contents($caminhoCrt);
    $certificate = Certificate::readPfx($content, '1234');

    $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <MDFe xmlns="http://www.portalfiscal.inf.br/mdfe"><infMDFe Id="MDFe42200305388274000113580040000000111000000022" versao="3.00"><ide><cUF>42</cUF><tpAmb>2</tpAmb><tpEmit>1</tpEmit><tpTransp>1</tpTransp><mod>58</mod><serie>4</serie><nMDF>11</nMDF><cMDF>00000002</cMDF><cDV>2</cDV><modal>1</modal><dhEmi>2020-03-16T09:26:00-03:00</dhEmi><tpEmis>1</tpEmis><procEmi>0</procEmi><verProc>SysconWeb_1.0</verProc><UFIni>SC</UFIni><UFFim>SC</UFFim><infMunCarrega><cMunCarrega>4201257</cMunCarrega><xMunCarrega>APIUNA</xMunCarrega></infMunCarrega><dhIniViagem>2020-03-16T11:30:00-03:00</dhIniViagem></ide><emit><CNPJ>05388274000113</CNPJ><IE>254504671</IE><xNome>TG RIO SUL TRANSPORTES LTDA</xNome><xFant>TG RIO SUL TRANSPORTES LTDA</xFant><enderEmit><xLgr>AREA RURAL</xLgr><nro>0001</nro><xBairro>AREA RURAL</xBairro><cMun>4204301</cMun><xMun>CONCORDIA</xMun><CEP>89709000</CEP><UF>SC</UF><fone>49991804520</fone><email>CAVASSIN.VANDERLEI@GMAIL.COM</email></enderEmit></emit><infModal versaoModal="3.00"><rodo><infANTT><RNTRC>01299770</RNTRC><infContratante><CNPJ>09230232000372</CNPJ></infContratante><infPag><xNome>VANDE TESTE</xNome><CNPJ>04363243000145</CNPJ><Comp><tpComp>03</tpComp><vComp>134.55</vComp><xComp>descricao teste</xComp></Comp><vContrato>135.00</vContrato><indPag>1</indPag><infPrazo><vParcela>134.55</vParcela></infPrazo><infBanc><codBanco>001</codBanco><codAgencia>1</codAgencia></infBanc></infPag></infANTT><veicTracao><cInt>01</cInt><placa>DSA4854</placa><tara>8350</tara><capKG>8350</capKG><prop><CNPJ>05388274000113</CNPJ><RNTRC>01299770</RNTRC><xNome>TG RIO SUL TRANSPORTES LTDA</xNome><IE>254504671</IE><UF>SC</UF><tpProp>1</tpProp></prop><condutor><xNome>VANDERLEI CAVASSIN</xNome><CPF>07040551985</CPF></condutor><tpRod>03</tpRod><tpCar>02</tpCar><UF>SC</UF></veicTracao></rodo></infModal><infDoc><infMunDescarga><cMunDescarga>4204301</cMunDescarga><xMunDescarga>CONCORDIA</xMunDescarga><infCTe><chCTe>42200305388274000113570040000000111000000029</chCTe><indReentrega>1</indReentrega></infCTe><infCTe><chCTe>42200305388274000113570040000000121000000050</chCTe><indReentrega>1</indReentrega></infCTe></infMunDescarga></infDoc><seg><infResp><respSeg>1</respSeg></infResp><infSeg><xSeg>BRADESCO SEGUROS</xSeg><CNPJ>60746948000112</CNPJ></infSeg><nApol>99999</nApol><nAver>99999</nAver></seg><prodPred><tpCarga>03</tpCarga><xProd>produto teste</xProd></prodPred><tot><qCTe>2</qCTe><vCarga>1200.00</vCarga><cUnid>01</cUnid><qCarga>1.0000</qCarga></tot><lacres><nLacre>0000001</nLacre></lacres><autXML><CNPJ>04898488000177</CNPJ></autXML><infAdic><infAdFisco>FISCO</infAdFisco><infCpl>COMPLEMENTAR</infCpl></infAdic></infMDFe></MDFe>';

    $tools = new Tools(json_encode($config), $certificate);
    
    $xmlAssinado = $tools->signMDFe($xml);

    
   // echo $xmlAssinado;
    
    $resp = $tools->sefazEnviaLote([$xmlAssinado], rand(1, 10000));

    
    $st = new Standardize();
    $std = $st->toStd($resp);

    sleep(3);

    $resp = $tools->sefazConsultaRecibo($std->infRec->nRec);
    $std = $st->toStd($resp);

    //echo '<pre>';
    echo var_dump($std);
    //echo "</pre>";
} catch (Exception $e) {
    echo $e->getMessage();
}
