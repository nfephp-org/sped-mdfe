<?php

namespace NFePHP\MDFe\Serializer;

use DOMXPath;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

class XmlSerializer
{
    public function serialize($serializable, $rootNodeName = 'MDFe')
    {
        $normalizers = array(new PropertyNormalizer());
        $encoders = array(new XmlEncoder($rootNodeName));
        $serializer = new Serializer($normalizers, $encoders);
        $xmlContent = $serializer->serialize($serializable, 'xml');

        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($xmlContent);

        if ($serializable instanceof TMDFeType && !is_null($serializable->getInfMDFe())) {
            $xmlnsDOMAttr = new \DOMAttr('xmlns', 'http://www.portalfiscal.inf.br/mdfe');
            $dom->firstChild->appendChild($xmlnsDOMAttr);

            /** @var  TMDFeType $serializable */
            $IdDOMAttr = new \DOMAttr('Id', $serializable->getInfMDFe()->getId());
            $versaoDOMAttr = new \DOMAttr('versao', $serializable->getInfMDFe()->getVersao());
            $infMDFeDOMNode = $dom->getElementsByTagName('infMDFe')->item(0);
            $infMDFeDOMNode->appendChild($IdDOMAttr);
            $infMDFeDOMNode->appendChild($versaoDOMAttr);

            $xpath = new DOMXPath($dom);
            $versaoDOMNode = $xpath->query('/MDFe/infMDFe/versao')->item(0);
            $IdDOMNode = $xpath->query('/MDFe/infMDFe/Id')->item(0);
            $infMDFeDOMNode->removeChild($versaoDOMNode);
            $infMDFeDOMNode->removeChild($IdDOMNode);

            if (!is_null($serializable->getInfMDFe()->getInfModal())) {
                $versaoModal = $serializable->getInfMDFe()->getInfModal()->getVersaoModal();
                $versaoModalDOMAttr = new \DOMAttr('versaoModal', $versaoModal);
                $infModalDOMNode = $dom->getElementsByTagName('infModal')->item(0);
                $infModalDOMNode->appendChild($versaoModalDOMAttr);

                $versaoModalDOMNode = $xpath->query('/MDFe/infMDFe/infModal/versaoModal')->item(0);
                $infModalDOMNode->removeChild($versaoModalDOMNode);
            }
        }
        $xpath = new DOMXPath($dom);
        foreach ($xpath->query('//*[not(normalize-space())]') as $node) {
            /** @var \DOMNode $node */
            $node->parentNode->removeChild($node);
        }
        return $dom->saveXML();
    }
}
