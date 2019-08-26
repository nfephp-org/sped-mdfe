<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

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

    $tools = new Tools(json_encode($config), $certificate);

    $chave = '41190822545265000108580260000000081326846774';
    $nSeqEvento = '1';
    $xNome = 'CLEITON';
    $cpf = '01234567890';
    $resp = $tools->sefazIncluiCondutor($chave, $nSeqEvento, $xNome, $cpf);

    $st = new Standardize();
    $std = $st->toStd($resp);

    echo '<pre>';
    print_r($std);
    echo "</pre>";
} catch (Exception $e) {
    echo $e->getMessage();
}
