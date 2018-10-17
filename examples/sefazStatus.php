<?php

require __DIR__ . "/../vendor/autoload.php";

use NFePHP\Common\Certificate;
use NFePHP\MDFe\Common\Standardize;
use NFePHP\MDFe\Tools;


// CONFIG
$config = json_encode($config);
$cert = file_get_contents("certificado_teste.pfx");
$tools = new Tools($config,Certificate::readPfx($cert, 'associacao'));

$uf = "RS";
try{
    $resp = $tools->sefazStatus($uf);
    $st = new Standardize($resp);
    $std = $st->toStd();
    echo "<pre>";
    var_dump($std);
}catch (\Exception $e){
    echo "<pre>";
    var_dump("Erro:".$e->getMessage());
}