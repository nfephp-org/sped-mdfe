<?php

namespace NFePHP\MDFe;

/**
 * Classe a construção do xml do Manifesto Eletrônico de Documentos Fiscais (MDF-e)
 * NOTA: Esta classe foi construida conforme estabelecido no
 * Manual de Orientação do Contribuinte
 * Padrões Técnicos de Comunicação do Manifesto Eletrônico de Documentos Fiscais
 * versão 1.00 de Junho de 2012
 *
 * @category  Library
 * @package   nfephp-org/sped-mdfe
 * @name      Make.php
 * @copyright 2009-2016 NFePHP
 * @license   http://www.gnu.org/licenses/lesser.html LGPL v3
 * @link      http://github.com/nfephp-org/sped-mdfe for the canonical source repository
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 */

use NFePHP\Common\DateTime\DateTime;
use NFePHP\Common\Base\BaseMake;
use \DOMElement;

class Make extends BaseMake
{
    /**
     * versao
     * numero da versão do xml da MDFe
     *
     * @var string
     */
    public $versao = '1.00';
    /**
     * mod
     * modelo da MDFe 58
     *
     * @var integer
     */
    public $mod = '58';
    /**
     * chave da MDFe
     *
     * @var string
     */
    public $chMDFe = '';

    //propriedades privadas utilizadas internamente pela classe
    /**
     * @type string|\DOMNode
     */
    private $MDFe = '';
    /**
     * @type string|\DOMNode
     */
    private $infMDFe = '';
    /**
     * @type string|\DOMNode
     */
    private $ide = '';
    /**
     * @type string|\DOMNode
     */
    private $emit = '';
    /**
     * @type string|\DOMNode
     */
    private $enderEmit = '';
    /**
     * @type string|\DOMNode
     */
    private $infModal = '';
    /**
     * @type string|\DOMNode
     */
    private $seg = '';
    /**
     * @type string|\DOMNode
     */
    private $infSeg = '';
    /**
     * @type string|\DOMNode
     */
    private $infResp = '';
    /**
     * @type string|\DOMNode
     */
    private $tot = '';
    /**
     * @type string|\DOMNode
     */
    private $infAdic = '';
    /**
     * @type string|\DOMNode
     */
    private $rodo = '';
    /**
     * @type string|\DOMNode
     */
    private $veicTracao = '';
    /**
     * @type string|\DOMNode
     */
    private $aereo = '';
    /**
     * @type string|\DOMNode
     */
    private $trem = '';
    /**
     * @type string|\DOMNode
     */
    private $aqua = '';

    // Arrays
    private $aInfMunCarrega = []; //array de DOMNode
    private $aInfPercurso = []; //array de DOMNode
    private $aInfMunDescarga = []; //array de DOMNode
    private $aInfCTe = []; //array de DOMNode
    private $aInfNFe = []; //array de DOMNode
    private $aInfMDFe = []; //array de DOMNode
    private $aLacres = []; //array de DOMNode
    private $aAutXML = []; //array de DOMNode
    private $aCondutor = []; //array de DOMNode
    private $aInfContratante = []; //array de DOMNode
    private $aReboque = []; //array de DOMNode
    private $aDisp = []; //array de DOMNode
    private $aVag = []; //array de DOMNode
    private $aInfTermCarreg = []; //array de DOMNode
    private $aInfTermDescarreg = []; //array de DOMNode
    private $aInfEmbComb = []; //array de DOMNode
    private $aCountDoc = []; //contador de documentos fiscais

    /**
     *
     * @return boolean
     */
    public function montaMDFe()
    {
        if (count($this->erros) > 0) {
            return false;
        }
        //cria a tag raiz da MDFe
        $this->zTagMDFe();
        //monta a tag ide com as tags adicionais
        $this->zTagIde();
        //tag ide [4]
        $this->dom->appChild($this->infMDFe, $this->ide, 'Falta tag "infMDFe"');
        //tag enderemit [30]
        $this->dom->appChild($this->emit, $this->enderEmit, 'Falta tag "emit"');
        //tag emit [25]
        $this->dom->appChild($this->infMDFe, $this->emit, 'Falta tag "infMDFe"');
        //tag infModal [41]
        $this->zTagRodo();
        $this->zTagAereo();
        $this->zTagFerrov();
        $this->zTagAqua();
        $this->dom->appChild($this->infMDFe, $this->infModal, 'Falta tag "infMDFe"');
        //tag indDoc [44]
        $this->zTagInfDoc();
        $this->dom->appChild($this->infMDFe, $this->seg, 'Falta tag "infMDFe"');
        //tag tot [68]
        $this->dom->appChild($this->infMDFe, $this->tot, 'Falta tag "infMDFe"');
        //tag lacres [76]
        $this->zTagLacres();
        // tag autXML [137]
        foreach ($this->aAutXML as $aut) {
            $this->dom->appChild($this->infMDFe, $aut, 'Falta tag "infMDFe"');
        }
        //tag infAdic [78]
        $this->dom->appChild($this->infMDFe, $this->infAdic, 'Falta tag "infMDFe"');
        //[1] tag infMDFe (1 A01)
        $this->dom->appChild($this->MDFe, $this->infMDFe, 'Falta tag "MDFe"');
        //[0] tag MDFe
        $this->dom->appChild($this->dom, $this->MDFe, 'Falta DOMDocument');
        // testa da chave
        $this->zTestaChaveXML($this->dom);
        //convert DOMDocument para string
        $this->xml = $this->dom->saveXML();
        return true;
    }


    /**
     * taginfMDFe
     * Informações da MDFe 1 pai MDFe
     * tag MDFe/infMDFe
     *
     * @param  string $chave
     * @param  string $versao
     *
     * @return DOMElement
     */
    public function taginfMDFe($chave = '', $versao = '')
    {
        $this->infMDFe = $this->dom->createElement("infMDFe");
        $this->infMDFe->setAttribute("Id", 'MDFe'.$chave);
        $this->infMDFe->setAttribute("versao", $versao);
        $this->versao = $versao;
        $this->chMDFe = $chave;
        return $this->infMDFe;
    }

    /**
     * tgaide
     * Informações de identificação da MDFe 4 pai 1
     * tag MDFe/infMDFe/ide
     *
     * @param  string $cUF
     * @param  string $tpAmb
     * @param  string $tpEmit
     * @param  string $mod
     * @param  string $serie
     * @param  string $nMDF
     * @param  string $cMDF
     * @param  string $cDV
     * @param  string $modal
     * @param  string $dhEmi
     * @param  string $tpEmis
     * @param  string $procEmi
     * @param  string $verProc
     * @param  string $ufIni
     * @param  string $ufFim
     *
     * @return DOMElement
     */
    public function tagide(
        $cUF = '',
        $tpAmb = '',
        $tpEmit = '',
        $mod = '58',
        $serie = '',
        $nMDF = '',
        $cMDF = '',
        $cDV = '',
        $modal = '',
        $dhEmi = '',
        $tpEmis = '',
        $procEmi = '',
        $verProc = '',
        $ufIni = '',
        $ufFim = ''
    ) {
        $this->tpAmb = $tpAmb;
        if ($dhEmi == '') {
            $dhEmi = DateTime::convertTimestampToSefazTime();
        }
        $identificador = '[4] <ide> - ';
        $ide = $this->dom->createElement("ide");
        $this->dom->addChild(
            $ide,
            "cUF",
            $cUF,
            true,
            $identificador . "Código da UF do emitente do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "tpAmb",
            $tpAmb,
            true,
            $identificador . "Identificação do Ambiente"
        );
        $this->dom->addChild(
            $ide,
            "tpEmit",
            $tpEmit,
            true,
            $identificador . "Indicador da tipo de emitente"
        );
        $this->dom->addChild(
            $ide,
            "mod",
            $mod,
            true,
            $identificador . "Código do Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "serie",
            $serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "nMDF",
            $nMDF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "cMDF",
            $cMDF,
            true,
            $identificador . "Código do numérico do MDF"
        );
        $this->dom->addChild(
            $ide,
            "cDV",
            $cDV,
            true,
            $identificador . "Dígito Verificador da Chave de Acesso da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "modal",
            $modal,
            true,
            $identificador . "Modalidade de transporte"
        );
        $this->dom->addChild(
            $ide,
            "dhEmi",
            $dhEmi,
            true,
            $identificador . "Data e hora de emissão do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "tpEmis",
            $tpEmis,
            true,
            $identificador . "Tipo de Emissão do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "procEmi",
            $procEmi,
            true,
            $identificador . "Processo de emissão"
        );
        $this->dom->addChild(
            $ide,
            "verProc",
            $verProc,
            true,
            $identificador . "Versão do Processo de emissão"
        );
        $this->dom->addChild(
            $ide,
            "UFIni",
            $ufIni,
            true,
            $identificador . "Sigla da UF do Carregamento"
        );
        $this->dom->addChild(
            $ide,
            "UFFim",
            $ufFim,
            true,
            $identificador . "Sigla da UF do Descarregamento"
        );
        $this->mod = $mod;
        $this->ide = $ide;
        return $ide;
    }

    /**
     * tagInfMunCarrega
     *
     * tag MDFe/infMDFe/ide/infMunCarrega
     *
     * @param  string $cMunCarrega
     * @param  string $xMunCarrega
     *
     * @return DOMElement
     */
    public function tagInfMunCarrega(
        $cMunCarrega = '',
        $xMunCarrega = ''
    ) {
        $infMunCarrega = $this->dom->createElement("infMunCarrega");
        $this->dom->addChild(
            $infMunCarrega,
            "cMunCarrega",
            $cMunCarrega,
            true,
            "Código do Município de Carregamento"
        );
        $this->dom->addChild(
            $infMunCarrega,
            "xMunCarrega",
            $xMunCarrega,
            true,
            "Nome do Município de Carregamento"
        );
        $this->aInfMunCarrega[] = $infMunCarrega;
        return $infMunCarrega;
    }

    /**
     * tagInfPercurso
     *
     * tag MDFe/infMDFe/ide/infPercurso
     *
     * @param  string $ufPer
     *
     * @return DOMElement
     */
    public function tagInfPercurso($ufPer = '')
    {
        $infPercurso = $this->dom->createElement("infPercurso");
        $this->dom->addChild(
            $infPercurso,
            "UFPer",
            $ufPer,
            true,
            "Sigla das Unidades da Federação do percurso"
        );
        $this->aInfPercurso[] = $infPercurso;
        return $infPercurso;
    }

    /**
     * tagemit
     * Identificação do emitente da MDFe [25] pai 1
     * tag MDFe/infMDFe/emit
     *
     * @param  string $cnpj
     * @param  string $numIE
     * @param  string $xNome
     * @param  string $xFant
     *
     * @return DOMElement
     */
    public function tagemit(
        $cnpj = '',
        $numIE = '',
        $xNome = '',
        $xFant = ''
    ) {
        $identificador = '[25] <emit> - ';
        $this->emit = $this->dom->createElement("emit");
        $this->dom->addChild($this->emit, "CNPJ", $cnpj, true, $identificador . "CNPJ do emitente");
        $this->dom->addChild($this->emit, "IE", $numIE, true, $identificador . "Inscrição Estadual do emitente");
        $this->dom->addChild($this->emit, "xNome", $xNome, true, $identificador . "Razão Social ou Nome do emitente");
        $this->dom->addChild($this->emit, "xFant", $xFant, false, $identificador . "Nome fantasia do emitente");
        return $this->emit;
    }

    /**
     * tagenderEmit
     * Endereço do emitente [30] pai [25]
     * tag MDFe/infMDFe/emit/endEmit
     *
     * @param  string $xLgr
     * @param  string $nro
     * @param  string $xCpl
     * @param  string $xBairro
     * @param  string $cMun
     * @param  string $xMun
     * @param  string $cep
     * @param  string $siglaUF
     * @param  string $fone
     * @param  string $email
     *
     * @return DOMElement
     */
    public function tagenderEmit(
        $xLgr = '',
        $nro = '',
        $xCpl = '',
        $xBairro = '',
        $cMun = '',
        $xMun = '',
        $cep = '',
        $siglaUF = '',
        $fone = '',
        $email = ''
    ) {
        $identificador = '[30] <enderEmit> - ';
        $this->enderEmit = $this->dom->createElement("enderEmit");
        $this->dom->addChild(
            $this->enderEmit,
            "xLgr",
            $xLgr,
            true,
            $identificador . "Logradouro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "nro",
            $nro,
            true,
            $identificador . "Número do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xCpl",
            $xCpl,
            false,
            $identificador . "Complemento do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xBairro",
            $xBairro,
            true,
            $identificador . "Bairro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "cMun",
            $cMun,
            true,
            $identificador . "Código do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xMun",
            $xMun,
            true,
            $identificador . "Nome do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "CEP",
            $cep,
            true,
            $identificador . "Código do CEP do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "UF",
            $siglaUF,
            true,
            $identificador . "Sigla da UF do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "fone",
            $fone,
            false,
            $identificador . "Número de telefone do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "email",
            $email,
            false,
            $identificador . "Endereço de email do emitente"
        );
        return $this->enderEmit;
    }

    /**
     * tagInfMunDescarga
     * tag MDFe/infMDFe/infDoc/infMunDescarga
     *
     * @param  integer $nItem
     * @param  string  $cMunDescarga
     * @param  string  $xMunDescarga
     *
     * @return DOMElement
     */
    public function tagInfMunDescarga(
        $nItem = 0,
        $cMunDescarga = '',
        $xMunDescarga = ''
    ) {
        $infMunDescarga = $this->dom->createElement("infMunDescarga");
        $this->dom->addChild(
            $infMunDescarga,
            "cMunDescarga",
            $cMunDescarga,
            true,
            "Código do Município de Descarga"
        );
        $this->dom->addChild(
            $infMunDescarga,
            "xMunDescarga",
            $xMunDescarga,
            true,
            "Nome do Município de Descarga"
        );
        $this->aInfMunDescarga[$nItem] = $infMunDescarga;
        return $infMunDescarga;
    }

    /**
     * tagInfCTe
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infCTe
     *
     * @param  integer $nItem
     * @param  string  $chCTe
     * @param  string  $segCodBarra
     *
     * @return DOMElement
     */
    public function tagInfCTe(
        $nItem = 0,
        $chCTe = '',
        $segCodBarra = ''
    ) {
        $infCTe = $this->dom->createElement("infCTe");
        $this->dom->addChild(
            $infCTe,
            "chCTe",
            $chCTe,
            true,
            "Chave de Acesso CTe"
        );
        $this->dom->addChild(
            $infCTe,
            "SegCodBarra",
            $segCodBarra,
            false,
            "Segundo código de barras do CTe"
        );
        $this->aInfCTe[$nItem][] = $infCTe;
        return $infCTe;
    }

    /**
     * tagInfNFe
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infNFe
     *
     * @param  integer $nItem
     * @param  string  $chNFe
     * @param  string  $segCodBarra
     *
     * @return DOMElement
     */
    public function tagInfNFe(
        $nItem = 0,
        $chNFe = '',
        $segCodBarra = ''
    ) {
        $infNFe = $this->dom->createElement("infNFe");
        $this->dom->addChild(
            $infNFe,
            "chNFe",
            $chNFe,
            true,
            "Chave de Acesso da NFe"
        );
        $this->dom->addChild(
            $infNFe,
            "SegCodBarra",
            $segCodBarra,
            false,
            "Segundo código de barras da NFe"
        );
        $this->aInfNFe[$nItem][] = $infNFe;
        return $infNFe;
    }

    /**
     * tagInfMDFeTransp
     * tag MDFe/infMDFeTransp/infDoc/infMunDescarga/infMDFeTranspTransp
     *
     * @param  integer $nItem
     * @param  string  $chMDFe
     *
     * @return DOMElement
     */
    public function tagInfMDFeTransp(
        $nItem = 0,
        $chMDFe = ''
    ) {
        $infMDFeTransp = $this->dom->createElement("infMDFeTransp");
        $this->dom->addChild(
            $infMDFeTransp,
            "chMDFe",
            $chMDFe,
            true,
            "Chave de Acesso da MDFe"
        );
        $this->aInfMDFe[$nItem][] = $infMDFeTransp;
        return $infMDFeTransp;
    }

    /**
     * tagSeg
     * tag MDFe/infMDFe/seg
     *
     * @param  string $respSeg
     * @param  string $cnpj
     * @param  string $cpf
     * @param  string $xSeg
     * @param  string $cnpjSeguradora
     * @param  string $nApol
     * @param  string $nAver
     *
     * @return DOMElement
     */
    public function tagSeg(
        $respSeg = '',
        $cnpj = '',
        $cpf = '',
        $xSeg = '',
        $cnpjSeguradora = '',
        $nApol = '',
        $nAver = ''
    ) {
        $seg = $this->dom->createElement("seg");
        $infResp = $this->dom->createElement("infResp");
        $this->dom->addChild(
            $infResp,
            "respSeg",
            $respSeg,
            true,
            "Responsável pelo seguro"
        );
        $this->dom->addChild(
            $infResp,
            "CNPJ",
            $cnpj,
            false,
            "Número do CNPJ do responsável pelo seguro"
        );
        $this->dom->addChild(
            $infResp,
            "CPF",
            $cpf,
            false,
            "Número do CPF do responsável pelo seguro"
        );
        $infSeg = '';
        if ($cnpjSeguradora != '' && $xSeg != '') {
            $infSeg = $this->dom->createElement("infSeg");
            $this->dom->addChild(
                $infSeg,
                "xSeg",
                $xSeg,
                true,
                "Nome da Seguradora"
            );
            $this->dom->addChild(
                $infSeg,
                "CNPJ",
                $cnpjSeguradora,
                true,
                "Número do CNPJ da seguradora"
            );
        }
        $this->dom->appChild($seg, $infResp, 'Falta tag "seg"');
        $this->dom->appChild($seg, $infSeg, 'Falta tag "seg"');

        $this->dom->addChild(
            $seg,
            "nApol",
            $nApol,
            false,
            "Número da Apólice"
        );
        $this->dom->addChild(
            $seg,
            "nAver",
            $nAver,
            false,
            "Número da Averbação"
        );

        $this->seg = $seg;
        return $seg;
    }

    /**
     * tagTot
     * tag MDFe/infMDFe/tot
     *
     * @param  string $qCTe
     * @param  string $qNFe
     * @param  string $qMDFe
     * @param  string $vCarga
     * @param  string $cUnid
     * @param  string $qCarga
     *
     * @return DOMElement
     */
    public function tagTot(
        $qCTe = '',
        $qNFe = '',
        $qMDFe = '',
        $vCarga = '',
        $cUnid = '',
        $qCarga = ''
    ) {
        $tot = $this->dom->createElement("tot");
        $this->dom->addChild(
            $tot,
            "qCTe",
            $qCTe,
            false,
            "Quantidade total de CT-e relacionados no Manifesto"
        );
        $this->dom->addChild(
            $tot,
            "qNFe",
            $qNFe,
            false,
            "Quantidade total de NF-e relacionados no Manifesto"
        );
        $this->dom->addChild(
            $tot,
            "qMDFe",
            $qMDFe,
            false,
            "Quantidade total de MDF-e relacionados no Manifesto"
        );
        $this->dom->addChild(
            $tot,
            "vCarga",
            $vCarga,
            true,
            "Valor total da mercadoria/carga transportada"
        );
        $this->dom->addChild(
            $tot,
            "cUnid",
            $cUnid,
            true,
            "Código da unidade de medida do Peso Bruto da Carga / Mercadoria Transportada"
        );
        $this->dom->addChild(
            $tot,
            "qCarga",
            $qCarga,
            true,
            "Peso Bruto Total da Carga / Mercadoria Transportada"
        );
        $this->tot = $tot;
        return $tot;
    }

    /**
     * tagLacres
     * tag MDFe/infMDFe/lacres
     *
     * @param  string $nLacre
     *
     * @return DOMElement
     */
    public function tagLacres(
        $nLacre = ''
    ) {
        $lacres = $this->dom->createElement("lacres");
        $this->dom->addChild(
            $lacres,
            "nLacre",
            $nLacre,
            false,
            "Número do lacre"
        );
        $this->aLacres[] = $lacres;
        return $lacres;
    }

    /**
     * taginfAdic
     * Grupo de Informações Adicionais Z01 pai A01
     * tag MDFe/infMDFe/infAdic (opcional)
     *
     * @param  string $infAdFisco
     * @param  string $infCpl
     *
     * @return DOMElement
     */
    public function taginfAdic(
        $infAdFisco = '',
        $infCpl = ''
    ) {
        $infAdic = $this->dom->createElement("infAdic");
        $this->dom->addChild(
            $infAdic,
            "infAdFisco",
            $infAdFisco,
            false,
            "Informações Adicionais de Interesse do Fisco"
        );
        $this->dom->addChild(
            $infAdic,
            "infCpl",
            $infCpl,
            false,
            "Informações Complementares de interesse do Contribuinte"
        );
        $this->infAdic = $infAdic;
        return $infAdic;
    }

    /**
     * tagLacres
     * tag MDFe/infMDFe/autXML
     *
     * Autorizados para download do XML do MDF-e
     *
     * @param string $cnpj
     * @param string $cpf
     *
     * @return DOMElement
     */
    public function tagautXML($cnpj = '', $cpf = '')
    {
        $autXML = $this->dom->createElement("autXML");
        $this->dom->addChild(
            $autXML,
            "CNPJ",
            $cnpj,
            false,
            "CNPJ do autorizado"
        );
        $this->dom->addChild(
            $autXML,
            "CPF",
            $cpf,
            false,
            "CPF do autorizado"
        );
        $this->aAutXML[] = $autXML;
        return $autXML;
    }

    /**
     * tagInfModal
     * tag MDFe/infMDFe/infModal
     *
     * @param  string $versaoModal
     *
     * @return DOMElement
     */
    public function tagInfModal($versaoModal = '')
    {
        $infModal = $this->dom->createElement("infModal");
        $infModal->setAttribute("versaoModal", $versaoModal);
        $this->infModal = $infModal;
        return $infModal;
    }

    /**
     * tagAereo
     * tag MDFe/infMDFe/infModal/aereo
     *
     * @param  string $nac
     * @param  string $matr
     * @param  string $nVoo
     * @param  string $cAerEmb
     * @param  string $cAerDes
     * @param  string $dVoo
     *
     * @return DOMElement
     */
    public function tagAereo(
        $nac = '',
        $matr = '',
        $nVoo = '',
        $cAerEmb = '',
        $cAerDes = '',
        $dVoo = ''
    ) {
        $aereo = $this->dom->createElement("aereo");
        $this->dom->addChild(
            $aereo,
            "nac",
            $nac,
            true,
            "Marca da Nacionalidade da aeronave"
        );
        $this->dom->addChild(
            $aereo,
            "matr",
            $matr,
            true,
            "Marca de Matrícula da aeronave"
        );
        $this->dom->addChild(
            $aereo,
            "nVoo",
            $nVoo,
            true,
            "Número do Vôo"
        );
        $this->dom->addChild(
            $aereo,
            "cAerEmb",
            $cAerEmb,
            true,
            "Aeródromo de Embarque - Código IATA"
        );
        $this->dom->addChild(
            $aereo,
            "cAerDes",
            $cAerDes,
            true,
            "Aeródromo de Destino - Código IATA"
        );
        $this->dom->addChild(
            $aereo,
            "dVoo",
            $dVoo,
            true,
            "Data do Vôo"
        );
        $this->aereo = $aereo;
        return $aereo;
    }

    /**
     * tagTrem
     * tag MDFe/infMDFe/infModal/ferrov/trem
     *
     * @param  string $xPref
     * @param  string $dhTrem
     * @param  string $xOri
     * @param  string $xDest
     * @param  string $qVag
     *
     * @return DOMElement
     */
    public function tagTrem(
        $xPref = '',
        $dhTrem = '',
        $xOri = '',
        $xDest = '',
        $qVag = ''
    ) {
        $trem = $this->dom->createElement("trem");
        $this->dom->addChild(
            $trem,
            "xPref",
            $xPref,
            true,
            "Prefixo do Trem"
        );
        $this->dom->addChild(
            $trem,
            "dhTrem",
            $dhTrem,
            false,
            "Data e hora de liberação do trem na origem"
        );
        $this->dom->addChild(
            $trem,
            "xOri",
            $xOri,
            true,
            "Origem do Trem"
        );
        $this->dom->addChild(
            $trem,
            "xDest",
            $xDest,
            true,
            "Destino do Trem"
        );
        $this->dom->addChild(
            $trem,
            "qVag",
            $qVag,
            true,
            "Quantidade de vagões"
        );
        $this->trem = $trem;
        return $trem;
    }

    /**
     * tagVag
     * tag MDFe/infMDFe/infModal/ferrov/trem/vag
     *
     * @param  string $serie
     * @param  string $nVag
     * @param  string $nSeq
     * @param  string $tonUtil
     *
     * @return DOMElement
     */
    public function tagVag(
        $serie = '',
        $nVag = '',
        $nSeq = '',
        $tonUtil = ''
    ) {
        $vag = $this->dom->createElement("vag");
        $this->dom->addChild(
            $vag,
            "serie",
            $serie,
            true,
            "Série de Identificação do vagão"
        );
        $this->dom->addChild(
            $vag,
            "nVag",
            $nVag,
            true,
            "Número de Identificação do vagão"
        );
        $this->dom->addChild(
            $vag,
            "nSeq",
            $nSeq,
            false,
            "Sequência do vagão na composição"
        );
        $this->dom->addChild(
            $vag,
            "TU",
            $tonUtil,
            true,
            "Tonelada Útil"
        );
        $this->aVag[] = $vag;
        return $vag;
    }

    /**
     * tagAqua
     * tag MDFe/infMDFe/infModal/Aqua
     *
     * @param  string $cnpjAgeNav
     * @param  string $tpEmb
     * @param  string $cEmbar
     * @param  string $nViagem
     * @param  string $cPrtEmb
     * @param  string $cPrtDest
     *
     * @return DOMElement
     */
    public function tagAqua(
        $cnpjAgeNav = '',
        $tpEmb = '',
        $cEmbar = '',
        $nViagem = '',
        $cPrtEmb = '',
        $cPrtDest = ''
    ) {
        $aqua = $this->dom->createElement("Aqua");
        $this->dom->addChild(
            $aqua,
            "CNPJAgeNav",
            $cnpjAgeNav,
            true,
            "CNPJ da Agência de Navegação"
        );
        $this->dom->addChild(
            $aqua,
            "tpEmb",
            $tpEmb,
            true,
            "Código do tipo de embarcação"
        );
        $this->dom->addChild(
            $aqua,
            "cEmbar",
            $cEmbar,
            true,
            "Código da Embarcação"
        );
        $this->dom->addChild(
            $aqua,
            "nViagem",
            $nViagem,
            true,
            "Número da Viagem"
        );
        $this->dom->addChild(
            $aqua,
            "cPrtEmb",
            $cPrtEmb,
            true,
            "Código do Porto de Embarque"
        );
        $this->dom->addChild(
            $aqua,
            "cPrtDest",
            $cPrtDest,
            true,
            "Código do Porto de Destino"
        );
        $this->aqua = $aqua;
        return $aqua;
    }

    /**
     * tagInfTermCarreg
     * tag MDFe/infMDFe/infModal/Aqua/infTermCarreg
     *
     * @param  string $cTermCarreg
     *
     * @return DOMElement
     */
    public function tagInfTermCarreg(
        $cTermCarreg = ''
    ) {
        $infTermCarreg = $this->dom->createElement("infTermCarreg");
        $this->dom->addChild(
            $infTermCarreg,
            "cTermCarreg",
            $cTermCarreg,
            true,
            "Código do Terminal de Carregamento"
        );
        $this->aInfTermCarreg[] = $infTermCarreg;
        return $infTermCarreg;
    }

    /**
     * tagInfTermDescarreg
     * tag MDFe/infMDFe/infModal/Aqua/infTermDescarreg
     *
     * @param  string $cTermDescarreg
     *
     * @return DOMElement
     */
    public function tagInfTermDescarreg(
        $cTermDescarreg = ''
    ) {
        $infTermDescarreg = $this->dom->createElement("infTermDescarreg");
        $this->dom->addChild(
            $infTermDescarreg,
            "cTermCarreg",
            $cTermDescarreg,
            true,
            "Código do Terminal de Descarregamento"
        );
        $this->aInfTermDescarreg[] = $infTermDescarreg;
        return $infTermDescarreg;
    }

    /**
     * tagInfEmbComb
     * tag MDFe/infMDFe/infModal/Aqua/infEmbComb
     *
     * @param  string $cEmbComb
     *
     * @return DOMElement
     */
    public function tagInfEmbComb(
        $cEmbComb = ''
    ) {
        $infEmbComb = $this->dom->createElement("infEmbComb");
        $this->dom->addChild(
            $infEmbComb,
            "cEmbComb",
            $cEmbComb,
            true,
            "Código da embarcação do comboio"
        );
        $this->aInfEmbComb[] = $infEmbComb;
        return $infEmbComb;
    }

    /**
     * tagRodo
     * tag MDFe/infMDFe/infModal/rodo
     *
     * @param  string $rntrc
     * @param  string $ciot
     *
     * @return DOMElement
     */
    public function tagRodo(
        $rntrc = '',
        $ciot = ''
    ) {
        $rodo = $this->dom->createElement("rodo");
        $this->dom->addChild(
            $rodo,
            "RNTRC",
            $rntrc,
            false,
            "Registro Nacional de Transportadores Rodoviários de Carga"
        );
        $this->dom->addChild(
            $rodo,
            "CIOT",
            $ciot,
            false,
            "Código Identificador da Operação de Transporte"
        );
        $this->rodo = $rodo;
        return $rodo;
    }

    /**
     * tagVeicTracao
     * tag MDFe/infMDFe/infModal/rodo/veicTracao
     *
     * @param  string $cInt
     * @param  string $placa
     * @param  string $tara
     * @param  string $capKG
     * @param  string $capM3
     * @param  string $tpRod
     * @param  string $tpCar
     * @param  string $UF
     * @param  string $propRNTRC
     * @param  string $propCPF
     * @param  string $propCNPJ
     * @param  string $propXNome
     * @param  string $propIE
     * @param  string $propUF
     * @param  string $propTpProp
     *
     * @return DOMElement
     */
    public function tagVeicTracao(
        $cInt = '',
        $placa = '',
        $tara = '',
        $capKG = '',
        $capM3 = '',
        $tpRod = '',
        $tpCar = '',
        $UF = '',
        $propRNTRC = '',
        $propCPF = '',
        $propCNPJ = '',
        $propXNome = '',
        $propIE = '',
        $propUF = '',
        $propTpProp = ''
    ) {
        $veicTracao = $this->zTagVeiculo(
            'veicTracao',
            $cInt,
            $placa,
            $tara,
            $this->aCondutor,
            $capKG,
            $capM3,
            $tpRod,
            $tpCar,
            $UF,
            $propRNTRC,
            $propCPF,
            $propCNPJ,
            $propXNome,
            $propIE,
            $propUF,
            $propTpProp
        );
        $this->veicTracao = $veicTracao;
        return $veicTracao;
    }

    /**
     * tagCondutor
     * tag MDFe/infMDFe/infModal/rodo/veicTracao/condutor
     *
     * @param  string $xNome
     * @param  string $cpf
     *
     * @return DOMElement
     */
    public function tagCondutor(
        $xNome = '',
        $cpf = ''
    ) {
        $condutor = $this->dom->createElement("condutor");
        $this->dom->addChild(
            $condutor,
            "xNome",
            $xNome,
            true,
            "Nome do condutor"
        );
        $this->dom->addChild(
            $condutor,
            "CPF",
            $cpf,
            true,
            "CPF do condutor"
        );
        $this->aCondutor[] = $condutor;
        return $condutor;
    }

    /**
     * tagInfContratante
     * tag MDFe/infMDFe/infModal/rodo/infContratante
     *
     * @param  string $xNome
     * @param  string $cpf
     *
     * @return DOMElement
     */
    public function tagInfContratante(
        $cpf = '',
        $cnpj = ''
    ) {
        $infContratante = $this->dom->createElement("infContratante");
        $this->dom->addChild(
            $infContratante,
            "CPF",
            $cpf,
            false,
            "Número do CPF do contratante do serviço"
        );
        $this->dom->addChild(
            $infContratante,
            "CNPJ",
            $cnpj,
            false,
            "Número do CNPJ do contratante do serviço"
        );
        $this->aInfContratante[] = $infContratante;
        return $infContratante;
    }

    /**
     * tagVeicReboque
     * tag MDFe/infMDFe/infModal/rodo/reboque
     *
     * @param string $cInt
     * @param string $placa
     * @param string $tara
     * @param string $capKG
     * @param string $capM3
     * @param string $propRNTRC
     * @param string $propCPF
     * @param string $propCNPJ
     * @param string $propXNome
     * @param string $propIE
     * @param string $propUF
     * @param string $propTpProp
     * @param string $tpCar
     * @param string $UF
     *
     * @return DOMElement
     */
    public function tagVeicReboque(
        $cInt = '',
        $placa = '',
        $tara = '',
        $capKG = '',
        $capM3 = '',
        $propRNTRC = '',
        $propCPF = '',
        $propCNPJ = '',
        $propXNome = '',
        $propIE = '',
        $propUF = '',
        $propTpProp = '',
        $tpCar = '',
        $UF = ''
    ) {
        $reboque = $this->zTagVeiculo(
            'veicReboque',
            $cInt,
            $placa,
            $tara,
            [],
            $capKG,
            $capM3,
            null,
            $tpCar,
            $UF,
            $propRNTRC,
            $propCPF,
            $propCNPJ,
            $propXNome,
            $propIE,
            $propUF,
            $propTpProp
        );

        $this->aReboque[] = $reboque;

        return $reboque;
    }

    /**
     * tagValePed
     * tag MDFe/infMDFe/infModal/rodo/valePed
     *
     * @param  string $cnpjForn
     * @param  string $cnpjPg
     * @param  string $nCompra
     *
     * @return DOMElement
     */
    public function tagValePed(
        $cnpjForn = '',
        $cnpjPg = '',
        $nCompra = ''
    ) {
        $disp = $this->dom->createElement($disp);
        $this->dom->addChild(
            $disp,
            "CNPJForn",
            $cnpjForn,
            true,
            "CNPJ da empresa fornecedora do Vale-Pedágio"
        );
        $this->dom->addChild(
            $disp,
            "CNPJPg",
            $cnpjPg,
            false,
            "CNPJ do responsável pelo pagamento do Vale-Pedágio"
        );
        $this->dom->addChild(
            $disp,
            "nCompra",
            $nCompra,
            true,
            "Número do comprovante de compra"
        );
        $this->aDisp[] = $disp;
        return $disp;
    }

    /**
     * zTagVeiculo
     *
     * @param string $tag
     * @param string $cInt
     * @param string $placa
     * @param string $tara
     * @param array  $condutores
     * @param string $capKG
     * @param string $capM3
     * @param string $tpRod
     * @param string $tpCar
     * @param string $UF
     * @param string $propRNTRC
     * @param string $propCPF
     * @param string $propCNPJ
     * @param string $propXNome
     * @param string $propIE
     * @param string $propUF
     * @param string $propTpProp
     *
     * @return DOMElement
     */
    protected function zTagVeiculo(
        $tag = '',
        $cInt = '',
        $placa = '',
        $tara = '',
        $condutores = array(),
        $capKG = '',
        $capM3 = '',
        $tpRod = '',
        $tpCar = '',
        $UF = '',
        $propRNTRC = '',
        $propCPF = '',
        $propCNPJ = '',
        $propXNome = '',
        $propIE = '',
        $propUF = '',
        $propTpProp = ''
    ) {
        $node = $this->dom->createElement($tag);
        $this->dom->addChild(
            $node,
            "cInt",
            $cInt,
            false,
            "Código interno do veículo"
        );
        $this->dom->addChild(
            $node,
            "placa",
            $placa,
            true,
            "Placa do veículo"
        );
        $this->dom->addChild(
            $node,
            "tara",
            $tara,
            true,
            "Tara em KG"
        );
        $this->dom->addChild(
            $node,
            "capKG",
            $capKG,
            false,
            "Capacidade em KG"
        );
        $this->dom->addChild(
            $node,
            "capM3",
            $capM3,
            false,
            "Capacidade em M3"
        );

        $prop = $this->zTagPropVeiculo(
            'prop',
            $propCPF,
            $propCNPJ,
            $propRNTRC,
            $propXNome,
            $propIE,
            $propUF,
            $propTpProp
        );

        if ($prop) {
            $node->appendChild($prop);
        }

        if ($condutores) {
            $this->dom->addArrayChild(
                $node,
                $condutores
            );
        }
        $this->dom->addChild(
            $node,
            "tpRod",
            $tpRod,
            false,
            "Tipo de rodado"
        );
        $this->dom->addChild(
            $node,
            "tpCar",
            $tpCar,
            true,
            "Tipo de carroceria"
        );
        $this->dom->addChild(
            $node,
            "UF",
            $UF,
            true,
            "UF de licenciamento do veículo"
        );

        return $node;
    }

    /**
     * @param string $tag
     * @param string $CPF
     * @param string $CNPJ
     * @param string $RNTRC
     * @param string $xNome
     * @param string $IE
     * @param string $UF
     * @param string $tpProp
     *
     * @return DOMElement
     */
    protected function zTagPropVeiculo(
        $tag = '',
        $CPF = '',
        $CNPJ = '',
        $RNTRC = '',
        $xNome = '',
        $IE = '',
        $UF = '',
        $tpProp = ''
    ) {
        $args = func_get_args();
        unset($args[0]);

        if (!array_filter($args)) {
            return false;
        }

        $identificador = "<{$tag}> - ";
        $nodeProp = $this->dom->createElement($tag);

        $this->dom->addChild(
            $nodeProp,
            'CPF',
            $CPF,
            false,
            "{$identificador} Número do CPF do proprietário"
        );
        $this->dom->addChild(
            $nodeProp,
            'CNPJ',
            $CNPJ,
            false,
            "{$identificador} Número do CNPJ do proprietário"
        );
        $this->dom->addChild(
            $nodeProp,
            'RNTRC',
            $RNTRC,
            true,
            "{$identificador} Registro Nacional dos Transportadores Rodoviários de Carga do proprietário"
        );
        $this->dom->addChild(
            $nodeProp,
            'xNome',
            $xNome,
            true,
            "{$identificador} Razão Social ou Nome do proprietário do proprietário"
        );
        $this->dom->addChild(
            $nodeProp,
            'IE',
            $IE,
            true,
            "{$identificador} Inscrição Estadual do proprietário"
        );
        $this->dom->addChild(
            $nodeProp,
            'UF',
            $UF,
            true,
            "{$identificador} UF do proprietário"
        );
        $this->dom->addChild(
            $nodeProp,
            'tpProp',
            $tpProp,
            true,
            "{$identificador} Tipo do Proprietário"
        );

        return $nodeProp;
    }

    /**
     * zTagMDFe
     * Tag raiz da MDFe
     * tag MDFe DOMNode
     * Função chamada pelo método [ monta ]
     *
     * @return DOMElement
     */
    protected function zTagMDFe()
    {
        if (empty($this->MDFe)) {
            $this->MDFe = $this->dom->createElement("MDFe");
            $this->MDFe->setAttribute("xmlns", "http://www.portalfiscal.inf.br/mdfe");
        }
        return $this->MDFe;
    }

    /**
     * Adiciona as tags
     * infMunCarrega e infPercurso
     * a tag ide
     */
    protected function zTagIde()
    {
        $this->dom->addArrayChild($this->ide, $this->aInfMunCarrega);
        $this->dom->addArrayChild($this->ide, $this->aInfPercurso);
    }

    /**
     * Processa lacres
     */
    protected function zTagLacres()
    {
        $this->dom->addArrayChild($this->infMDFe, $this->aLacres);
    }

    /**
     * Proecessa documentos fiscais
     */
    protected function zTagInfDoc()
    {
        $this->aCountDoc = ['CTe'=>0, 'NFe'=>0, 'MDFe'=>0];
        if (! empty($this->aInfMunDescarga)) {
            $infDoc = $this->dom->createElement("infDoc");
            foreach ($this->aInfMunDescarga as $nItem => $node) {
                if (isset($this->aInfCTe[$nItem])) {
                    $this->aCountDoc['CTe'] = $this->dom->addArrayChild($node, $this->aInfCTe[$nItem]);
                }
                if (isset($this->aInfNFe[$nItem])) {
                    $this->aCountDoc['NFe'] = $this->dom->addArrayChild($node, $this->aInfNFe[$nItem]);
                }
                if (isset($this->aInfMDFe[$nItem])) {
                    $this->aCountDoc['MDFe'] = $this->dom->addArrayChild($node, $this->aInfMDFe[$nItem]);
                }
                $this->dom->appChild($infDoc, $node, '');
            }
            $this->dom->appChild($this->infMDFe, $infDoc, 'Falta tag "infMDFe"');
        }
        //ajusta quantidades em tot
        if ($this->aCountDoc['CTe'] > 0) {
            $this->tot->getElementsByTagName('qCTe')->item(0)->nodeValue = $this->aCountDoc['CTe'];
        }
        if ($this->aCountDoc['NFe'] > 0) {
            $this->tot->getElementsByTagName('qNFe')->item(0)->nodeValue = $this->aCountDoc['NFe'];
        }
        if ($this->aCountDoc['MDFe'] > 0) {
            $this->tot->getElementsByTagName('qMDFe')->item(0)->nodeValue = $this->aCountDoc['MDFe'];
        }
    }

    /**
     * Processa modal rodoviario
     */
    protected function zTagRodo()
    {
        if (! empty($this->rodo)) {
            $infANTT = $this->dom->createElement("infANTT");
            if (! empty($this->aDisp)) {
                $valePed = $this->dom->createElement("valePed");
                foreach ($this->aDisp as $node) {
                    $this->dom->appChild($valePed, $node, '');
                }
                $this->dom->appChild($infANTT, $valePed, '');
            }

            foreach ($this->aInfContratante as $cada_infContratante) {
                $this->dom->appChild($infANTT, $cada_infContratante, 'Falta tag "rodo"');
            }

            $this->dom->appChild($this->rodo, $infANTT, 'Falta tag "rodo"');

            $this->dom->appChild($this->rodo, $this->veicTracao, 'Falta tag "rodo"');
            $this->dom->addArrayChild($this->rodo, $this->aReboque);
            $this->dom->appChild($this->infModal, $this->rodo, 'Falta tag "infModal"');
        }
    }

    /**
     * Proecessa modal ferroviario
     */
    protected function zTagFerrov()
    {
        if (! empty($this->trem)) {
            $this->dom->addArrayChild($this->trem, $this->aVag);
            $ferrov = $this->dom->createElement("ferrov");
            $this->dom->appChild($ferrov, $this->trem, '');
            $this->dom->appChild($this->infModal, $ferrov, 'Falta tag "infModal"');
        }
    }

    /**
     * Processa modal aereo
     */
    protected function zTagAereo()
    {
        if (! empty($this->aereo)) {
            $this->dom->appChild($this->infModal, $this->aereo, 'Falta tag "infModal"');
        }
    }

    /**
     * Processa modal aquaviário
     */
    protected function zTagAqua()
    {
        if (! empty($this->aqua)) {
            $this->dom->addArrayChild($this->aqua, $this->aInfTermCarreg);
            $this->dom->addArrayChild($this->aqua, $this->aInfTermDescarreg);
            $this->dom->addArrayChild($this->aqua, $this->aInfEmbComb);
            $this->dom->appChild($this->infModal, $this->aqua, 'Falta tag "infModal"');
        }
    }

    /**
     * zTestaChaveXML
     * Remonta a chave da NFe de 44 digitos com base em seus dados
     * Isso é útil no caso da chave informada estar errada
     * se a chave estiver errada a mesma é substituida
     *
     * @param object $dom
     */
    private function zTestaChaveXML($dom)
    {
        $infMDFe = $dom->getElementsByTagName("infMDFe")->item(0);
        $ide = $dom->getElementsByTagName("ide")->item(0);
        $emit = $dom->getElementsByTagName("emit")->item(0);
        $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
        $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $cnpj = $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        $mod = $ide->getElementsByTagName('mod')->item(0)->nodeValue;
        $serie = $ide->getElementsByTagName('serie')->item(0)->nodeValue;
        $nNF = $ide->getElementsByTagName('nMDF')->item(0)->nodeValue;
        $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $cNF = $ide->getElementsByTagName('cMDF')->item(0)->nodeValue;
        $chave = str_replace('MDFe', '', $infMDFe->getAttribute("Id"));
        $tempData = explode("-", $dhEmi);
        $chaveMontada = $this->montaChave(
            $cUF,
            $tempData[0] - 2000,
            $tempData[1],
            $cnpj,
            $mod,
            $serie,
            $nNF,
            $tpEmis,
            $cNF
        );
        //caso a chave contida na NFe esteja errada
        //substituir a chave
        if ($chaveMontada != $chave) {
            $ide->getElementsByTagName('cDV')->item(0)->nodeValue = substr($chaveMontada, -1);
            $infMDFe = $dom->getElementsByTagName("infMDFe")->item(0);
            $infMDFe->setAttribute("Id", "MDFe" . $chaveMontada);
            $this->chMDFe = $chaveMontada;
        }
    }
}
