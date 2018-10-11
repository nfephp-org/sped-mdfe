<?php

namespace NFePHP\MDFe\Common;

use NFePHP\Common\Validator;
use stdClass;

class Standardize
{
    /**
     * @var string
     */
    private $node = '';
    /**
     * @var string
     */
    private $json = '';
    /**
     * @var string
     */
    public $key = '';
    /**
     * @var object
     */
    private $sxml;
    /**
     * @var array
     */
    public $rootTagList = [
        'distDFeInt',
        'resNFe',
        'resEvento',
        'envEvento',
        'ConsCad',
        'consSitNFe',
        'consReciNFe',
        'downloadNFe',
        'enviNFe',
        'inutNFe',
        'admCscNFCe',
        'consStatServ',
        'retDistDFeInt',
        'retEnvEvento',
        'retConsCad',
        'retConsSitNFe',
        'retConsReciNFe',
        'retDownloadNFe',
        'retEnviNFe',
        'retInutNFe',
        'retAdmCscNFCe',
        'retConsStatServ',
        'procInutNFe',
        'procEventoNFe',
        'procNFe',
        'nfeProc',
        'NFe',
        'retConsMDFeNaoEnc'
    ];

    /**
     * Constructor
     * @param string $xml
     */
    public function __construct($xml = null)
    {
        $this->toStd($xml);
    }

    /**
     * Identify node and extract from XML for convertion type
     * @param string $xml
     * @return string identificated node name
     * @throws \InvalidArgumentException
     */
    public function whichIs($xml)
    {
        if (!Validator::isXML($xml)) {
            //invalid document is not a XML
            throw new \Exception('invalid document is not a XML');
        }
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);
        foreach ($this->rootTagList as $key) {
            $node = !empty($dom->getElementsByTagName($key)->item(0))
                ? $dom->getElementsByTagName($key)->item(0)
                : '';
            if (!empty($node)) {
                $this->node = $dom->saveXML($node);
                return $key;
            }
        }
    }

    /**
     * Returns extract node from XML
     * @return string
     */
    public function __toString()
    {
        return $this->node;
    }

    /**
     * Returns stdClass converted from xml
     * @param string $xml
     * @return stdClass
     */
    public function toStd($xml = null)
    {
        if (!empty($xml)) {
            $this->key = $this->whichIs($xml);
        }
        $this->sxml = simplexml_load_string($this->node);
        $this->json = str_replace(
            '@attributes',
            'attributes',
            json_encode($this->sxml, JSON_PRETTY_PRINT)
        );
        return json_decode($this->json);
    }

    /**
     * Returns the SimpleXml Object
     * @param string $xml
     * @return object
     */
    public function simpleXml($xml = null)
    {
        if (!empty($xml)) {
            $this->toStd($xml);
        }
        return $this->sxml;
    }

    /**
     * Retruns JSON string form XML
     * @param string $xml
     * @return string
     */
    public function toJson($xml = null)
    {
        if (!empty($xml)) {
            $this->toStd($xml);
        }
        return $this->json;
    }

    /**
     * Returns array from XML
     * @param string $xml
     * @return array
     */
    public function toArray($xml = null)
    {
        if (!empty($xml)) {
            $this->toStd($xml);
        }
        return json_decode($this->json, true);
    }
}
