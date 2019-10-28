<?php

namespace NFePHP\MDFe;

use NFePHP\Common\Signer;
use NFePHP\Common\Strings;
use NFePHP\Common\UFList;
use NFePHP\MDFe\Common\Tools as ToolsCommon;

/**
 * Classe principal para a comunicação com a SEFAZ
 *
 * @author    Cleiton Perin <cperin20 at gmail dot com>
 * @package   nfephp-org/sped-mdfe
 * @copyright 2008-2019 NFePHP
 * @license   http://www.gnu.org/licenses/lesser.html LGPL v3
 * @link      http://github.com/nfephp-org/sped-mdfe for the canonical source repository
 * @category  Library
 */
class Tools extends ToolsCommon
{

    /**
     * @author Cleiton Perin
     *
     * @param array $aXml
     * @param string $idLote
     * @return   string
     * @throws   Exception\InvalidArgumentException
     */
    public function sefazEnviaLote(
        $aXml,
        $idLote = ''
    ) {


        if (!is_array($aXml)) {
            throw new \InvalidArgumentException('Os XML das MDFe devem ser passados em um array.');
        }
        $servico = 'MDFeRecepcao';
        $sxml = implode("", $aXml);
        $sxml = preg_replace("/<\?xml.*?\?>/", "", $sxml);
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $this->tpAmb
        );
        $request = "<enviMDFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<idLote>$idLote</idLote>"
            . "$sxml"
            . "</enviMDFe>";
        $this->isValid($this->urlVersion, $request, 'enviMDFe');
        $this->lastRequest = $request;
        //montagem dos dados da mensagem SOAP
        $parameters = ['mdfeDadosMsg' => $request];
        $body = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$request</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * @author Cleiton Perin
     *
     * @param string $recibo
     * @param string $tpAmb
     * @return   string
     */
    public function sefazConsultaRecibo($recibo, $tpAmb = null)
    {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        //carrega serviço
        $servico = 'MDFeRetRecepcao';
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $tpAmb
        );
        $request = "<consReciMDFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<nRec>$recibo</nRec>"
            . "</consReciMDFe>";
        $this->isValid($this->urlVersion, $request, 'consReciMDFe');
        //montagem dos dados da mensagem SOAP
        $this->lastRequest = $request;
        $parameters = ['mdfeDadosMsg' => $request];
        $body = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$request</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * @author Cleiton Perin
     * Consulta o status da MDFe pela chave de 44 digitos
     *
     * @param string $chave
     * @param string $tpAmb
     * @return   string
     */
    public function sefazConsultaChave($chave, $tpAmb = null)
    {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        //carrega serviço
        $servico = 'MDFeConsulta';
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $tpAmb
        );
        $request = "<consSitMDFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<xServ>CONSULTAR</xServ>"
            . "<chMDFe>$chave</chMDFe>"
            . "</consSitMDFe>";
        $this->isValid($this->urlVersion, $request, 'consSitMDFe');
        $this->lastRequest = $request;
        $parameters = ['mdfeDadosMsg' => $request];
        $body = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$request</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * @author Cleiton Perin
     *
     * @param string $uf sigla da unidade da Federação
     * @param string $tpAmb tipo de ambiente 1-produção e 2-homologação
     * @return   mixed string XML do retorno do webservice, ou false se ocorreu algum erro
     */
    public function sefazStatus($uf = '', $tpAmb = null)
    {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        if (empty($uf)) {
            $uf = $this->config->siglaUF;
        }
        //carrega serviço
        $servico = 'MDFeStatusServico';
        $this->servico(
            $servico,
            $uf,
            $tpAmb
        );
        $request = "<consStatServMDFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<xServ>STATUS</xServ></consStatServMDFe>";
        $this->isValid($this->urlVersion, $request, 'consStatServMDFe');
        $this->lastRequest = $request;
        $parameters = ['mdfeDadosMsg' => $request];
        $body = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$request</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * @author Cleiton Perin
     *
     * @param string $chave
     * @param string $xJust
     * @param string $nProt
     * @return string
     */
    public function sefazCancela($chave, $xJust, $nProt)
    {
        $xJust = Strings::replaceSpecialsChars(
            substr(trim($xJust), 0, 255)
        );
        $tpEvento = 110111;
        $nSeqEvento = 1;
        $tagAdic = "<evCancMDFe>"
            . "<descEvento>Cancelamento</descEvento>"
            . "<nProt>$nProt</nProt>"
            . "<xJust>$xJust</xJust>"
            . "</evCancMDFe>";
        return $this->sefazEvento(
            $this->config->siglaUF,
            $chave,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }

    /**
     * @author Cleiton Perin
     *
     * @param string $chave
     * @param string $nProt
     * @param string $cUF
     * @param string $cMun
     * @param string $dtEnc
     * @return string
     */
    public function sefazEncerra(
        $chave = '',
        $nProt = '',
        $cUF = '',
        $cMun = '',
        $dtEnc = ''
    ) {



        $tpEvento = 110112;
        $nSeqEvento = 1;
        if ($dtEnc == '') {
            $dtEnc = date('Y-m-d');
        }
        $tagAdic = "<evEncMDFe>"
            . "<descEvento>Encerramento</descEvento>"
            . "<nProt>$nProt</nProt>"
            . "<dtEnc>$dtEnc</dtEnc>"
            . "<cUF>$cUF</cUF>"
            . "<cMun>$cMun</cMun>"
            . "</evEncMDFe>";
        return $this->sefazEvento(
            $this->config->siglaUF,
            $chave,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }

    /**
     * @author Cleiton Perin
     *
     * @param string $chave
     * @param string $nSeqEvento
     * @param string $xNome
     * @param string $cpf
     * @return string
     */
    public function sefazIncluiCondutor(
        $chave = '',
        $nSeqEvento = '1',
        $xNome = '',
        $cpf = ''
    ) {



        $tpEvento = 110114;
        $tagAdic = "<evIncCondutorMDFe>"
            . "<descEvento>Inclusao Condutor</descEvento>"
            . "<condutor>"
            . "<xNome>$xNome</xNome>"
            . "<CPF>$cpf</CPF>"
            . "</condutor>"
            . "</evIncCondutorMDFe>";

        return $this->sefazEvento(
            $this->config->siglaUF,
            $chave,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }

    /**
     * @author Cleiton Perin
     *
     * @return string
     */
    public function sefazConsultaNaoEncerrados()
    {
        //carrega serviço
        $servico = 'MDFeConsNaoEnc';
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $this->tpAmb
        );
        $cnpj = $this->config->cnpj;
        $request = "<consMDFeNaoEnc xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<xServ>CONSULTAR NÃO ENCERRADOS</xServ>"
            . "<CNPJ>$cnpj</CNPJ>"
            . "</consMDFeNaoEnc>";
        $this->lastRequest = $request;
        $parameters = ['mdfeDadosMsg' => $request];
        $body = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$request</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * @author Cleiton Perin
     *
     * @param string $uf
     * @param string $chave
     * @param string $cOrgao
     * @param string $tpEvento
     * @param string $nSeqEvento
     * @param string $tagAdic
     * @return   string
     */
    protected function sefazEvento(
        $uf,
        $chave,
        $tpEvento,
        $nSeqEvento = 1,
        $tagAdic = ''
    ) {



        //carrega serviço
        $servico = 'MDFeRecepcaoEvento';
        $this->servico(
            $servico,
            $uf,
            $this->tpAmb
        );
        $cnpj = $this->config->cnpj;
        $sigla = strlen($cnpj) == 11 ? 'CPF' : 'CNPJ';
        $dt = new \DateTime();
        $dhEvento = $dt->format('Y-m-d\TH:i:sP');
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $eventId = "ID" . $tpEvento . $chave . $sSeqEvento;
        $cOrgao = UFList::getCodeByUF($uf);
        $request = "<eventoMDFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<infEvento Id=\"$eventId\">"
            . "<cOrgao>$cOrgao</cOrgao>"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<$sigla>$cnpj</$sigla>"
            . "<chMDFe>$chave</chMDFe>"
            . "<dhEvento>$dhEvento</dhEvento>"
            . "<tpEvento>$tpEvento</tpEvento>"
            . "<nSeqEvento>$nSeqEvento</nSeqEvento>"
            . "<detEvento versaoEvento=\"$this->urlVersion\">"
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
        $request = Strings::clearXmlString($request, true);
        $this->isValid($this->urlVersion, $request, 'eventoMDFe');
        $this->lastRequest = $request;
        $parameters = ['mdfeDadosMsg' => $request];
        $body = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$request</mdfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }
}
