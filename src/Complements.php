<?php

namespace NFePHP\MDFe;

use DOMDocument;
use NFePHP\MDFe\Common\Standardize;
use NFePHP\MDFe\Exception\DocumentsException;

class Complements
{
    protected static $urlPortal = 'http://www.portalfiscal.inf.br/mdfe';

    /**
     * Authorize document adding his protocol
     * @param string $request
     * @param string $response
     * @return string
     */
    public static function toAuthorize($request, $response)
    {
        $st = new Standardize();
        $key = ucfirst($st->whichIs($request));
        if ($key != 'MDFe' && $key != 'EventoMDFe') {
            //wrong document, this document is not able to recieve a protocol
            throw DocumentsException::wrongDocument(0, $key);
        }
        $func = "add" . $key . "Protocol";
        return self::$func($request, $response);
    }

    /**
     * Authorize MDFe
     * @param string $request
     * @param string $response
     * @return string
     * @throws InvalidArgumentException
     */
    protected static function addMDFeProtocol($request, $response)
    {
        $req = new DOMDocument('1.0', 'UTF-8');
        $req->preserveWhiteSpace = false;
        $req->formatOutput = false;
        $req->loadXML($request);

        $mdfe = $req->getElementsByTagName('MDFe')->item(0);
        $infMDFe = $req->getElementsByTagName('infMDFe')->item(0);
        $versao = $infMDFe->getAttribute("versao");
        $digMDFe = $req->getElementsByTagName('DigestValue')
            ->item(0)
            ->nodeValue;

        $ret = new DOMDocument('1.0', 'UTF-8');
        $ret->preserveWhiteSpace = false;
        $ret->formatOutput = false;
        $ret->loadXML($response);
        $retProt = $ret->getElementsByTagName('protMDFe')->item(0);
        if (!isset($retProt)) {
            throw DocumentsException::wrongDocument(3, "&lt;protMDFe&gt;");
        }
        $infProt = $ret->getElementsByTagName('infProt')->item(0);
        $cStat = $infProt->getElementsByTagName('cStat')->item(0)->nodeValue;
        $xMotivo = $infProt->getElementsByTagName('xMotivo')->item(0)->nodeValue;
        $dig = $infProt->getElementsByTagName("digVal")->item(0);
        $digProt = '000';
        if (isset($dig)) {
            $digProt = $dig->nodeValue;
        }
        //100 Autorizado
        if ($cStat != '100') {
            throw DocumentsException::wrongDocument(4, "[$cStat] $xMotivo");
        }
        if ($digMDFe !== $digProt) {
            throw DocumentsException::wrongDocument(5, "O digest é diferente");
        }
        return self::join(
            $req->saveXML($mdfe),
            $ret->saveXML($retProt),
            'mdfeProc',
            $versao
        );
    }

    /**
     * Authorize Event
     * @param string $request
     * @param string $response
     * @return string
     * @throws InvalidArgumentException
     */
    protected static function addEventoMDFeProtocol($request, $response)
    {
        $ev = new \DOMDocument('1.0', 'UTF-8');
        $ev->preserveWhiteSpace = false;
        $ev->formatOutput = false;
        $ev->loadXML($request);
        //extrai tag evento do xml origem (solicitação)
        $event = $ev->getElementsByTagName('eventoMDFe')->item(0);
        $versao = $event->getAttribute('versao');

        $ret = new \DOMDocument('1.0', 'UTF-8');
        $ret->preserveWhiteSpace = false;
        $ret->formatOutput = false;
        $ret->loadXML($response);
        //extrai a rag retEvento da resposta (retorno da SEFAZ)
        $retEv = $ret->getElementsByTagName('retEventoMDFe')->item(0);
        $cStat = $retEv->getElementsByTagName('cStat')->item(0)->nodeValue;
        $xMotivo = $retEv->getElementsByTagName('xMotivo')->item(0)->nodeValue;
        $tpEvento = $retEv->getElementsByTagName('tpEvento')->item(0)->nodeValue;
        if ($tpEvento == '110111') {
            $node = 'procCancMDFe';
        } elseif ($tpEvento == '110112') {
            $node = 'procEncMDFe';
        } elseif ($tpEvento == '110114') {
            $node = 'procIncCondutor';
        } else {
            throw DocumentsException::wrongDocument(4, "Evento não disponivel.");
        }
        if ($cStat != '135') {
            throw DocumentsException::wrongDocument(4, "[$cStat] $xMotivo");
        }
        return self::join(
            $ev->saveXML($event),
            $ret->saveXML($retEv),
            $node,
            $versao
        );
    }

    /**
     * Join the pieces of the source document with those of the answer
     * @param string $first
     * @param string $second
     * @param string $nodename
     * @param string $versao
     * @return string
     */
    protected static function join($first, $second, $nodename, $versao)
    {
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
            . "<$nodename versao=\"$versao\" "
            . "xmlns=\"" . self::$urlPortal . "\">";
        $xml .= $first;
        $xml .= $second;
        $xml .= "</$nodename>";
        return $xml;
    }
}
