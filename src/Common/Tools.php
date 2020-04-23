<?php

namespace NFePHP\MDFe\Common;

/**
 * Class base responsible for communication with SEFAZ
 *
 * @author    Cleiton Perin <cperin20 at gmail dot com>
 * @package   NFePHP\MDFe\Common\Tools
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @category  NFePHP
 * @link      http://github.com/nfephp-org/sped-mdfe for the canonical source repository
 */

use DOMDocument;
use InvalidArgumentException;
use NFePHP\Common\Certificate;
use NFePHP\Common\Signer;
use NFePHP\Common\Soap\SoapCurl;
use NFePHP\Common\Soap\SoapInterface;
use NFePHP\Common\Strings;
use NFePHP\Common\TimeZoneByUF;
use NFePHP\Common\UFList;
use NFePHP\Common\Validator;
use NFePHP\MDFe\Factories\Header;
use NFePHP\MDFe\Factories\QRCode;
use RuntimeException;

class Tools
{
    /**
     * config class
     * @var \stdClass
     */
    public $config;
    /**
     * Path to storage folder
     * @var string
     */
    public $pathwsfiles = '';
    /**
     * Path to schemes folder
     * @var string
     */
    public $pathschemes = '';
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
     * soap class
     * @var SoapInterface
     */
    public $soap;
    /**
     * Application version
     * @var string
     */
    public $verAplic = '';
    /**
     * last soap request
     * @var string
     */
    public $lastRequest = '';
    /**
     * last soap response
     * @var string
     */
    public $lastResponse = '';
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
    protected $canonical = [true, false, null, null];
    /**
     * Model of MDFe 58
     * @var int
     */
    protected $modelo = 58;
    /**
     * Version of layout
     * @var string
     */
    protected $versao = '3.00';
    /**
     * urlPortal
     * Instância do WebService
     *
     * @var string
     */
    protected $urlPortal = 'http://www.portalfiscal.inf.br/mdfe';
    /**
     * urlcUF
     * @var string
     */
    protected $urlcUF = '';
    /**
     * urlVersion
     * @var string
     */
    protected $urlVersion = '';
    /**
     * urlService
     * @var string
     */
    protected $urlService = '';
    /**
     * @var string
     */
    protected $urlMethod = '';
    /**
     * @var string
     */
    protected $urlOperation = '';
    /**
     * @var string
     */
    protected $urlNamespace = '';
    /**
     * @var string
     */
    protected $urlAction = '';
    /**
     * @var \SOAPHeader
     */
    protected $objHeader;
    /**
     * @var string
     */
    protected $urlHeader = '';
    /**
     * @var array
     */
    /**
     * @var string
     */
    protected $typePerson = 'J';

    protected $soapnamespaces = [
        'xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance",
        'xmlns:xsd' => "http://www.w3.org/2001/XMLSchema",
        'xmlns:soap' => "http://www.w3.org/2003/05/soap-envelope"
    ];
    /**
     * @var array
     */
    protected $availableVersions = [
        '3.00' => 'PL_MDFe_300a',
        '1.00' => 'PL_MDFe_100'
    ];

    /**
     * Constructor
     * load configurations,
     * load Digital Certificate,
     * map all paths,
     * set timezone and
     * @param string $configJson content of config in json format
     * @param Certificate $certificate
     */
    public function __construct($configJson, Certificate $certificate)
    {
        $this->config = json_decode($configJson);
        $this->pathwsfiles = realpath(
            __DIR__ . '/../../storage'
        ) . '/';
        $this->version($this->config->versao);
        $this->setEnvironmentTimeZone($this->config->siglaUF);
        $this->certificate = $certificate;
        $this->setEnvironment($this->config->tpAmb);
        $this->typePerson = $this->getTypeOfPersonFromCertificate();
    }

    /**
     * Sets environment time zone
     * @param string $acronym (ou seja a sigla do estado)
     * @return void
     */
    public function setEnvironmentTimeZone($acronym)
    {
        date_default_timezone_set(TimeZoneByUF::get($acronym));
    }

    /**
     * Set application version
     * @param string $ver
     */
    public function setVerAplic($ver)
    {
        $this->verAplic = $ver;
    }

    /**
     * Return J or F from existing type in ASN.1 certificate
     * J - pessoa juridica (CNPJ)
     * F - pessoa física (CPF)
     * @return string
     */
    public function getTypeOfPersonFromCertificate()
    {
        $cnpj = $this->certificate->getCnpj();
        $type = 'J';
        if (substr($cnpj, 0, 1) === 'N') {
            //não é CNPJ, então verificar se é CPF
            $cpf = $this->certificate->getCpf();
            if (substr($cpf, 0, 1) !== 'N') {
                $type = 'F';
            } else {
                //não foi localizado nem CNPJ e nem CPF esse certificado não é usável
                //throw new RuntimeException('Faltam elementos CNPJ/CPF no certificado digital.');
                $type = '';
            }
        }
        return $type;
    }

    /**
     * Load Soap Class
     * Soap Class may be \NFePHP\Common\Soap\SoapNative
     * or \NFePHP\Common\Soap\SoapCurl
     * @param SoapInterface $soap
     * @return void
     */
    public function loadSoapClass(SoapInterface $soap)
    {
        $this->soap = $soap;
        $this->soap->loadCertificate($this->certificate);
    }

    /**
     * Set OPENSSL Algorithm using OPENSSL constants
     * @param int $algorithm
     * @return void
     */
    public function setSignAlgorithm($algorithm = OPENSSL_ALGO_SHA1)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Set or get parameter layout version
     * @param string $version
     * @return string
     * @throws InvalidArgumentException
     */
    public function version($version = '')
    {
        if (!empty($version)) {
            if (!array_key_exists($version, $this->availableVersions)) {
                throw new \InvalidArgumentException('Essa versão de layout não está disponível');
            }
            $this->versao = $version;
            $this->config->schemes = $this->availableVersions[$version];
            $this->pathschemes = realpath(
                __DIR__ . '/../../schemes/' . $this->config->schemes
            ) . '/';
        }
        return $this->versao;
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
     * Recover state acronym from cUF number
     * @param int $cUF
     * @return string acronym sigla
     */
    public function getAcronym($cUF)
    {
        return UFlist::getUFByCode($cUF);
    }

    /**
     * Validate cUF from the key content and returns the state acronym
     * @param string $chave
     * @return string
     * @throws InvalidArgumentException
     */
    public function validKeyByUF($chave)
    {
        $uf = $this->config->siglaUF;
        if ($uf != UFList::getUFByCode(substr($chave, 0, 2))) {
            throw new \InvalidArgumentException(
                "A chave do MDFe indicado [$chave] não pertence a [$uf]."
            );
        }
        return $uf;
    }

    /**
     * Sign MDFe
     * @param string $xml MDFe xml content
     * @return string singed MDFe xml
     * @throws RuntimeException
     */
    public function signMDFe($xml)
    {
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
        //exception will be throw if MDFe is not valid
        $method = 'mdfe';

        $infMDFeSupl = !empty($dom->getElementsByTagName('infMDFeSupl')->item(0));
        if (!$infMDFeSupl) {
            $signed = $this->addQRCode($dom, $this->certificate);
        }
        //$qrCode = $dom->getElementsByTagName('qrCode')->item(0)->nodeValue;

        $modal = (int) $dom->getElementsByTagName('modal')->item(0)->nodeValue;
        //validate
        $this->isValid($this->versao, $signed, $method);
        //validate modal
        switch ($modal) {
            case 1:
                $this->isValid($this->versao, $this->getModalXML($dom, 'rodo'), $method . 'ModalRodoviario');
                break;
            case 2:
                $this->isValid($this->versao, $this->getModalXML($dom, 'aereo'), $method . 'ModalAereo');
                break;
            case 3:
                $this->isValid($this->versao, $this->getModalXML($dom, 'aquav'), $method . 'ModalAquaviario');
                break;
            case 4:
                $this->isValid($this->versao, $this->getModalXML($dom, 'ferrov'), $method . 'ModalFerroviario');
                break;
        }
        return $signed;
    }

    public function getModalXML($dom, $modal)
    {
        $modal = $dom->getElementsByTagName($modal)->item(0);
        $modal->setAttribute("xmlns", "http://www.portalfiscal.inf.br/mdfe");
        return $dom->saveXML($modal);
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
        $schema = $this->pathschemes . $method . "_v$version.xsd";
        if (!is_file($schema)) {
            return true;
        }
        return Validator::isValid(
            $body,
            $schema
        );
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
     * Set option for canonical transformation see C14n
     * @param array $opt
     * @return array
     */
    public function canonicalOptions($opt = [true, false, null, null])
    {
        if (!empty($opt) && is_array($opt)) {
            $this->canonical = $opt;
        }
        return $this->canonical;
    }

    /**
     * Assembles all the necessary parameters for soap communication
     * @param string $service
     * @param string $uf
     * @param string $tpAmb
     * @return void
     */
    protected function servico(
        $service,
        $uf,
        $tpAmb
    ) {
        $ambiente = $tpAmb == 1 ? "producao" : "homologacao";
        $webs = new Webservices($this->getXmlUrlPath());
        $sigla = $uf;
        $stdServ = $webs->get($sigla, $ambiente, $this->modelo);
        if ($stdServ === false) {
            throw new \RuntimeException(
                "Nenhum serviço foi localizado para esta unidade "
                    . "da federação [$sigla]."
            );
        }
        if (empty($stdServ->$service->url)) {
            throw new \RuntimeException(
                "Este serviço [$service] não está disponivel para esta "
                    . "unidade da federação [$uf] ou para este modelo"
            );
        }
        //recuperação do cUF
        $this->urlcUF = $this->getcUF($uf);
        if ($this->urlcUF > 91) {
            //foi solicitado dado de SVRS ou SVSP
            $this->urlcUF = $this->getcUF($this->config->siglaUF);
        }
        //recuperação da versão
        $this->urlVersion = $stdServ->$service->version;
        //recuperação da url do serviço
        $this->urlService = $stdServ->$service->url;
        //recuperação do método
        $this->urlMethod = $stdServ->$service->method;
        //recuperação da operação
        $this->urlOperation = $stdServ->$service->operation;
        //montagem do namespace do serviço
        $this->urlNamespace = sprintf(
            "%s/wsdl/%s",
            $this->urlPortal,
            $this->urlOperation
        );
        //montagem do cabeçalho da comunicação SOAP
        $this->urlHeader = Header::get(
            $this->urlNamespace,
            $this->urlcUF,
            $this->urlVersion
        );
        $this->urlAction = "\""
            . $this->urlNamespace
            . "/"
            . $this->urlMethod
            . "\"";
        //montagem do SOAP Header
        $this->objHeader = new \SOAPHeader(
            $this->urlNamespace,
            'mdfeCabecMsg',
            ['cUF' => $this->urlcUF, 'versaoDados' => $this->urlVersion]
        );
    }

    /**
     * Send request message to webservice
     * @param array $parameters
     * @param string $request
     * @return string
     */
    protected function sendRequest($request, array $parameters = [])
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
     * Recover path to xml data base with list of soap services
     * @return string
     */
    protected function getXmlUrlPath()
    {
        $file = $this->pathwsfiles
            . DIRECTORY_SEPARATOR
            . "wsmdfe_" . $this->versao . ".xml";
        if (!file_exists($file)) {
            return '';
        }
        return file_get_contents($file);
    }

    /**
     * Add QRCode Tag to signed XML from a NFCe
     * @param DOMDocument $dom
     * @return string
     */
    protected function addQRCode(DOMDocument $dom, $certificate)
    {
        $signed = QRCode::putQRTag(
            $dom,
            $certificate
        );
        return Strings::clearXmlString($signed);
    }

    /**
     * Verify if SOAP class is loaded, if not, force load SoapCurl
     */
    protected function checkSoap()
    {
        if (empty($this->soap)) {
            $this->soap = new SoapCurl($this->certificate);
        }
    }
}
