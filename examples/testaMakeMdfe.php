<?php
/**@category  Teste
 * @package   Spedmdfeexamples
 * @copyright 2009-2016 NFePHP
 * @name      testaMakedfe.php
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @link      http://github.com/nfephp-org/sped-cte for the canonical source repository
 * @author    Lucas Dias <diasnlucas@gmail.com>
 *
 * Teste para a versão 3.0 do Mdf-e
 **/

//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

use NFePHP\MDFe\Make;
use NFePHP\MDFe\Tools;

$mdfe = new Make();
$mdfeTools = new Tools(Yii::getAlias('@sped/') . 'config/' . Yii::$app->user->identity['cnpj'] . '.json');

$dhEmi = '2017-10-09T10:24:00-03:00';
$numeroMDFe = rand(0,3345678);

$cUF = '31';
$ano = '17';
$mes = '12';
$cnpj = '11095658000120';
$mod = '58';
$serie = '1';
$numero = $numeroMDFe;
$tpEmis = '1';
$codigo = '09835783';

$chave = $mdfe->montaChave($cUF, $ano, $mes, $cnpj, $mod, $serie, $numero, $tpEmis, $codigo);

$resp = $mdfe->taginfMDFe($chave, $versao = '3.00');

$cDV = substr($chave, -1);

$resp = $mdfe->tagide(
        $cUF = '31',
        $tpAmb = '2',
        $tpEmit = '1',
        $tpTransp = '1',
        $mod,
        $serie,
        $nMDF = $numeroMDFe,
        $cMDF = $codigo,
        $cDV,
        $modal = '1',
        $dhEmi,
        $tpEmis,
        $procEmi = '0',
        $verProc = '2.0',
        $ufIni = 'MG',
        $ufFim = 'DF',
        $dhIniViagem = '2017-12-12T10:24:00-03:00'
    );

$resp = $mdfe->tagInfMunCarrega(
    $cMunCarrega = '3106200',
    $xMunCarrega = 'BELO HORIZONTE'
);


$resp = $mdfe->tagInfPercurso($ufPer = 'GO');


$resp = $mdfe->tagemit(
        $cnpj = '09204054000143',
        $numIE = '0010526120088',
        $xNome = 'NOME DO CLIENTE',
        $xFant = 'FANTASIA'
    );

$resp = $mdfe->tagenderEmit(
        $xLgr = 'R. ONTINENTINO',
        $nro = '1313',
        $xCpl = '',
        $xBairro = 'CAICARAS',
        $cMun = '3106200',
        $xMun = 'Belo Horizonte',
        $cep = '30770180',
        $siglaUF = 'MG',
        $fone = '31988998899',
        $email = 'email@hotmail.com'
    );

$resp = $mdfe->tagInfMunDescarga(
        $nItem = 0,
        $cMunDescarga = '5300108',
        $xMunDescarga = 'BRASILIA'
    );

$resp = $mdfe->tagInfCTe(
        $nItem = 0,
        $chCTe = '31171009204054000143570010000015441090704345',
        $segCodBarra = ''
    );

$resp = $mdfe->tagSeg(
        $nApol = '1321321321',
        $nAver = $numeroMDFe
    );

$resp = $mdfe->tagInfResp(
        $respSeg = '1',
        $CNPJ = '',
        $CPF = ''
    );

$resp = $mdfe->tagInfSeg(
        $xSeg = 'SOMPRO',
        $CNPJ = '11095658000140'
    );

$resp = $mdfe->tagTot(
        $qCTe = '1',
        $qNFe = '',
        $qMDFe = '',
        $vCarga = '157620.00',
        $cUnid = '01',
        $qCarga = '2323.0000'
    );

$resp = $mdfe->tagautXML(
        $cnpj = '',
        $cpf = '09835787667'
    );

$resp = $mdfe->taginfAdic(
        $infAdFisco = 'Inf. Fisco',
        $infCpl = 'Inf. Complementar do contribuinte'
    );

$resp = $mdfe->tagInfModal($versaoModal = '3.00');

$resp = $mdfe->tagRodo(
        $rntrc = '10167059'
    );

$resp = $mdfe->tagInfContratante(
        $CPF = '09835783624'
    );

$resp = $mdfe->tagCondutor(
        $xNome = 'fjaklsdjksdjf faksdj',
        $cpf = '31199690898'
    );

$resp = $mdfe->tagVeicTracao(
        $cInt = '', // Código Interno do Veículo
        $placa = 'ABC1234', // Placa do veículo
        $tara = '10000',
        $capKG = '500',
        $capM3 = '60',
        $tpRod = '06',
        $tpCar = '02',
        $UF = 'MG',
        $propRNTRC = ''
    );

$resp = $mdfe->montaMDFe();

$filename = "/var/www/html/{$chave}-mdfe.xml";

if ($resp) {
    //header('Content-type: text/xml; charset=UTF-8');
    $xml = $mdfe->getXML();
    file_put_contents($filename, $xml);
    //chmod($filename, 0777);
    //echo $xml;
} else {
    header('Content-type: text/html; charset=UTF-8');
    foreach ($mdfe->erros as $err) {
        echo 'tag: &lt;' . $err['tag'] . '&gt; ---- ' . $err['desc'] . '<br>';
    }
}


$xml = file_get_contents($filename);
$xml = $mdfeTools->assina($xml);

file_put_contents($filename, $xml);

$aRetorno = array();
$tpAmb = '2';
$idLote = '';
$indSinc = '1';
$flagZip = false;

$msg='';
//
if (! $mdfeTools->validarXml($filename) || sizeof($mdfeTools->errors)) {
    $msg .= "<h3>Algum erro ocorreu.... </h3>";
    foreach ($mdfeTools->errors as $erro) {
        if (is_array($erro)) {
            foreach ($erro as $err) {
                $msg .= "$err <br>";
            }
        } else {
            $msg .= "$erro <br>";
        }
    }
    throw new Exception($msg,0);
}
//
$retorno = $mdfeTools->sefazEnviaLote(
        $xml,
        $tpAmb,
        $idLote = '',
        $aRetorno
    );

$aResposta = array();
$recibo = $aRetorno['nRec'];
$retorno = $mdfeTools->sefazConsultaRecibo($recibo, $tpAmb, $aResposta);
//
echo '<pre>';
echo htmlspecialchars($mdfeTools->soapDebug);
print_r($aResposta);
echo "</pre>";

echo '<pre>';
var_dump($aRetorno);
var_dump($chave);
echo '</pre>';
