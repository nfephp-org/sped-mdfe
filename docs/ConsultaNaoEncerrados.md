# CONSULTA NÃO ENCERRADOS

**Função:** serviço destinado ao atendimento de solicitações de consulta MDF-e não encerrados
            na Base de Dados do Ambiente Autorizador.

**Processo:** síncrono.

**Método:** mdfeConsNaoEnc


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
try{
    $resp = $tools->sefazConsultaNaoEncerrados();
    $st = new Standardize($resp);
    $std = $st->toStd();
    echo "<pre>";
    var_dump($std);
}catch (\Exception $e){
    echo "<pre>";
    var_dump("Erro:".$e->getMessage());
}

```