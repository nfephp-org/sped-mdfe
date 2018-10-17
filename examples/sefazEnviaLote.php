<?php

require __DIR__ . "/../vendor/autoload.php";

use NFePHP\Common\Certificate;
use NFePHP\MDFe\Common\Standardize;
use NFePHP\MDFe\Tools;


// CONFIG
$config = json_encode($config);
$cert = file_get_contents("certificado_teste.pfx");
$tools = new Tools($config,Certificate::readPfx($cert, 'associacao'));

$xmls = [];
$xml[] = $xmlAssinado; //Um XML já montado e assinado
$idLote = "100100100100101";
try{
    $resp = $tools->sefazEnviaLote($xml,$idLote);
    $st = new Standardize($resp);
    $std = $st->toStd();
    echo "<pre>";
    var_dump($std);
}catch (\Exception $e){
    echo "<pre>";
    var_dump("Erro:".$e->getMessage());
}