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
     * @param int $indSinc flag to use synchronous communication
     * @return   string
     * @throws   Exception\InvalidArgumentException
     */
    public function sefazEnviaLote(
        $aXml,
        $idLote = '',
        $indSinc = 0
    )
    {
        if (!is_array($aXml)) {
            throw new \InvalidArgumentException('Os XML das MDFe devem ser passados em um array.');
        }
        if ($indSinc == 1 && count($aXml) > 1) {
            throw new \InvalidArgumentException('Envio sincrono deve ser usado para enviar '
                . 'uma UNICA mdfe por vez. Você está tentando enviar varias.');
        }
        $servico = 'MDFeRecepcao';
        if ($indSinc == 1) {
            $servico = 'MDFeRecepcaoSinc';
        }
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
        if ($indSinc == 1) {
            $request = base64_encode(gzencode($sxml));
        }
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
     * @param string $indEncPorTerceiro
     * @return string
     */
    public function sefazEncerra(
        $chave,
        $nProt,
        $cUF,
        $cMun,
        $dtEnc = '',
        $indEncPorTerceiro = ''
    )
    {
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
            . "<cMun>$cMun</cMun>";
        if (!empty($indEncPorTerceiro)) {
            $tagAdic .= "<indEncPorTerceiro>$indEncPorTerceiro</indEncPorTerceiro>";
        }
        $tagAdic .= "</evEncMDFe>";
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
    )
    {
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
     * @author João Gabriel
     *
     * @param string $chave
     * @param string $nProt
     * @param string $cMunCarrega
     * @param string $xMunCarrega
     * @param string $cMunDescarga
     * @param string $xMunDescarga
     * @param string $chNFe
     * @param int $nSeqEvento
     * @return string
     */
    public function sefazIncluiDFe(
        $chave = '',
        $nProt = '',
        $cMunCarrega = '',
        $xMunCarrega = '',
        $cMunDescarga = '',
        $xMunDescarga = '',
        $chNFe = '',
        $nSeqEvento = '1'
    )
    {
        $tpEvento = 110115;
        $tagAdic = "<evIncDFeMDFe>"
            . "<descEvento>Inclusao DF-e</descEvento>"
            . "<nProt>$nProt</nProt>"
            . "<cMunCarrega>$cMunCarrega</cMunCarrega>"
            . "<xMunCarrega>$xMunCarrega</xMunCarrega>"
            . "<infDoc>"
            . "<cMunDescarga>$cMunDescarga</cMunDescarga>"
            . "<xMunDescarga>$xMunDescarga</xMunDescarga>"
            . "<chNFe>$chNFe</chNFe>"
            . "</infDoc>"
            . "</evIncDFeMDFe>";

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
        $sigla = (strlen($cnpj) == 11) ? 'CPF' : 'CNPJ';
        $request = "<consMDFeNaoEnc xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<xServ>CONSULTAR NÃO ENCERRADOS</xServ>"
            . "<{$sigla}>$cnpj</{$sigla}>"
            . "</consMDFeNaoEnc>";
        $this->lastRequest = $request;
        $this->isValid($this->urlVersion, $request, 'consMDFeNaoEnc');
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
    public function sefazEvento(
        $uf,
        $chave,
        $tpEvento,
        $nSeqEvento = 1,
        $tagAdic = ''
    )
    {
        //carrega serviço
        $servico = 'MDFeRecepcaoEvento';
        $this->servico(
            $servico,
            $uf,
            $this->tpAmb
        );
        $cnpj = $this->config->cnpj;
        $sigla = (strlen($cnpj) == 11) ? 'CPF' : 'CNPJ';
        $dt = new \DateTime();
        $dhEvento = $dt->format('Y-m-d\TH:i:sP');
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $eventId = "ID" . $tpEvento . $chave . $sSeqEvento;
        $cOrgao = UFList::getCodeByUF($uf);
        $request = "<eventoMDFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<infEvento Id=\"$eventId\">"
            . "<cOrgao>$cOrgao</cOrgao>"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<{$sigla}>$cnpj</{$sigla}>"
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

    /**
     * Service for the distribution of summary information and
     * electronic tax documents of interest to an actor.
     * @param integer $ultNSU last NSU number recived
     * @param integer $numNSU NSU number you wish to consult
     * @return string
     */
    public function sefazDistDFe(
        $ultNSU = 0,
        $numNSU = 0
    )
    {
        //carrega serviço
        $servico = 'MDFeDistribuicaoDFe';
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $this->tpAmb
        );
        $ultNSU = str_pad($ultNSU, 15, '0', STR_PAD_LEFT);
        $tagNSU = "<distNSU><ultNSU>$ultNSU</ultNSU></distNSU>";
        if ($numNSU != 0) {
            $numNSU = str_pad($numNSU, 15, '0', STR_PAD_LEFT);
            $tagNSU = "<consNSU><NSU>$numNSU</NSU></consNSU>";
        }
        //monta a consulta
        $request = "<distDFeInt xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>" . $this->tpAmb . "</tpAmb>"
            . ((strlen($this->config->cnpj) == 14) ?
                "<CNPJ>" . $this->config->cnpj . "</CNPJ>" :
                "<CPF>" . $this->config->cnpj . "</CPF>"
            )
            . $tagNSU . "</distDFeInt>";
        //valida o xml da requisição
        $this->isValid($this->urlVersion, $request, 'distDFeInt');
        $this->lastRequest = $request;
        //montagem dos dados da mensagem SOAP
        $body = "<mdfeDadosMsg xmlns=\"$this->urlNamespace\">$request</mdfeDadosMsg>";
        $parameters = ['mdfeDadosMsg' => $request];
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }
}
