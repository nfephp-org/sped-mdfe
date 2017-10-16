<?php
/**@category  Teste
 * @package   Spedmdfeexamples
 * @copyright 2009-2016 NFePHP
 * @name      testaEncerramento.php
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL v.3
 * @link      http://github.com/nfephp-org/sped-cte for the canonical source repository
 * @author    Maison K. Sakamoto <maison.sakamoto@gmail.com> 
 * 
 * TESTE PARA A VERSÃO 3.0 do MDFe
 */
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include_once '../bootstrap.php';

use NFePHP\MDFe\Tools;

$tools = new Tools('../config/config.json');

$offset = timezone_offset_get(new DateTimeZone('America/Sao_Paulo'), new DateTime());
$tz = sprintf("%s%02d:%02d", ( $offset >= 0 ) ? '+' : '-', abs($offset / 3600), abs($offset % 3600));
$tools->aConfig['tz']= $tz;
$aRetorno = array();
$retorno = $tools->sefazEncerra(
    $chave = '41171081450900000132580010000001011000000100',
    $tpAmb = '2',
    $nSeqEvento = '',
    $nProt = '941170000021575',
    $cUF = '42',
    $cMun = '4202404',
    $aRetorno
);
echo '<pre>';
print_r($aRetorno);
echo "</pre>";
