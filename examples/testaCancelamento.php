<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include __DIR__ . '/../tests/bootstrap.php';

use NFePHP\Common\Certificate;
use NFePHP\MDFe\Common\Standardize;
use NFePHP\MDFe\Tools;

$config = [
    "atualizacao" => date('Y-m-d H:i:s'),
    "tpAmb" => 2,
    "razaosocial" => 'FÁBRICA DE SOFTWARE MATRIZ',
    "cnpj" => '06157250000116',
    "ie" => '',
    "siglaUF" => 'PR',
    "versao" => '3.00'
];

try {
    $certificate = Certificate::readPfx(
        file_get_contents(TESTS_FIXTURES  . '/certs/cert_cnpj_06157250000116_senha_minhasenha.pfx'),
        'minhasenha',
    );

    $tools = new Tools(json_encode($config), $certificate);

    $chave = '41190822545265000108580260000000071582000342';
    $xJust = 'Teste de cancelamento';
    $nProt = '941190000019643';
    $resp = $tools->sefazCancela($chave, $xJust, $nProt);

    $st = new Standardize();
    $std = $st->toStd($resp);

    echo '<pre>';
    print_r($std);
    echo "</pre>";
} catch (Exception $e) {
    echo $e->getMessage();
}
