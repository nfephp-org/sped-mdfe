<?php

namespace NFePHP\MDFe\Factories;

/**
 * Class QRCode create a string to make a QRCode string
 *
 * @author    Cleiton Perin <cperin20 at gmail dot com>
 * @package   NFePHP\MDFe\Factories\QRCode
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @category  NFePHP
 * @link      http://github.com/nfephp-org/sped-mdfe for the canonical source repository
 */

use DOMDocument;
use NFePHP\MDFe\Exception\DocumentsException;

class QRCode
{
    /**
     * putQRTag
     * @param DOMDocument $dom MDFe
     * @return string
     * @throws DocumentsException
     */
    public static function putQRTag(
        \DOMDocument $dom,
        $certificate
    ) {
        $mdfe = $dom->getElementsByTagName('MDFe')->item(0);
        $infMDFe = $dom->getElementsByTagName('infMDFe')->item(0);
        $ide = $dom->getElementsByTagName('ide')->item(0);
        $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $chMDFe = preg_replace('/[^0-9]/', '', $infMDFe->getAttribute("Id"));
        $sign = '';
        if ($tpEmis == 2) {
            $sign = "&sign=" . base64_encode($certificate->sign($chMDFe));
        }
        $tpAmb = $ide->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $urlQRCode = "https://dfe-portal.svrs.rs.gov.br/mdfe/qrCode?chMDFe=$chMDFe&tpAmb=$tpAmb{$sign}";
        $infMDFeSupl = $dom->createElement("infMDFeSupl");
        $qrCode = $infMDFeSupl->appendChild($dom->createElement('qrCodMDFe'));
        $qrCode->appendChild($dom->createCDATASection($urlQRCode));
        $signature = $dom->getElementsByTagName('Signature')->item(0);
        $mdfe->insertBefore($infMDFeSupl, $signature);
        $dom->formatOutput = false;
        return $dom->saveXML();
    }
}
