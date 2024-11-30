<?php

use NFePHP\MDFe\Complements;
use NFePHP\MDFe\Exception\DocumentsException;
use PHPUnit\Framework\TestCase;

class ComplementsTest extends TestCase
{

    public function test_shouldThrowDocumentsExceptionWhenCancelTimePass24Hours()
    {
        $request = <<<XML
            <eventoMDFe xmlns="http://www.portalfiscal.inf.br/mdfe" versao="3.00">
                <infEvento Id="ID1101114324110615725000011658001000000075100000000101">
                    <cOrgao>43</cOrgao>
                    <tpAmb>1</tpAmb>
                    <CNPJ>06157250000116</CNPJ>
                    <chMDFe>43241106157250000116580010000000751000000001</chMDFe>
                    <dhEvento>2024-11-29T20:48:53-03:00</dhEvento>
                    <tpEvento>110111</tpEvento>
                    <nSeqEvento>1</nSeqEvento>
                    <detEvento versaoEvento="3.00">
                        <evCancMDFe>
                            <descEvento>Cancelamento</descEvento>
                            <nProt>943240033753981</nProt>
                            <xJust>nao ocorreu a entrega</xJust>
                        </evCancMDFe>
                    </detEvento>
                </infEvento>
                <Signature xmlns="http://www.w3.org/2000/09/xmldsig#">
                    <SignedInfo>
                        <CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" />
                        <SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1" />
                        <Reference URI="#ID1101114324110615725000011658001000000075100000000101">
                            <Transforms>
                                <Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature" />
                                <Transform Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315" />
                            </Transforms>
                            <DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1" />
                            <DigestValue>Rw2TlnWyJcdKqQClJ3puvkC0s/o=</DigestValue>
                        </Reference>
                    </SignedInfo>
                    <SignatureValue></SignatureValue>
                    <KeyInfo>
                        <X509Data>
                            <X509Certificate></X509Certificate>
                        </X509Data>
                    </KeyInfo>
                </Signature>
            </eventoMDFe>
        XML;

        $response = <<<XML
            <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                <soap:Header>
                    <mdfeCabecMsg xmlns="http://www.portalfiscal.inf.br/mdfe/wsdl/MDFeRecepcaoEvento">
                        <cUF>43</cUF>
                        <versaoDados>3.00</versaoDados>
                    </mdfeCabecMsg>
                </soap:Header>
                <soap:Body>
                    <mdfeRecepcaoEventoResult
                        xmlns="http://www.portalfiscal.inf.br/mdfe/wsdl/MDFeRecepcaoEvento">
                        <retEventoMDFe xmlns="http://www.portalfiscal.inf.br/mdfe" versao="3.00">
                            <infEvento Id="ID999999999999999">
                                <tpAmb>1</tpAmb>
                                <verAplic>RS20240710093829</verAplic>
                                <cOrgao>43</cOrgao>
                                <cStat>220</cStat>
                                <xMotivo>Rejeicao: MDF-e autorizada ha mais de 24 horas</xMotivo>
                            </infEvento>
                        </retEventoMDFe>
                    </mdfeRecepcaoEventoResult>
                </soap:Body>
            </soap:Envelope>
        XML;

        $this->expectException(DocumentsException::class);
        $this->expectExceptionMessage('O documento de resposta relata um erro [220] Rejeicao: MDF-e autorizada ha mais de 24 horas.');

        Complements::toAuthorize($request, $response);
    }
}
