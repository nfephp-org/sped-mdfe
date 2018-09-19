<?php
/**@category  Teste
 * @package   Spedmdfeexamples
 * @copyright 2009-2016 NFePHP
 * @name      testaMakeMDFe.php
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @link      http://github.com/nfephp-org/sped-cte for the canonical source repository
 * @author    Maison K. Sakamoto <maison.sakamoto@gmail.com> 
 * 
 * TESTE PARA A VERSÃO 3.0 do MDFe
 **/
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../bootstrap.php';

use NFePHP\MDFe\Make;
use NFePHP\MDFe\Tools;

function timezone_offset_string()
{
    $offset = timezone_offset_get(new DateTimeZone('America/Sao_Paulo'), new DateTime());
    return sprintf("%s%02d:%02d", ( $offset >= 0 ) ? '+' : '-', abs($offset / 3600), abs($offset % 3600));
}

$make= new Make();
$tools = new Tools('../config/config.json');
$dhEmi = date("Y-m-d\TH:i:s".timezone_offset_string());

//$cteTools->aConfig['siglaUF'] = $obj->emitenteUFNome;                       // SIGLA DA UF
//$cteTools->aConfig['cnpj']= Formatador::somenteNumeros($obj->emitenteCNPJ); // CNPJ do emitente
//$cteTools->aConfig['ie']= Formatador::somenteNumeros($obj->emitenteIE);     // Inscricao estadual
//$cteTools->aConfig['razaosocial']=$obj->emitenteRazao;                      // Razao social
$tools->aConfig['nomefantasia']="BARTHOLO TRANSPORTES RODOVIARIOS LTDA"; // Nome fantasia
$tools->aConfig['schemesCTe']="PL_CTe_300"; // Versao do XML
$tools->aConfig['pathXmlUrlFileCTe']="cte_ws3.xml";

$cUF = '41';        // 41-PR, 42-SC
$tpAmb = '2';       // 1-Producao(versao fiscal), 2-Homologacao(versao de teste)
$mod = '58';        // Modelo do documento fiscal: 58 para identificação do MDF-e
$serie = '1';       // Serie do MDFe
$tpEmis = '1';      // Forma de emissao do MDFe: 1-Normal; 2- Contingencia
$numeroMDFe = '104';
$cMDF = '00000010';


$chave = $make->montaChave(
    $cUF,                // Codigo da UF da tabela do IBGE: 41-PR
    $ano = date('y', strtotime($dhEmi)),
    $mes = date('m', strtotime($dhEmi)),
    $cnpj = $tools->aConfig['cnpj'],
    $mod,                   // Modelo do documento fiscal: 58 para identificação do MDF-e
    $serie,                 // Serie do MDFe
    $numero = $numeroMDFe,  // Numero do MDFe
    $tpEmis,                // Forma de emissao do MDFe: 1-Normal; 2- Contingencia
    $cCT = $cMDF            // Código aleatório gerado pelo emitente
);

$make->taginfMDFe($chave, $versao = '3.00');

$cDV = substr($chave, -1);      //Digito Verificador
$make->tagide(
    $cUF,                   // Codigo da UF da tabela do IBGE: 41-PR
    $tpAmb,                 // 1-Producao(versao fiscal), 2-Homologacao(versao de teste)
    $tpEmit = '1',          // 1-Prestador de serviço de transporte 2-Transportador de Carga Própria
    $tpTransp = '',         // 1-ETC 2-TAC 3-CTC (facultativo)
    $mod,                   // Modelo do documento fiscal: 58 para identificação do MDF-e
    $serie,                 // Serie do MDFe
    $nMDF = $numeroMDFe,    // Numero do Manifesto
    $cMDF = $cMDF,          // Código aleatório gerado pelo emitente
    $cDV,                   // Digito Verificador
    $modal = '1',           // 1-Rodoviário; 2-Aéreo; 3-Aquaviário; 4-Ferroviário.
    $dhEmi,                 // Data e hora de emissão do Manifesto (Formato AAAA-MM-DDTHH:MM:DD TZD)
    $tpEmis,                // 1-Normal; 2-Contingência
    $procEmi = '0',         // 0-Aplicativo do Contribuinte; 3-Aplicativo fornecido pelo Fisco
    $verProc = '3',         // Informar a versão do aplicativo emissor de MDF-e.
    $UFIni = 'PR',          // Sigla da UF do Carregamento
    $UFFim = 'SC',          // Sigla da UF do Descarregamento
    $dhIniViagem = ''
);

$make->tagInfMunCarrega(
    $cMunCarrega = '4108304',           // Código do Município de Carregamento (IBEGE)
    $xMunCarrega = 'Foz do Iguacu'      // Nome do Municipio de CArregamento
);

$make->tagemit(
    $CNPJ = '81450900000132',
    $IE = '4220816074',
    $xNome = 'BARTHOLO TRANSPORTES RODOVIARIOS LTDA',
    $xFant = 'BARTHOLO TRANSPORTES RODOVIARIOS LTDA'
);

$make->tagenderEmit(
    $xLgr = 'RUA CARLOS LUZ',
    $nro = '1',
    $xCpl = '',
    $xBairro = 'PARQUE PRESIDENTE',
    $cMun = '4108304',
    $xMun = 'Foz do Iguacu',
    $CEP = '85863150',
    $UF = 'PR',                       // Sigla da UF, , informar EX para operações com o exterior
    $fone = '35221216',
    $email = 'webmaster@btrtransportes.com.br'
);

$make->tagInfModal($versaoModal = '3.00');

$make->tagInfANTT(
    $RNTRC = '00739357'
);

$make->tagInfcontratante(
    $cpf = '',
    $cnpj = '79525242000159'
);

$make->tagCondutor(
    $xNome = 'VALDIR NUNES GOMES',
    $propCPF = '01754762921'
);

$make->tagVeicTracao(
    $cInt = '123',     // Código interno do veículo
    $placa = 'BEH6886',
    $tara = '16500',
    $capKG = '25500',
    $capM3 = '100',
    $tpRod = '03',      // 01 - Truck; 02 - Toco; 03 - Cavalo Mecânico; 04 - VAN; 05 - Utilitário; 06 - Outros.
    $tpCar = '02',      // 00-não aplicável; 01-Aberta; 02-Fechada/Baú; 03-Granelera; 04-Porta Container; 05-Sider
    $UF = 'PR',
    $propRNTRC = '',
    $RENAVAM = '00588892793'
);

$make->tagInfMunDescarga(
    $nItem = 0,               // index do array ( podem ser varios )
    $cMunDescarga = '4202404',
    $xMunDescarga = 'Blumenau'
);

$make->tagInfCTe(
    $nItem = 0,             // index do array ( podem ser varios )
    $chCTe = '42171081450900000566570010000001571000000100',
    $segCodBarra = '',
    $indReentrega = ''
);


$make->tagInfResp(
    $respSeg = '1', // Responsável pelo seguro [1-Emitente; 2-Resp. pela contratação do serviço de transporte]
    $CNPJ = '81450900000566',
    $CPF = ''
);
$make->tagInfSeg(
    $xSeg = 'CHUBB SEGUROS',  // Nome da Seguradora
    $CNPJ = '07476410000124'  // CNPJ da seguradora
);
$make->tagSeg(
    $nApol = '13128-001',     // Número da Apólice
    $nAver = '1089'           // Número da Averbação
);
$make->tagTot(
    $qCTe = '1',            // Quantidade total de CT-e relacionados no Manifesto
    $qNFe = '',             // Quantidade total de NF-e relacionadas no Manifesto
    $qMDFe = '',            // Quantidade total de MDF-e relacionados no Manifesto Aquaviário
    $vCarga = '21627.26',   // Valor total da carga / mercadorias transportadas
    $cUnid = '01',          // Codigo da unidade de medida do Peso Bruto da Carga / Mercadorias transportadas
    $qCarga = '55.8200'    // Peso Bruto Total da Carga / Mercadorias transportadas
);

$make->tagautXML(
    $cnpj = '04898488000177'  // CNPJ do autorizado
);

$resp = $make->montaMDFe();
$filename = "../xml/{$chave}-mdfe.xml";
if ($resp) {
    //header('Content-type: text/xml; charset=UTF-8');
    $xml = $make->getXML();
    file_put_contents($filename, $xml);
    //chmod($filename, 0777);
    //echo $xml;
} else {
    //header('Content-type: text/html; charset=UTF-8');
    foreach ($make->erros as $err) {
        echo 'tag: &lt;'.$err['tag'].'&gt; ---- '.$err['desc'].'<br>';
    }
}

$xmlAssinado = $tools->assina($xml);
file_put_contents($filename, $xmlAssinado);

$aRetorno = array();
$tools->sefazEnviaLote($xmlAssinado, $tpAmb, $idLote = '', $aRetorno);

echo "<pre>";
echo htmlspecialchars($tools->soapDebug);
echo print_r($aRetorno);
echo "</pre>";
