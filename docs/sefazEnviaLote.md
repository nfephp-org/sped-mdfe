# ENVIA LOTE MDF-e

**Função:** serviço destinado à recepção de mensagens de envio de MDF-e.

**Processo:** assíncrono.

**Método:** mdfeRecepcaoLote


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

```