<?php

namespace NFePHP\MDFe\Common;

/**
 * Class for identification and convertion of eletronic documents in xml
 * for documents used in sped-nfe, sped-esocial, sped-cte, sped-mdfe, etc.
 *
 * @author    Cleiton Perin <cperin20 at gmail dot com>
 * @package   NFePHP\Common\Standardize
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @category  NFePHP
 * @link      http://github.com/nfephp-org/sped-mdfe for the canonical source repository
 */

use NFePHP\Common\Validator;
use NFePHP\MDFe\Exception\DocumentsException;
use stdClass;

class Standardize
{
    private $xml = '';
    /**
     * @var string
     */
    public $node = '';
    /**
     * @var string
     */
    public $json = '';
    /**
     * @var string
     */
    public $key = '';
    /**
	@var object
     */

    private object $sxml;
    /**
     * @var array
     */
    public $rootTagList = [
        'enviMDFe',
        'retEnviMDFe',
        'retConsReciMDFe',
        'consSitMDFe',
        'mdfeProc',
        'retConsSitMDFe',
        'retConsMDFeNaoEnc',
        'retConsStatServMDFe',
        'retDistDFeInt',
        'retMDFe',
        'eventoMDFe',
        'retEventoMDFe',
        'evCancMDFe',
        'evEncMDFe',
        'evIncCondutorMDFe',
        'evIncDFeMDFe',
        'MDFe',
        'protMDFe',
    ];

    /**
     * Constructor
     * @param string $xml
     */
    public function __construct(?string $xml = null)
    {
        if (!empty($xml)) {
            $this->xml = $xml;
        }
    }

    /**
     * Identify node and extract from XML for convertion type
     * @param string $xml
     * @return string identificated node name
     * @throws InvalidArgumentException
     */
    public function whichIs(?string $xml = null): string
    {
        if (empty($xml) && empty($this->xml)) {
            throw new DocumentsException("O XML está vazio.");
        }
        if (!empty($xml)) {
            $this->xml = $xml;
        }
        if (!Validator::isXML($this->xml)) {
            //invalid document is not a XML
            throw DocumentsException::wrongDocument(6);
        }
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($this->xml);
        foreach ($this->rootTagList as $key) {
            $node = !empty($dom->getElementsByTagName($key)->item(0))
                ? $dom->getElementsByTagName($key)->item(0)
                : '';
            if (!empty($node)) {
                $this->node = $dom->saveXML($node);
                return $key;
            }
        }
        //documento does not belong to the SPED-NFe project
        throw DocumentsException::wrongDocument(7);
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
    public function toStd(?string $xml = null): stdClass
    {
        if (empty($xml) && empty($this->xml)) {
            throw new DocumentsException("O XML está vazio.");
        }
        if (!empty($xml)) {
            $this->xml = $xml;
        }
        $this->key = $this->whichIs();
        $this->sxml = simplexml_load_string($this->node);
        $this->json = str_replace(
            '@attributes',
            'attributes',
            json_encode($this->sxml, JSON_PRETTY_PRINT)
        );
        $std = json_decode($this->json);

        return $std;
    }
    /**
     * Returns the SimpleXml Object
     * @param string|null $xml
     * @return object
     * @throws DocumentsException
     */
    public function simpleXml(?string $xml = null): object
    {
        $this->checkXml($xml);
        return $this->sxml;
    }
    /**
     * Returns JSON string form XML
     * @param string|null $xml
     * @return string
     * @throws DocumentsException
     */
    public function toJson(?string $xml = null): string
    {
        $this->checkXml($xml);
        return $this->json;
    }
    /**
     * Returns array from XML
     * @param string|null $xml
     * @return array
     * @throws DocumentsException
     */
    public function toArray(?string $xml = null): array
    {
        $this->checkXml($xml);
        return json_decode($this->json, true);
    }

    /**
     * Check and load XML
     * @param string|null $xml
     * @return void
     * @throws DocumentsException
     */
    private function checkXml(?string $xml = null)
    {
        if (empty($xml) && empty($this->xml)) {
            throw new DocumentsException("O XML está vazio.");
        }
        if (!empty($xml)) {
            $this->xml = $xml;
        }
        $this->toStd();
    }
}
