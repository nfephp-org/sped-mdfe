<?php

namespace NFePHP\MDFe\Common;

/**
 * Class to Read and preprocess WS parameters from xml storage
 * file to json encode or stdClass
 *
 * @author    Cleiton Perin <cperin20 at gmail dot com>
 * @package   NFePHP\MDFe\Common\Webservices
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @category  NFePHP
 * @link      http://github.com/nfephp-org/sped-mdfe for the canonical source repository
 */

use SimpleXMLElement;

class Webservices
{
    public $json;
    public $std;

    /**
     * Constructor
     * @param string $xml path or xml content from
     *               nfe_ws3_mod55
     */
    public function __construct($xml)
    {
        $this->toStd($xml);
    }

    /**
     * Get webservices parameters for specific conditions
     * the parameters with the authorizers are in a json file in
     * the storage folder
     * @param string $sigla
     * @param string $ambiente "homologacao" ou "producao"
     * @param string $modelo "58"
     * @return boolean | \stdClass
     */
    public function get($sigla, $ambiente, $modelo)
    {
        $autfile = realpath(__DIR__ . '/../../storage/autorizadores.json');
        $autorizadores = json_decode(file_get_contents($autfile), true);
        if (!key_exists($sigla, $autorizadores[$modelo])) {
            throw new \RuntimeException(
                "Não existe o autorizador [$sigla] para os "
                . "webservices"
            );
        }
        $auto = $autorizadores[$modelo][$sigla];
        if (empty($auto) || empty($this->std)) {
            return false;
        }
        if (empty($this->std->$auto)) {
            throw new \RuntimeException(
                "Não existem webservices cadastrados para  [$sigla]"
            );
        }
        $svw = $this->std->$auto->$ambiente;
        return $svw;
    }

    /**
     * Return WS parameters in a stdClass
     * @param string $xml
     * @return \stdClass
     */
    public function toStd($xml = '')
    {
        if (!empty($xml)) {
            $this->convert($xml);
        }
        return $this->std;
    }

    /**
     * Return WS parameters in json format
     * @return string
     */
    public function __toString()
    {
        return (string)$this->json;
    }

    /**
     * Read WS xml and convert to json and stdClass
     * @param string $xml
     */
    protected function convert($xml)
    {
        $resp = simplexml_load_string($xml, null, LIBXML_NOCDATA);
        $aWS = [];
        foreach ($resp->children() as $element) {
            $sigla = (string)$element->sigla;
            $aWS[$sigla] = [];
            if (isset($element->homologacao)) {
                $aWS[$sigla] += $this->extract($element->homologacao, 'homologacao');
            }
            if (isset($element->producao)) {
                $aWS[$sigla] += $this->extract($element->producao, 'producao');
            }
        }
        $this->json = json_encode($aWS);
        $this->std = json_decode(json_encode($aWS));
    }

    /**
     * Extract data from wbservices XML strorage to a array
     * @param SimpleXMLElement $node
     * @param string $environment
     * @return array
     */
    protected function extract(SimpleXMLElement $node, $environment)
    {
        $amb[$environment] = [];
        foreach ($node->children() as $children) {
            $name = (string)$children->getName();
            $method = (string)$children['method'];
            $operation = (string)$children['operation'];
            $version = (string)$children['version'];
            $url = (string)$children[0];
            $operations = [
                'method' => $method,
                'operation' => $operation,
                'version' => $version,
                'url' => $url
            ];
            $amb[$environment][$name] = $operations;
        }
        return $amb;
    }
}
