<?php
/**@category  Teste
 * @package   Spedmdfeexamples
 * @copyright 2009-2016 NFePHP
 * @name      testaConsultaChave.php
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

$aResposta = array();
$chave = "41171081450900000132580010000001021000000107";
$tpAmb = '2';
$retorno = $tools->sefazConsultaChave($chave, $tpAmb, $aResposta);
echo '<pre>';
//echo htmlspecialchars($cteTools->soapDebug);
print_r($aResposta);
echo "</pre>";
