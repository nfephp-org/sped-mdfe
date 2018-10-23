<?php

require __DIR__ . "/../vendor/autoload.php";

use NFePHP\Common\Certificate;
use NFePHP\MDFe\Common\Standardize;
use NFePHP\MDFe\Tools;


// CONFIG
$config = [
    "tpAmb" => '2',
    "cnpj" => '16417955000189',
    "siglaUF" => 'RS',
    "versao" => '3.00',
    "schemes" => "PL_MDFe_300"
];
$config = json_encode($config);
$cert = file_get_contents("certificado_teste.pfx");
$tools = new Tools($config,Certificate::readPfx($cert, 'associacao'));

$chave = "43150989471824000151580010004785411095587838"; //Chave da MDF-e
$nProt = "943280000050374"; //Informar o nº do Protocolo de Autorização do MDF-e a ser encerrado.
$cMun = "4317608"; //Informar o código do município do encerramento do manifesto
try{
    $resp = $tools->sefazEncerra($chave,$nProt,$cMun);
    $st = new Standardize($resp);
    $std = $st->toStd();
    echo "<pre>";
    var_dump($std);
}catch (\Exception $e){
    echo "<pre>";
    var_dump("Erro:".$e->getMessage());
}
