# ENCERRA MDF-e

**Função:** evento destinado ao atendimento de solicitações de cancelamento de MDF-e.


```php
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
$xJust = "Teste para o cancelamento do meu manifesto";//Justificativa
try{
    $resp = $tools->sefazCancela($chave,$nProt,$xJust);
    $st = new Standardize($resp);
    $std = $st->toStd();
    echo "<pre>";
    var_dump($std);
}catch (\Exception $e){
    echo "<pre>";
    var_dump("Erro:".$e->getMessage());
}

```