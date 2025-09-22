<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include_once '../bootstrap.php';

use NFePHP\Common\Certificate;
use NFePHP\MDFe\Common\Standardize;
use NFePHP\MDFe\Tools;

$config = [
    "atualizacao" => date('Y-m-d H:i:s'),
    "tpAmb" => 1,
    "razaosocial" => 'FÁBRICA DE SOFTWARE MATRIZ',
    "cnpj" => '16791062000107',
    "ie" => '134640055',
    "siglaUF" => 'RS',
    "versao" => '3.00'
];

try {
    $certificate = Certificate::readPfx(
        file_get_contents('certificado.pfx'),
        file_get_contents('senha.txt')
    );

    $tools = new Tools(json_encode($config), $certificate);

    $resp = $tools->sefazDistDFe();

    $st = new Standardize();
    $std = $st->toStd($resp);

    echo '<pre>';
    print_r($std);
    echo "</pre>";
} catch (Exception $e) {
    echo $e->getMessage();
}
