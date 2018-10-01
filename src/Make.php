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
use stdClass;

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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfMDFe(\stdClass $std)
    {
        $this->infMDFe = $this->dom->createElement("infMDFe");
        $this->infMDFe->setAttribute("Id", 'MDFe'.$std->chave);
        $this->infMDFe->setAttribute("versao", $std->versao);
        $this->chMDFe = $std->chave;
        $this->versao = $std->versao;
        return $this->infMDFe;
    }

    /**
     * tgaide
     * Informações de identificação da MDFe 4 pai 1
     * tag MDFe/infMDFe/ide
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagide(\stdClass $std)
    {
        $this->tpAmb = $std->tpAmb;
        if ($std->dhEmi == '') {
            $std->dhEmi = DateTime::convertTimestampToSefazTime();
        }
        $identificador = '[4] <ide> - ';
        $ide = $this->dom->createElement("ide");
        $this->dom->addChild(
            $ide,
            "cUF",
            $std->cUF,
            true,
            $identificador . "Código da UF do emitente do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "tpAmb",
            $std->tpAmb,
            true,
            $identificador . "Identificação do Ambiente"
        );
        $this->dom->addChild(
            $ide,
            "tpEmit",
            $std->tpEmit,
            true,
            $identificador . "Indicador da tipo de emitente"
        );
        $this->dom->addChild(
            $ide,
            "tpTransp",
            $std->tpTransp,
            true,
            $identificador . "Tipo do Transportador"
        );
        $this->dom->addChild(
            $ide,
            "mod",
            $std->mod,
            true,
            $identificador . "Código do Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "serie",
            $std->serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "nMDF",
            $std->nMDF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "cMDF",
            $std->cMDF,
            true,
            $identificador . "Código do numérico do MDF"
        );
        $this->dom->addChild(
            $ide,
            "cDV",
            $std->cDV,
            true,
            $identificador . "Dígito Verificador da Chave de Acesso da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "modal",
            $std->modal,
            true,
            $identificador . "Modalidade de transporte"
        );
        $this->dom->addChild(
            $ide,
            "dhEmi",
            $std->dhEmi,
            true,
            $identificador . "Data e hora de emissão do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "tpEmis",
            $std->tpEmis,
            true,
            $identificador . "Tipo de Emissão do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "procEmi",
            $std->procEmi,
            true,
            $identificador . "Processo de emissão"
        );
        $this->dom->addChild(
            $ide,
            "verProc",
            $std->verProc,
            true,
            $identificador . "Versão do Processo de emissão"
        );
        $this->dom->addChild(
            $ide,
            "UFIni",
            $std->ufIni,
            true,
            $identificador . "Sigla da UF do Carregamento"
        );
        $this->dom->addChild(
            $ide,
            "UFFim",
            $std->ufFim,
            true,
            $identificador . "Sigla da UF do Descarregamento"
        );
        $this->dom->addChild(
            $ide,
            "dhIniViagem",
            $std->dhIniViagem,
            true,
            $identificador . "Data e hora previstos de inicio da viagem"
        );
        $this->mod = $std->mod;
        $this->ide = $ide;
        return $ide;
    }

    /**
     * tagInfMunCarrega
     *
     * tag MDFe/infMDFe/ide/infMunCarrega
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfMunCarrega(\stdClass $std)
    {
        $infMunCarrega = $this->dom->createElement("infMunCarrega");
        $this->dom->addChild(
            $infMunCarrega,
            "cMunCarrega",
            $std->cMunCarrega,
            true,
            "Código do Município de Carregamento"
        );
        $this->dom->addChild(
            $infMunCarrega,
            "xMunCarrega",
            $std->xMunCarrega,
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfPercurso(\stdClass $std)
    {
        $infPercurso = $this->dom->createElement("infPercurso");
        $this->dom->addChild(
            $infPercurso,
            "UFPer",
            $std->ufPer,
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagemit(\stdClass $std)
    {
        $identificador = '[25] <emit> - ';
        $this->emit = $this->dom->createElement("emit");
        $this->dom->addChild($this->emit, "CNPJ", $std->cnpj, true, $identificador . "CNPJ do emitente");
        $this->dom->addChild($this->emit, "IE", $std->numIE, true, $identificador . "Inscrição Estadual do emitente");
        $this->dom->addChild($this->emit, "xNome", $std->xNome, true, $identificador . "Razão Social ou Nome do emitente");
        $this->dom->addChild($this->emit, "xFant", $std->xFant, false, $identificador . "Nome fantasia do emitente");
        return $this->emit;
    }

    /**
     * tagenderEmit
     * Endereço do emitente [30] pai [25]
     * tag MDFe/infMDFe/emit/endEmit
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagenderEmit(\stdClass $std)
    {
        $identificador = '[30] <enderEmit> - ';
        $this->enderEmit = $this->dom->createElement("enderEmit");
        $this->dom->addChild(
            $this->enderEmit,
            "xLgr",
            $std->xLgr,
            true,
            $identificador . "Logradouro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "nro",
            $std->nro,
            true,
            $identificador . "Número do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xCpl",
            $std->xCpl,
            false,
            $identificador . "Complemento do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xBairro",
            $std->xBairro,
            true,
            $identificador . "Bairro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "cMun",
            $std->cMun,
            true,
            $identificador . "Código do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xMun",
            $std->xMun,
            true,
            $identificador . "Nome do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "CEP",
            $std->cep,
            true,
            $identificador . "Código do CEP do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "UF",
            $std->siglaUF,
            true,
            $identificador . "Sigla da UF do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "fone",
            $std->fone,
            false,
            $identificador . "Número de telefone do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "email",
            $std->email,
            false,
            $identificador . "Endereço de email do emitente"
        );
        return $this->enderEmit;
    }

    /**
     * tagInfMunDescarga
     * tag MDFe/infMDFe/infDoc/infMunDescarga
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfMunDescarga(\stdClass $std)
    {
        $infMunDescarga = $this->dom->createElement("infMunDescarga");
        $this->dom->addChild(
            $infMunDescarga,
            "cMunDescarga",
            $std->cMunDescarga,
            true,
            "Código do Município de Descarga"
        );
        $this->dom->addChild(
            $infMunDescarga,
            "xMunDescarga",
            $std->xMunDescarga,
            true,
            "Nome do Município de Descarga"
        );
        $this->aInfMunDescarga[$std->nItem] = $infMunDescarga;
        return $infMunDescarga;
    }

    /**
     * tagInfCTe
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infCTe
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfCTe(\stdClass $std)
    {
        $infCTe = $this->dom->createElement("infCTe");
        $this->dom->addChild(
            $infCTe,
            "chCTe",
            $std->chCTe,
            true,
            "Chave de Acesso CTe"
        );
        $this->dom->addChild(
            $infCTe,
            "SegCodBarra",
            $std->segCodBarra,
            false,
            "Segundo código de barras do CTe"
        );
        $this->dom->addChild(
            $infCTe,
            "indReentrega",
            $std->segCodBarra,
            false,
            "Indicador de Reentrega do CTe"
        );
        $this->aInfCTe[$std->nItem][] = $infCTe;
        return $infCTe;
    }

    /**
     * tagInfNFe
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infNFe
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfNFe(\stdClass $std)
    {
        $infNFe = $this->dom->createElement("infNFe");
        $this->dom->addChild(
            $infNFe,
            "chNFe",
            $std->chNFe,
            true,
            "Chave de Acesso da NFe"
        );
        $this->dom->addChild(
            $infNFe,
            "SegCodBarra",
            $std->segCodBarra,
            false,
            "Segundo código de barras da NFe"
        );
        $this->dom->addChild(
            $infNFe,
            "indReentrega",
            $std->indReentrega,
            false,
            "Indicador de Reentrega da NFe"
        );
        $this->aInfNFe[$std->nItem][] = $infNFe;
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfAdic(\stdClass $std)
    {
        $infAdic = $this->dom->createElement("infAdic");
        $this->dom->addChild(
            $infAdic,
            "infAdFisco",
            $std->infAdFisco,
            false,
            "Informações Adicionais de Interesse do Fisco"
        );
        $this->dom->addChild(
            $infAdic,
            "infCpl",
            $std->infCpl,
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagautXML(\stdClass $std)
    {
        $autXML = $this->dom->createElement("autXML");
        $this->dom->addChild(
            $autXML,
            "CNPJ",
            $std->cnpj,
            false,
            "CNPJ do autorizado"
        );
        $this->dom->addChild(
            $autXML,
            "CPF",
            $std->cpf,
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfModal(\stdClass $std)
    {
        $infModal = $this->dom->createElement("infModal");
        $infModal->setAttribute("versaoModal", $std->versaoModal);
        $this->infModal = $infModal;
        return $infModal;
    }

    /**
     * tagAereo
     * tag MDFe/infMDFe/infModal/aereo
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagAereo(\stdClass $std)
    {
        $aereo = $this->dom->createElement("aereo");
        $this->dom->addChild(
            $aereo,
            "nac",
            $std->nac,
            true,
            "Marca da Nacionalidade da aeronave"
        );
        $this->dom->addChild(
            $aereo,
            "matr",
            $std->matr,
            true,
            "Marca de Matrícula da aeronave"
        );
        $this->dom->addChild(
            $aereo,
            "nVoo",
            $std->nVoo,
            true,
            "Número do Vôo"
        );
        $this->dom->addChild(
            $aereo,
            "cAerEmb",
            $std->cAerEmb,
            true,
            "Aeródromo de Embarque - Código IATA"
        );
        $this->dom->addChild(
            $aereo,
            "cAerDes",
            $std->cAerDes,
            true,
            "Aeródromo de Destino - Código IATA"
        );
        $this->dom->addChild(
            $aereo,
            "dVoo",
            $std->dVoo,
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagTrem(\stdClass $std)
    {
        $trem = $this->dom->createElement("trem");
        $this->dom->addChild(
            $trem,
            "xPref",
            $std->xPref,
            true,
            "Prefixo do Trem"
        );
        $this->dom->addChild(
            $trem,
            "dhTrem",
            $std->dhTrem,
            false,
            "Data e hora de liberação do trem na origem"
        );
        $this->dom->addChild(
            $trem,
            "xOri",
            $std->xOri,
            true,
            "Origem do Trem"
        );
        $this->dom->addChild(
            $trem,
            "xDest",
            $std->xDest,
            true,
            "Destino do Trem"
        );
        $this->dom->addChild(
            $trem,
            "qVag",
            $std->qVag,
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagVag(\stdClass $std)
    {
        $vag = $this->dom->createElement("vag");
        $this->dom->addChild(
            $vag,
            "pesoBC",
            $std->pesoBC,
            true,
            "Peso Base de Cálculo de Frete em Toneladas"
        );
        $this->dom->addChild(
            $vag,
            "pesoR",
            $std->pesoR,
            true,
            "Peso Real em Toneladas"
        );
        $this->dom->addChild(
            $vag,
            "tpVag",
            $std->tpVag,
            true,
            "Tipo de Vagão"
        );
        $this->dom->addChild(
            $vag,
            "serie",
            $std->serie,
            true,
            "Série de Identificação do vagão"
        );
        $this->dom->addChild(
            $vag,
            "nVag",
            $std->nVag,
            true,
            "Número de Identificação do vagão"
        );
        $this->dom->addChild(
            $vag,
            "nSeq",
            $std->nSeq,
            false,
            "Sequência do vagão na composição"
        );
        $this->dom->addChild(
            $vag,
            "TU",
            $std->TU,
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagAquav(\stdClass $std)
    {
        $aquav = $this->dom->createElement("aquav");
        $this->dom->addChild(
            $aquav,
            "irin",
            $std->irin,
            true,
            "Irin do navio sempre deverá ser informado"
        );
        $this->dom->addChild(
            $aquav,
            "tpEmb",
            $std->tpEmb,
            true,
            "Código do tipo de embarcação"
        );
        $this->dom->addChild(
            $aquav,
            "cEmbar",
            $std->cEmbar,
            true,
            "Código da Embarcação"
        );
        $this->dom->addChild(
            $aquav,
            "xEmbar",
            $std->xEmbar,
            true,
            "Nome da embarcação"
        );
        $this->dom->addChild(
            $aquav,
            "nViag",
            $std->nViag,
            true,
            "Número da Viagem"
        );
        $this->dom->addChild(
            $aquav,
            "cPrtEmb",
            $std->cPrtEmb,
            true,
            "Código do Porto de Embarque"
        );
        $this->dom->addChild(
            $aquav,
            "cPrtDest",
            $std->cPrtDest,
            true,
            "Código do Porto de Destino"
        );
        $this->dom->addChild(
            $aquav,
            "prtTrans",
            $std->prtTrans,
            true,
            "Porto de Transbordo"
        );
        $this->dom->addChild(
            $aquav,
            "tpNav",
            $std->tpNav,
            true,
            "Tipo de Navegação"
        );
        $this->aqua = $aquav;
        return $aquav;
    }

    /**
     * tagInfTermCarreg
     * tag MDFe/infMDFe/infModal/Aqua/infTermCarreg
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfTermCarreg(\stdClass $std)
    {
        $infTermCarreg = $this->dom->createElement("infTermCarreg");
        $this->dom->addChild(
            $infTermCarreg,
            "cTermCarreg",
            $std->cTermCarreg,
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
    public function tagInfTermDescarreg(\stdClass $std)
    {
        $infTermDescarreg = $this->dom->createElement("infTermDescarreg");
        $this->dom->addChild(
            $infTermDescarreg,
            "cTermCarreg",
            $std->cTermCarreg,
            true,
            "Código do Terminal de Descarregamento"
        );
        $this->dom->addChild(
            $infTermDescarreg,
            "xTermCarreg",
            $std->xTermCarreg,
            true,
            "Nome do Terminal de Descarregamento"
        );
        $this->aInfTermDescarreg[] = $infTermDescarreg;
        return $infTermDescarreg;
    }

    /**
     * tagInfEmbComb
     * tag MDFe/infMDFe/infModal/Aqua/infEmbComb
     *
     * @param  string $cTermDescarreg
     *
     * @return DOMElement
     */
    public function tagInfEmbComb(\stdClass $std)
    {
        $infEmbComb = $this->dom->createElement("infEmbComb");
        $this->dom->addChild(
            $infEmbComb,
            "cEmbComb",
            $std->cEmbComb,
            true,
            "Código da embarcação do comboio"
        );
        $this->dom->addChild(
            $infEmbComb,
            "xBalsa",
            $std->xBalsa,
            true,
            "Identificador da Balsa"
        );
        $this->aInfEmbComb[] = $infEmbComb;
        return $infEmbComb;
    }

    /**
     * tagRodo
     * tag MDFe/infMDFe/infModal/rodo
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagRodo(\stdClass $std)
    {
        $rodo = $this->dom->createElement("rodo");
        $this->dom->addChild(
            $rodo,
            "RNTRC",
            $std->rntrc,
            false,
            "Registro Nacional de Transportadores Rodoviários de Carga"
        );
        $this->dom->addChild(
            $rodo,
            "CIOT",
            $std->ciot,
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
        $this->dom->addArrayChild(
            $node,
            $condutores
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
            $this->aCountDoc['CTe'] = 0;
            $this->aCountDoc['NFe'] = 0;
            $this->aCountDoc['MDFe'] = 0;
            foreach ($this->aInfMunDescarga as $nItem => $node) {
                if (isset($this->aInfCTe[$nItem])) {
                    $this->aCountDoc['CTe'] += $this->dom->addArrayChild($node, $this->aInfCTe[$nItem]);
                }
                if (isset($this->aInfNFe[$nItem])) {
                    $this->aCountDoc['NFe'] += $this->dom->addArrayChild($node, $this->aInfNFe[$nItem]);
                }
                if (isset($this->aInfMDFe[$nItem])) {
                    $this->aCountDoc['MDFe'] += $this->dom->addArrayChild($node, $this->aInfMDFe[$nItem]);
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
            $this->dom->appChild($this->rodo, $this->veicTracao, 'Falta tag "rodo"');
            $this->dom->addArrayChild($this->rodo, $this->aReboque);
            if (! empty($this->aDisp)) {
                $valePed = $this->dom->createElement("valePed");
                foreach ($this->aDisp as $node) {
                    $this->dom->appChild($valePed, $node, '');
                }
                $this->dom->appChild($this->rodo, $valePed, '');
            }
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
