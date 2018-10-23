<?php

namespace NFePHP\MDFe;

/**
 * Classe principal para a comunicação com a SEFAZ
 *
 * @category  Library
 * @package   nfephp-org/sped-mdfe
 * @copyright 2008-2016 NFePHP
 * @license   http://www.gnu.org/licenses/lesser.html LGPL v3
 * @link      http://github.com/nfephp-org/sped-mdfe for the canonical source repository
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 */

use DOMDocument;
use InvalidArgumentException;
use NFePHP\Common\Certificate;
use NFePHP\Common\Signer;
use NFePHP\Common\Soap\SoapCurl;
use NFePHP\Common\UFList;
use NFePHP\Common\Validator;
use NFePHP\MDFe\Common\Config;
use NFePHP\Common\Strings;
use NFePHP\Common\Exception;
use NFePHP\MDFe\Common\Webservices;
use NFePHP\MDFe\Factories\Header;
use SoapHeader;


class Tools
{
    /**
     * config class
     * @var \stdClass
     */
    public $config;

    /**
     * Version of layout
     * @var string
     */
    private $versao = '3.00';

    /**
     * certificate class
     * @var Certificate
     */
    protected $certificate;

    /**
     * Sign algorithm from OPENSSL
     * @var int
     */
    protected $algorithm = OPENSSL_ALGO_SHA1;

    /**
     * Canonical conversion options
     * @var array
     */
    protected $canonical = [true,false,null,null];

    /**
     * ambiente 
     * @var string
     */
    public $ambiente = 'homologacao';

    /**
     * Environment
     * @var int
     */
    public $tpAmb = 2;

    /**
     * Path to schemes folder
     * @var string
     */
    public $pathschemes = '';

    /**
     * soap class
     * @var SoapCurl
     */
    public $soap;

    /**
     * errrors
     *
     * @var string
     */
    public $errors = array();
    /**
     * soapDebug
     *
     * @var string
     */
    public $soapDebug = '';
    /**
     * urlPortal
     * Instância do WebService
     *
     * @var string
     */
    protected $urlPortal = 'http://www.portalfiscal.inf.br/mdfe';
    /**
     * aLastRetEvent
     *
     * @var array
     */
    private $aLastRetEvent = array();

    /**
     * @var array
     */
    protected $soapnamespaces = [
        'xmlns:soap' => "http://www.w3.org/2003/05/soap-envelope",
        'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance",
        'xmlns:xsd' => "http://www.w3.org/2001/XMLSchema"
    ];

    /**
     * Constructor
     * load configurations,
     * load Digital Certificate,
     * map all paths,
     * set timezone and
     * and instanciate Contingency::class
     * @param string $configJson content of config in json format
     * @param Certificate $certificate
     * @throws \Exception
     */
    public function __construct($configJson, Certificate $certificate)
    {
        //valid config json string
        $this->config = Config::validate($configJson);

        $this->versao = $this->config->versao;
        $this->certificate = $certificate;
        $this->setEnvironment($this->config->tpAmb);
        $this->setPathSchemes($this->config->versao);
        $this->soap = new SoapCurl($certificate);
    }

    /**
     * Alter environment from "homologacao" to "producao" and vice-versa
     * @param int $tpAmb
     * @return void
     */
    public function setEnvironment($tpAmb = 2)
    {
        if (!empty($tpAmb) && ($tpAmb == 1 || $tpAmb == 2)) {
            $this->tpAmb = $tpAmb;
            $this->ambiente = ($tpAmb == 1) ? 'producao' : 'homologacao';
        }
    }

    /**
     * Define o Schemas para validação do XML da MDFe
     * @param null $versao
     * @return void
     */
    public function setPathSchemes($versao = null)
    {
        //Verify version template is defined
        if ($versao === null) {
            throw new \InvalidArgumentException('É preciso definir a versão de layout para validação.');
        }
        $this->pathschemes = realpath(
            __DIR__ . '/../schemes/PL_MDFe_' . str_replace(".","",$versao)
        ).'/';
    }

    /**
     * Recover cUF number from state acronym
     * @param string $acronym Sigla do estado
     * @return int number cUF
     */
    public function getcUF($acronym)
    {
        return UFlist::getCodeByUF($acronym);
    }

    /**
     * imprime
     * Imprime o documento eletrônico (MDFe, CCe, Inut.)
     *
     * @param  string $pathXml
     * @param  string $pathDestino
     * @param  string $printer
     * @return string
     */
    public function imprime($pathXml = '', $pathDestino = '', $printer = '')
    {
        //TODO : falta implementar esse método para isso é necessária a classe
        //PrintMDFe
        return "$pathXml $pathDestino $printer";
    }
    /**
     * enviaMail
     * Envia a MDFe por email aos destinatários
     * Caso $aMails esteja vazio serão obtidos os email do destinatário  e
     * os emails que estiverem registrados nos campos obsCont do xml
     *
     * @param  string  $pathXml
     * @param  array   $aMails
     * @param  string  $templateFile path completo ao arquivo template html do corpo do email
     * @param  boolean $comPdf       se true o sistema irá renderizar o DANFE e anexa-lo a mensagem
     * @return boolean
     */
    public function enviaMail($pathXml = '', $aMails = array(), $templateFile = '', $comPdf = false)
    {
        $mail = new Mail($this->aMailConf);
        if ($templateFile != '') {
            $mail->setTemplate($templateFile);
        }
        return $mail->envia($pathXml, $aMails, $comPdf);
    }

    /**
     * addCancelamento
     * Adiciona a tga de cancelamento a uma MDFe já autorizada
     * NOTA: não é requisito da SEFAZ, mas auxilia na identificação das MDFe que foram canceladas
     *
     * @param  string $pathMDFefile
     * @param  string $pathCancfile
     * @param  bool   $saveFile
     * @return string
     * @throws Exception\RuntimeException
     */
    public function addCancelamento($pathMDFefile = '', $pathCancfile = '', $saveFile = false)
    {
        $procXML = '';
        //carrega a MDFe
        $docmdfe = new Dom();
        if (file_exists($pathMDFefile)) {
            //carrega o XML pelo caminho do arquivo informado
            $docmdfe->loadXMLFile($pathMDFefile);
        } else {
            //carrega o XML pelo conteúdo
            $docmdfe->loadXMLString($pathMDFefile);
        }
        $nodemdfe = $docmdfe->getNode('MDFe', 0);
        if ($nodemdfe == '') {
            $msg = "O arquivo indicado como MDFe não é um xml de MDFe!";
            throw new Exception\RuntimeException($msg);
        }
        $proMDFe = $docmdfe->getNode('protMDFe');
        if ($proMDFe == '') {
            $msg = "O MDFe não está protocolado ainda!!";
            throw new Exception\RuntimeException($msg);
        }
        $chaveMDFe = $proMDFe->getElementsByTagName('chMDFe')->item(0)->nodeValue;
        //$nProtMDFe = $proMDFe->getElementsByTagName('nProt')->item(0)->nodeValue;
        $tpAmb = $docmdfe->getNodeValue('tpAmb');
        $anomes = date(
            'Ym',
            DateTime::convertSefazTimeToTimestamp($docmdfe->getNodeValue('dhEmi'))
        );
        //carrega o cancelamento
        //pode ser um evento ou resultado de uma consulta com multiplos eventos
        $doccanc = new Dom();
        if (file_exists($pathCancfile)) {
            //carrega o XML pelo caminho do arquivo informado
            $doccanc->loadXMLFile($pathCancfile);
        } else {
            //carrega o XML pelo conteúdo
            $doccanc->loadXMLString($pathCancfile);
        }
        $retEvento = $doccanc->getElementsByTagName('retEventoMDFe')->item(0);
        $eventos = $retEvento->getElementsByTagName('infEvento');
        foreach ($eventos as $evento) {
            //evento
            $cStat = $evento->getElementsByTagName('cStat')->item(0)->nodeValue;
            $tpAmb = $evento->getElementsByTagName('tpAmb')->item(0)->nodeValue;
            $chaveEvento = $evento->getElementsByTagName('chMDFe')->item(0)->nodeValue;
            $tpEvento = $evento->getElementsByTagName('tpEvento')->item(0)->nodeValue;
            //$nProtEvento = $evento->getElementsByTagName('nProt')->item(0)->nodeValue;
            //verifica se conferem os dados
            //cStat = 135 ==> evento homologado
            //tpEvento = 110111 ==> Cancelamento
            //chave do evento == chave da NFe
            //protocolo do evento ==  protocolo da NFe
            if ($cStat == '135'
                && $tpEvento == '110111'
                && $chaveEvento == $chaveMDFe
            ) {
                $docmdfe->getElementsByTagName('cStat')->item(0)->nodeValue = '101';
                $docmdfe->getElementsByTagName('xMotivo')->item(0)->nodeValue = 'Cancelamento de MDF-e homologado';
                $procXML = $docmdfe->saveXML();
                //remove as informações indesejadas
                $procXML = Strings::clearProt($procXML);
                if ($saveFile) {
                    $filename = "$chaveMDFe-protMDFe.xml";
                    $this->zGravaFile(
                        'mdfe',
                        $tpAmb,
                        $filename,
                        $procXML,
                        'enviadas'.DIRECTORY_SEPARATOR.'aprovadas',
                        $anomes
                    );
                }
                break;
            }
        }
        return (string) $procXML;
    }

    /**
     * verificaValidade
     *
     * @param  string $pathXmlFile
     * @param  array  $aRetorno
     * @return boolean
     * @throws Exception\InvalidArgumentException
     */
    public function verificaValidade($pathXmlFile = '', &$aRetorno = array())
    {
        $aRetorno = array();
        if (!file_exists($pathXmlFile)) {
            $msg = "Arquivo não localizado!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        //carrega a MDFe
        $xml = Files\FilesFolders::readFile($pathXmlFile);
        $this->oCertificate->verifySignature($xml, 'infMDFe');
        //obtem o chave da MDFe
        $docmdfe = new Dom();
        $docmdfe->loadXMLFile($pathXmlFile);
        $tpAmb = $docmdfe->getNodeValue('tpAmb');
        $chMDFe  = $docmdfe->getChave('infMDFe');
        $this->sefazConsultaChave($chMDFe, $tpAmb, $aRetorno);
        if ($aRetorno['cStat'] != '100') {
            return false;
        }
        return true;
    }

    /**
     * Sign MDFe
     * @param  string  $xml MDFe xml content
     * @return string signed MDFe xml
     */
    public function sign($xml)
    {
        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }
        //remove all invalid strings
        $xml = Strings::clearXmlString($xml);
        $signed = Signer::sign(
            $this->certificate,
            $xml,
            'infMDFe',
            'Id',
            $this->algorithm,
            $this->canonical
        );
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($signed);
        //exception will be throw if NFe is not valid
        $this->isValid($this->versao, $signed, 'mdfe');
        return $signed;
    }

    /**
     * sefazEnviaLote
     *
     * @param    string $aXml
     * @param    string $idLote
     * @return   string
     * @throws   Exception\InvalidArgumentException
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazEnviaLote($aXml, $idLote)
    {
        if (!is_array($aXml)) {
            throw new InvalidArgumentException('Envia Lote: XMLs de NF-e deve ser um array!');
        }
        $ax = [];
        foreach ($aXml as $xml) {
            $ax[] = trim(preg_replace("/<\?xml.*?\?>/", "", $xml));
        }
        $sxml = trim(implode("", $ax));


        $siglaUF = $this->config->siglaUF;
        $tpAmb = $this->config->siglaUF;

        //carrega serviço
        $this->servico('MDFeRecepcao',$this->config->siglaUF, $this->config->tpAmb);

        //montagem dos dados da mensagem SOAP
        $cons = "<enviMDFe xmlns=\"$this->urlPortal\" versao=\"$this->versao\">"
                . "<idLote>$idLote</idLote>$sxml</enviMDFe>";

        //montagem dos dados da mensagem SOAP
        $request = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($request, []);
        return $this->lastResponse;
    }

    /**
     * sefazConsultaRecibo
     *
     * @param    string $recibo
     * @return   string
     * @throws   Exception\InvalidArgumentException
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazConsultaRecibo($recibo)
    {
        if ($recibo == '') {
            $msg = "Deve ser informado um recibo.";
            throw new Exception\InvalidArgumentException($msg);
        }
        $tpAmb = $this->config->tpAmb;
        $siglaUF = $this->config->siglaUF;
        //carrega serviço
        $this->servico('MDFeRetRecepcao',$siglaUF, $tpAmb);

        $cons = "<consReciMDFe xmlns=\"$this->urlPortal\" versao=\"{$this->versao}\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<nRec>$recibo</nRec>"
            . "</consReciMDFe>";

        //montagem dos dados da mensagem SOAP
        $request = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($request, []);
        return $this->lastResponse;
    }

    /**
     * sefazConsultaChave
     * Consulta o status da MDFe pela chave de 44 digitos
     *
     * @param    string $chave
     * @return   string
     * @throws   Exception\InvalidArgumentException
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazConsultaChave($chave)
    {
        $chMDFe = preg_replace('/[^0-9]/', '', $chave);
        if (strlen($chMDFe) != 44) {
            $msg = "Uma chave de 44 dígitos da MDFe deve ser passada.";
            throw new Exception\InvalidArgumentException($msg);
        }
        $tpAmb = $this->config->tpAmb;
        $siglaUF = $this->config->siglaUF;

        //carrega serviço
        $this->servico('MDFeConsulta', $siglaUF, $tpAmb);

        $cons = "<consSitMDFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<tpAmb>$tpAmb</tpAmb>"
                . "<xServ>CONSULTAR</xServ>"
                . "<chMDFe>$chMDFe</chMDFe>"
                . "</consSitMDFe>";

        //montagem dos dados da mensagem SOAP
        $request = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($request, []);
        return $this->lastResponse;
    }

    /**
     * sefazStatus
     * Verifica o status do serviço da SEFAZ
     * NOTA : Este serviço será removido no futuro, segundo da Receita/SEFAZ devido
     * ao excesso de mau uso !!!
     *
     * @param    string $siglaUF  sigla da unidade da Federação
     * @return   mixed string XML do retorno do webservice, ou false se ocorreu algum erro
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazStatus($siglaUF)
    {
        $tpAmb = $this->config->tpAmb;
        //carrega serviço
        $this->servico('MDFeStatusServico', $siglaUF, $tpAmb);
        $servico = 'MDFeStatusServico';
        $cons = "<consStatServMDFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<xServ>STATUS</xServ></consStatServMDFe>";

        //montagem dos dados da mensagem SOAP
        $request = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($request, []);
        return $this->lastResponse;
    }

    /**
     * sefazCancela
     *
     * @param  string $chave
     * @param  string $xJust
     * @param  string $nProt
     * @param  string $nSeqEvento
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazCancela($chave, $nProt, $xJust, $nSeqEvento = '1')
    {
        $chMDFe = preg_replace('/[^0-9]/', '', $chave);
        $nProt = preg_replace('/[^0-9]/', '', $nProt);
        $xJust = Strings::replaceSpecialsChars($xJust);
        if (strlen($chMDFe) != 44) {
            $msg = "Uma chave de MDFe válida não foi passada como parâmetro $chMDFe.";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($nProt == '') {
            $msg = "Não foi passado o numero do protocolo!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if (strlen($xJust) < 15 || strlen($xJust) > 255) {
            $msg = "A justificativa deve ter pelo menos 15 digitos e no máximo 255!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        $siglaUF = $this->getcUF($this->config->siglaUF);
        //estabelece o codigo do tipo de evento CANCELAMENTO
        $tpEvento = '110111';
        if ($nSeqEvento == '') {
            $nSeqEvento = '1';
        }
        $tagAdic = "<evCancMDFe><descEvento>Cancelamento</descEvento>"
                . "<nProt>$nProt</nProt><xJust>$xJust</xJust></evCancMDFe>";

        $cOrgao = '';

        $retorno = $this->sefazEvento($chMDFe, $cOrgao, $tpEvento, $nSeqEvento, $tagAdic);
        $aRetorno = $this->aLastRetEvent;
        return $retorno;
    }

    /**
     * sefazEncerra
     *
     * @param  string $chave
     * @param  string $nProt
     * @param  string $cMun
     * @param  string $nSeqEvento
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazEncerra($chave, $nProt, $cMun = '', $nSeqEvento = '1')
    {
        $chMDFe = preg_replace('/[^0-9]/', '', $chave);
        $nProt = preg_replace('/[^0-9]/', '', $nProt);
        if ($nProt == '') {
            $msg = "Não foi passado o numero do protocolo!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        //estabelece o codigo do tipo de evento ENCERRAMENTO
        $tpEvento = '110112';
        if ($nSeqEvento == '') {
            $nSeqEvento = '1';
        }
        $dtEnc = date('Y-m-d');
        $tagAdic = "<evEncMDFe><descEvento>Encerramento</descEvento>"
            . "<nProt>$nProt</nProt><dtEnc>$dtEnc</dtEnc><cUF>".$this->getcUF($this->config->siglaUF)."</cUF>"
            . "<cMun>$cMun</cMun></evEncMDFe>";

        $cOrgao = '';

        $retorno = $this->sefazEvento($chMDFe, $cOrgao, $tpEvento, $nSeqEvento, $tagAdic);
        $aRetorno = $this->aLastRetEvent;
        return $retorno;
    }

    /**
     * sefazIncluiCondutor
     *
     * @param  string $chave
     * @param  string $tpAmb
     * @param  string $nSeqEvento
     * @param  string $xNome
     * @param  string $cpf
     * @param  array  $aRetorno
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazIncluiCondutor(
        $chave = '',
        $tpAmb = '2',
        $nSeqEvento = '1',
        $xNome = '',
        $cpf = '',
        &$aRetorno = array()
    ) {
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        $chMDFe = preg_replace('/[^0-9]/', '', $chave);
        if (strlen($chMDFe) != 44) {
            $msg = "Uma chave de MDFe válida não foi passada como parâmetro $chMDFe.";
            throw new Exception\InvalidArgumentException($msg);
        }
        $siglaUF = self::zGetSigla(substr($chMDFe, 0, 2));
        //estabelece o codigo do tipo de evento Inclusão de condutor
        $tpEvento = '110114';
        if ($nSeqEvento == '') {
            $nSeqEvento = '1';
        }
        //monta mensagem
        $tagAdic = "<evIncCondutorMDFe><descEvento>Inclusao Condutor</descEvento>"
                . "<condutor><xNome>$xNome</xNome><CPF>$cpf</CPF></condutor></evIncCondutorMDFe>";

        $cOrgao = '';

        $retorno = $this->zSefazEvento($siglaUF, $chMDFe, $cOrgao, $tpAmb, $tpEvento, $nSeqEvento, $tagAdic);
        $aRetorno = $this->aLastRetEvent;
        return $retorno;
    }

    /**
     * sefazConsultaNaoEncerrados
     *
     * @param  string $tpAmb
     * @param  string $cnpj
     * @param  array  $aRetorno
     * @return string
     * @throws Exception\RuntimeException
     */
    public function sefazConsultaNaoEncerrados()
    {
        $this->servico('MDFeConsNaoEnc',$this->config->siglaUF, $this->config->tpAmb);
        $cons = "<consMDFeNaoEnc xmlns=\"{$this->urlPortal}\" versao=\"{$this->versao}\">"
            . "<tpAmb>{$this->tpAmb}</tpAmb>"
            . "<xServ>CONSULTAR NÃO ENCERRADOS</xServ><CNPJ>{$this->config->cnpj}</CNPJ></consMDFeNaoEnc>";

        //montagem dos dados da mensagem SOAP
        $request = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($request, []);
        return $this->lastResponse;
    }

    /**
     * sefazEvento
     *
     * @param    string $chave
     * @param    string $cOrgao
     * @param    string $tpEvento
     * @param    string $tagAdic
     * @return   string
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    protected function sefazEvento($chave, $cOrgao, $tpEvento, $nSeqEvento = 1, $tagAdic = '')
    {
        //carrega serviço
        $this->servico('MDFeRecepcaoEvento',$this->config->siglaUF, $this->config->tpAmb);
        $cons = '';

        $ambiente = $this->config->tpAmb == 1 ? "producao" : "homologacao";
        $Webservice = new Webservices();
        $stdWS = $Webservice->get($this->config->siglaUF, $ambiente, 'MDFeRecepcaoEvento');

        $ev = $this->tpEv($tpEvento);
        $aliasEvento = $ev->alias;
        $cnpj = $this->config->cnpj;
        $dt = new \DateTime();
        $dhEvento = $dt->format('Y-m-d\TH:i:sP');
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $eventId = "ID".$tpEvento.$chave.$sSeqEvento;
        $cOrgao = UFList::getCodeByUF($this->config->siglaUF);
        $request = "<eventoMDFe xmlns=\"$this->urlPortal\" versao=\"$stdWS->version\">"
            . "<infEvento Id=\"$eventId\">"
            . "<cOrgao>$cOrgao</cOrgao>"
            . "<tpAmb>".$this->config->tpAmb."</tpAmb>"
            . "<CNPJ>$cnpj</CNPJ>"
            . "<chMDFe>$chave</chMDFe>"
            . "<dhEvento>$dhEvento</dhEvento>"
            . "<tpEvento>$tpEvento</tpEvento>"
            . "<nSeqEvento>$nSeqEvento</nSeqEvento>"
            . "<detEvento versaoEvento=\"$stdWS->version\">"
            . "$tagAdic"
            . "</detEvento>"
            . "</infEvento>"
            . "</eventoMDFe>";

        //assinatura dos dados
        $request = Signer::sign(
            $this->certificate,
            $request,
            'infEvento',
            'Id',
            $this->algorithm,
            $this->canonical
        );
        $cons .= Strings::clearXmlString($request, true);

        //montagem dos dados da mensagem SOAP
        $request = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($request, []);
        return $this->lastResponse;
    }

    /**
     * zTpEv
     *
     * @param  string $tpEvento
     * @return \stdClass
     * @throws Exception\RuntimeException
     */
    private function tpEv($tpEvento)
    {
        $std = new \stdClass();
        $std->alias = '';
        $std->desc = '';
        switch ($tpEvento) {
            case '110111':
                //cancelamento
                $std->alias = 'CancMDFe';
                $std->desc = 'Cancelamento';
                break;
            case '110112':
                //encerramento
                $std->alias = 'EncMDFe';
                $std->desc = 'Encerramento';
                break;
            case '110114':
                //inclusao do condutor
                $std->alias = 'EvIncCondut';
                $std->desc = 'Inclusao Condutor';
                break;
            default:
                $msg = "O código do tipo de evento informado não corresponde a "
                . "nenhum evento estabelecido.";
                throw new Exception\RuntimeException($msg);
        }
        return $std;
    }

    /**
     * Performs xml validation with its respective
     * XSD structure definition document
     * NOTE: if dont exists the XSD file will return true
     * @param string $version layout version
     * @param string $body
     * @param string $method
     * @return boolean
     */
    protected function isValid($version, $body, $method)
    {
        $schema = $this->pathschemes.$method."_v$version.xsd";
        if (!is_file($schema)) {
            return true;
        }
        return Validator::isValid(
            $body,
            $schema
        );
    }

    /**
     * Assembles all the necessary parameters for soap communication
     * @param string $service
     * @param string $uf
     * @param int $tpAmb
     * @param bool $ignoreContingency
     * @return void
     */
    private function servico($service, $uf, $tpAmb, $ignoreContingency = false)
    {
        $ambiente = $tpAmb == 1 ? "producao" : "homologacao";
        $Webservice = new Webservices();
        $stdWS = $Webservice->get($uf, $ambiente, $service);

        if ($stdWS === null) {
            $msg = " O {$service} não está disponível na SEFAZ $uf!!!";
            throw new Exception\RuntimeException($msg);
        }

        $sigla = $uf;
        if (!$ignoreContingency) {
            $contType = $this->contingency->type;
            if (!empty($contType)
                && ($contType == 'SVCRS' || $contType == 'SVCAN')
            ) {
                $sigla = $contType;
            }
        }
        if ($stdWS === false) {
            throw new \RuntimeException(
                "Nenhum serviço foi localizado para esta unidade "
                . "da federação [$uf]."
            );
        }
        //recuperação da url do serviço
        $this->urlService = $stdWS->url;
        //recuperação do método
        $this->urlMethod = $stdWS->method;
        //recuperação da operação
        $this->urlOperation = $stdWS->operation;
        //recuperação da versão
        $this->urlVersion = $stdWS->version;
        //montagem do namespace do serviço
        $this->urlNamespace = sprintf("%s/wsdl/%s", $this->urlPortal, $stdWS->operation);
        //montagem do cabeçalho da comunicação SOAP
        $this->urlHeader = Header::get($this->urlNamespace, $this->getcUF($this->config->siglaUF), $stdWS->version);
        $this->objHeader = new SoapHeader(
            $this->urlNamespace,
            'mdfeCabecMsg',
            ['cUF' => $this->getcUF($this->config->siglaUF), 'versaoDados' => $stdWS->version]
        );
        $this->urlAction = "\""
            . $this->urlNamespace
            . "/"
            . $this->urlMethod
            . "\"";
    }

    /**
     * Send request message to webservice
     * @param array $parameters
     * @param string $request
     * @return string
     */
    private function sendRequest($request, array $parameters = [])
    {
        $this->checkSoap();
        return (string) $this->soap->send(
            $this->urlService,
            $this->urlMethod,
            $this->urlAction,
            SOAP_1_2,
            $parameters,
            $this->soapnamespaces,
            $request,
            $this->objHeader
        );
    }

    /**
     * Verify if SOAP class is loaded, if not, force load SoapCurl
     */
    private function checkSoap()
    {
        if (empty($this->soap)) {
            $this->soap = new SoapCurl($this->certificate);
        }
    }
}
