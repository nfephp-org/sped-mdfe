<?php

namespace NFePHP\MDFe;

/**
 * Classe a construção do xml do Manifesto Eletrônico de Documentos Fiscais (MDF-e)
 * NOTA: Esta classe foi construida conforme estabelecido no
 * Manual de Orientação do Contribuinte
 * Padrões Técnicos de Comunicação do Manifesto Eletrônico de Documentos Fiscais
 * versão 3.00a
 *
 * @category  Library
 * @package   nfephp-org/sped-mdfe
 * @name      Make.php
 * @copyright 2009-2019 NFePHP
 * @license   http://www.gnu.org/licenses/lesser.html LGPL v3
 * @link      http://github.com/nfephp-org/sped-mdfe for the canonical source repository
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 */

use NFePHP\Common\Keys;
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Strings;
use stdClass;
use RuntimeException;
use InvalidArgumentException;
use DOMElement;
use DateTime;

class Make
{
    /**
     * @var array
     */
    public $errors = [];
    /**
     * versao
     * numero da versão do xml da MDFe
     *
     * @var string
     */
    public $versao = '3.00';
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
    private $seg = '';
    /**
     * @type string|\DOMNode
     */
    private $aLacres = [];
    /**
     * @type string|\DOMNode
     */
    private $autXML = [];
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
    private $infDoc = '';
    /**
     * @type string|\DOMNode
     */
    private $infUnidTransp = '';
    /**
     * @type array|\DOMNode
     */
    private $aInfMunDescarga = [];
    /**
     * @type array|\DOMNode
     */
    private $aInfMunCarrega = [];
    /**
     * @type array|\DOMNode
     */
    private $aInfPercurso = [];
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

    /**
     * @var boolean
     */
    protected $replaceAccentedChars = false;

    /**
     * Função construtora cria um objeto DOMDocument
     * que será carregado com o documento fiscal
     */
    public function __construct()
    {
        $this->dom = new Dom('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = false;
    }

    /**
     * Retorns the xml
     *
     * @return xml
     */
    public function getXML()
    {
        if (empty($this->xml)) {
            $this->montaMDFe();
        }
        return $this->xml;
    }

    /**
     * Retorns the key number of NFe (44 digits)
     *
     * @return string
     */
    public function getChave()
    {
        return $this->chMDFe;
    }

    /**
     * Returns the model of MDFe
     *
     * @return int
     */
    public function getModelo()
    {
        return $this->mod;
    }

    /**
     * Call method of xml assembly. For compatibility only.
     *
     * @return boolean
     */
    public function montaMDFe()
    {
        return $this->monta();
    }

    /**
     * MDFe xml mount method
     * this function returns TRUE on success or FALSE on error
     * The xml of the MDFe must be retrieved by the getXML() function or
     * directly by the public property $xml
     *
     * @return boolean
     */
    public function monta()
    {
        $this->errors = $this->dom->errors;
        if (count($this->errors) > 0) {
            return false;
        }
        //cria a tag raiz da MDFe
        $this->buildMDFe();
        $this->buildInfModal();
        
        $this->infMDFe = $this->dom->createElement("infMDFe");

        $this->dom->appChild($this->infMDFe, $this->ide, 'Falta tag "infMDFe"');
        $this->dom->appChild($this->emit, $this->enderEmit, 'Falta tag "emit"');
        $this->dom->appChild($this->infMDFe, $this->emit, 'Falta tag "infMDFe"');
        if (! empty($this->rodo)) {
            $this->dom->appChild($this->infModal, $this->rodo, 'Falta tag "infModal"');
        }
        $this->dom->appChild($this->infMDFe, $this->infModal, 'Falta tag "infMDFe"');
        $this->dom->appChild($this->infMDFe, $this->infDoc, 'Falta tag "infMDFe"');
        if (! empty($this->seg)) {
            $this->dom->appChild($this->infMDFe, $this->seg, 'Falta tag "infMDFe"');
        }
        $this->dom->appChild($this->infMDFe, $this->tot, 'Falta tag "infMDFe"');
        foreach ($this->aLacres as $lacre) {
            $this->dom->appChild($this->infMDFe, $lacre, 'Falta tag "infMDFe"');
        }
        foreach ($this->autXML as $autXML) {
            $this->dom->appChild($this->infMDFe, $autXML, 'Falta tag "infMDFe"');
        }
        if (! empty($this->infAdic)) {
            $this->dom->appChild($this->infMDFe, $this->infAdic, 'Falta tag "infMDFe"');
        }
        $this->dom->appChild($this->MDFe, $this->infMDFe, 'Falta tag "MDFe"');
        
        $this->dom->appendChild($this->MDFe);
        // testa da chave
        $this->checkMDFKey($this->dom);
        $this->xml = $this->dom->saveXML();
        
        return true;
    }

    /**
     * Informações de identificação da MDFe
     * tag MDFe/infMDFe/ide
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagide(stdClass $std)
    {

        $possible = [
            'cUF',
            'tpAmb',
            'tpEmit',
            'tpTransp',
            'mod',
            'serie',
            'nMDF',
            'cMDF',
            'cDV',
            'modal',
            'dhEmi',
            'tpEmis',
            'procEmi',
            'verProc',
            'ufIni',
            'ufFim'
        ];

        $std = $this->equilizeParameters($std, $possible);
        
        $this->tpAmb = $std->tpAmb;
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
            false,
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
            $std->UFIni,
            true,
            $identificador . "Sigla da UF do Carregamento"
        );
        $this->dom->addChild(
            $ide,
            "UFFim",
            $std->UFFim,
            true,
            $identificador . "Sigla da UF do Descarregamento"
        );
        
        $this->mod = $std->mod;
        $this->ide = $ide;
        $this->buildTagIde();
        return $ide;
    }

    /**
     * taginfMunCarrega
     *
     * tag MDFe/infMDFe/ide/infMunCarrega
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfMunCarrega(stdClass $std)
    {
        $possible = [
            'cMunCarrega',
            'xMunCarrega'
        ];

        $std = $this->equilizeParameters($std, $possible);
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
    public function taginfPercurso(stdClass $std)
    {
        $possible = [
            'UFPer'
        ];

        $std = $this->equilizeParameters($std, $possible);
        foreach ($std->UFPer as $UFPer) {
            $infPercurso = $this->dom->createElement("infPercurso");
            $this->dom->addChild(
                $infPercurso,
                "UFPer",
                $UFPer,
                true,
                "Sigla das Unidades da Federação do percurso"
            );
            $this->aInfPercurso[] = $infPercurso;
        }
        return $this->aInfPercurso;
    }

    /**
     * tagemit
     * Identificação do emitente da MDFe
     * tag MDFe/infMDFe/emit
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagemit(stdClass $std)
    {
        $possible = [
            'CNPJ',
            'CPF',
            'IE',
            'xNome',
            'xFant'
        ];
        $std = $this->equilizeParameters($std, $possible);
        
        $identificador = '[25] <emit> - ';
        $this->emit = $this->dom->createElement("emit");
        $this->dom->addChild(
            $this->emit,
            "CNPJ",
            $std->CNPJ,
            false,
            $identificador . "CNPJ do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "CPF",
            $std->CPF,
            false,
            $identificador . "CPF do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "IE",
            $std->IE,
            false,
            $identificador . "Inscrição Estadual do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "xNome",
            $std->xNome,
            true,
            $identificador . "Razão Social ou Nome do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "xFant",
            $std->xFant,
            false,
            $identificador . "Nome fantasia do emitente"
        );
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
    public function tagenderEmit(stdClass $std)
    {
        $possible = [
            'xLgr',
            'nro',
            'xCpl',
            'xBairro',
            'cMun',
            'xMun',
            'CEP',
            'UF',
            'fone',
            'email'
        ];
        $std = $this->equilizeParameters($std, $possible);

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
            $std->CEP,
            true,
            $identificador . "Código do CEP do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "UF",
            $std->UF,
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
    public function taginfMunDescarga(stdClass $std)
    {
        $possible = [
            'cMunDescarga',
            'xMunDescarga'
        ];
        $std = $this->equilizeParameters($std, $possible);

        if (empty($this->infDoc)) {
            $infDoc = $this->dom->createElement("infDoc");
        } else {
            $infDoc = $this->infDoc;
        }
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
        $this->dom->appChild($infDoc, $infMunDescarga, 'Falta tag "infDoc"');
        $this->infDoc = $infDoc;
        $this->aInfMunDescarga = $infMunDescarga;
        return $infMunDescarga;
    }

    /**
     * taginfANTT
     * tag MDFe/infMDFe/rodo/taginfANTT
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfANTT(stdClass $std)
    {
        $possible = [
            'RNTRC',
            'infCIOT',
            'valePed',
            'infContratante'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $rodo = $this->dom->createElement("rodo");
        $infANTT = $this->dom->createElement("infANTT");
        $this->dom->addChild(
            $infANTT,
            "RNTRC",
            $std->RNTRC,
            false,
            "RNTRC"
        );

        if ($std->infCIOT != null) {
            $possible = [
                'CIOT',
                'CPF',
                'CNPJ'
            ];
            foreach ($std->infCIOT as $infCIOT) {
                $stdinfCIOT = $this->equilizeParameters($infCIOT, $possible);
                $infCIOT = $this->dom->createElement("infCIOT");
                $this->dom->addChild(
                    $infCIOT,
                    "CIOT",
                    $stdinfCIOT->CIOT,
                    true,
                    "CIOT"
                );
                
                $this->dom->addChild(
                    $infCIOT,
                    "CPF",
                    $stdinfCIOT->CPF,
                    false,
                    "CPF"
                );
                $this->dom->addChild(
                    $infCIOT,
                    "CNPJ",
                    $stdinfCIOT->CNPJ,
                    false,
                    "CNPJ"
                );
                $this->dom->appChild($infANTT, $infCIOT, 'Falta tag "$infANTT"');
            }
        }
        if ($std->valePed != null) {
            $possible = [
                'CNPJForn',
                'CNPJPg',
                'CPFPg',
                'nCompra',
                'vValePed'
            ];
            foreach ($std->valePed as $valePed) {
                $stdvalePed = $this->equilizeParameters($valePed, $possible);
                $valePed = $this->dom->createElement("valePed");
                $disp = $this->dom->createElement("disp");
                $this->dom->addChild(
                    $disp,
                    "CNPJForn",
                    $stdvalePed->CNPJForn,
                    false,
                    "CNPJForn"
                );
                $this->dom->addChild(
                    $disp,
                    "CNPJPg",
                    $stdvalePed->CNPJPg,
                    false,
                    "CNPJPg"
                );
                $this->dom->addChild(
                    $disp,
                    "CPFPg",
                    $stdvalePed->CPFPg,
                    false,
                    "CPFPg"
                );
                $this->dom->addChild(
                    $disp,
                    "nCompra",
                    $stdvalePed->nCompra,
                    false,
                    "nCompra"
                );
                $this->dom->addChild(
                    $disp,
                    "vValePed",
                    $stdvalePed->vValePed,
                    false,
                    "vValePed"
                );
                $this->dom->appChild($valePed, $disp, 'Falta tag "valePed"');
                $this->dom->appChild($infANTT, $valePed, 'Falta tag "infANTT"');
            }
        }
        if ($std->infContratante != null) {
            $possible = [
                'CPF',
                'CNPJ'
            ];
            foreach ($std->infContratante as $infContratante) {
                $stdinfContratante = $this->equilizeParameters($infContratante, $possible);
                $infContratante = $this->dom->createElement("infContratante");
                $this->dom->addChild(
                    $infContratante,
                    "CPF",
                    $stdinfContratante->CPF,
                    false,
                    "CPF"
                );
                $this->dom->addChild(
                    $infContratante,
                    "CNPJ",
                    $stdinfContratante->CNPJ,
                    false,
                    "CNPJ"
                );
                $this->dom->appChild($infANTT, $infContratante, 'Falta tag "infANTT"');
            }
        }
        
        $this->dom->appChild($rodo, $infANTT, 'Falta tag "rodo"');
        $this->rodo = $rodo;
        return $this->rodo;
    }
    
    /**
     * taginfCTe
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infCTe
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfCTe(stdClass $std)
    {
        $possible = [
            'chCTe',
            'SegCodBarra',
            'indReentrega',
            'infUnidTransp',
            'peri',
            'infEntregaParcial'
        ];
        $std = $this->equilizeParameters($std, $possible);
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
            $std->SegCodBarra,
            false,
            "Segundo código de barras do CTe"
        );
        $this->dom->addChild(
            $infCTe,
            "indReentrega",
            $std->indReentrega,
            false,
            "Indicador de Reentrega"
        );
        if ($std->infUnidTransp != null) {
            $infUnidTransp = $this->taginfUnidTransp($std->infUnidTransp);
            $this->dom->appChild($infCTe, $infUnidTransp, 'Falta tag "infCTe"');
        }
        if ($std->peri != null) {
            $peri = $this->tagperi($std->peri);
            $this->dom->appChild($infCTe, $peri, 'Falta tag "infCTe"');
        }
        if ($std->infEntregaParcial != null) {
            $possible = [
                'qtdTotal',
                'qtdParcial'
            ];
            $stdinfEntregaParcial = $this->equilizeParameters($std->infEntregaParcial, $possible);
            $infEntregaParcial = $this->dom->createElement("infEntregaParcial");
            $this->dom->addChild(
                $infEntregaParcial,
                "qtdTotal",
                $stdinfEntregaParcial->qtdTotal,
                true,
                "Quantidade total de volumes"
            );
            $this->dom->addChild(
                $infEntregaParcial,
                "qtdParcial",
                $stdinfEntregaParcial->qtdParcial,
                true,
                "Quantidade de volumes enviados no MDF-e"
            );
            $this->dom->appChild($infCTe, $infEntregaParcial, 'Falta tag "infCTe"');
        }
        $this->dom->appChild($this->aInfMunDescarga, $infCTe, 'Falta tag "infMunDescarga"');
        return $infCTe;
    }

    /**
     * tagperi
     * tag MDFe/infMDFe/infDoc/infMunDescarga/(infCTe/infNFe)/peri
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagperi(stdClass $std)
    {
        $possible = [
            'nONU',
            'xNomeAE',
            'xClaRisco',
            'grEmb',
            'qTotProd',
            'qVolTipo'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $peri = $this->dom->createElement("peri");
        $this->dom->addChild(
            $peri,
            "nONU",
            $std->nONU,
            true,
            "Número ONU/UN"
        );
        $this->dom->addChild(
            $peri,
            "xNomeAE",
            $std->xNomeAE,
            true,
            "Nome apropriado para embarque do produto"
        );
        $this->dom->addChild(
            $peri,
            "xClaRisco",
            $std->xClaRisco,
            true,
            "Classe ou subclasse/divisão, e risco subsidiário/risco secundário"
        );
        $this->dom->addChild(
            $peri,
            "grEmb",
            $std->grEmb,
            true,
            "Grupo de Embalagem"
        );
        $this->dom->addChild(
            $peri,
            "qTotProd",
            $std->qTotProd,
            true,
            "Quantidade total por produto"
        );
        $this->dom->addChild(
            $peri,
            "qVolTipo",
            $std->qVolTipo,
            true,
            "Quantidade e Tipo de volumes"
        );
        return $peri;
    }
    
    /**
     * taginfNFe
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infNFe
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfNFe(stdClass $std)
    {
        $possible = [
            'chNFe',
            'SegCodBarra',
            'indReentrega',
            'infUnidTransp',
            'peri'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $infNFe = $this->dom->createElement("infNFe");
        $this->dom->addChild(
            $infNFe,
            "chNFe",
            $std->chNFe,
            true,
            "Chave de Acesso NFe"
        );
        $this->dom->addChild(
            $infNFe,
            "SegCodBarra",
            $std->SegCodBarra,
            false,
            "Segundo código de barras do NFe"
        );
        $this->dom->addChild(
            $infNFe,
            "indReentrega",
            $std->indReentrega,
            false,
            "Indicador de Reentrega"
        );
        if ($std->infUnidTransp != null) {
            $infUnidTransp = $this->taginfUnidTransp($std->infUnidTransp);
            $this->dom->appChild($infNFe, $infUnidTransp, 'Falta tag "infNFe"');
        }
        if ($std->peri != null) {
            $peri = $this->tagperi($std->peri);
            $this->dom->appChild($infNFe, $peri, 'Falta tag "infNFe"');
        }
        $this->dom->appChild($this->aInfMunDescarga, $infNFe, 'Falta tag "infMunDescarga"');
        return $infNFe;
    }

    /**
     * taginfMDFeTransp
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infMDFeTransp
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfMDFeTransp(stdClass $std)
    {
        $possible = [
            'chNFe',
            'indReentrega',
            'infUnidTransp',
            'peri'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $infMDFeTransp = $this->dom->createElement("infMDFeTransp");
        $this->dom->addChild(
            $infMDFeTransp,
            "chNFe",
            $std->chNFe,
            true,
            "Chave de Acesso NFe"
        );
        $this->dom->addChild(
            $infMDFeTransp,
            "indReentrega",
            $std->indReentrega,
            false,
            "Indicador de Reentrega"
        );
        if ($std->infUnidTransp != null) {
            $infUnidTransp = $this->taginfUnidTransp($std->infUnidTransp);
            $this->dom->appChild($infMDFeTransp, $infUnidTransp, 'Falta tag "infMDFeTransp"');
        }
        if ($std->peri != null) {
            $peri = $this->tagperi($std->peri);
            $this->dom->appChild($infMDFeTransp, $peri, 'Falta tag "infMDFeTransp"');
        }
        $this->dom->appChild($this->aInfMunDescarga, $infMDFeTransp, 'Falta tag "infMunDescarga"');
        return $infMDFeTransp;
    }

    /**
     * taginfUnidTransp
     * tag MDFe/infMDFe/infDoc/infMunDescarga/(infCTe/infNFe)/infUnidTransp
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfUnidTransp(stdClass $std)
    {
        $possible = [
            'tpUnidTransp',
            'idUnidTransp',
            'qtdRat',
            'lacUnidTransp',
            'infUnidCarga'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $infUnidTransp = $this->dom->createElement("infUnidTransp");
        $this->dom->addChild(
            $infUnidTransp,
            "tpUnidTransp",
            $std->tpUnidTransp,
            true,
            "Tipo da Unidade de Transporte"
        );
        $this->dom->addChild(
            $infUnidTransp,
            "idUnidTransp",
            $std->idUnidTransp,
            false,
            "Identificação da Unidade de Transporte"
        );
        if ($std->lacUnidTransp != null) {
            $possible = [
                'nLacre'
            ];
            $stdlacUnidTransp = $this->equilizeParameters($std->lacUnidTransp, $possible);
            foreach ($stdlacUnidTransp->nLacre as $nLacre) {
                $lacUnidTransp = $this->dom->createElement("lacUnidTransp");
                $this->dom->addChild(
                    $lacUnidTransp,
                    "nLacre",
                    $nLacre,
                    true,
                    "Número do lacre"
                );
                $this->dom->appChild($infUnidTransp, $lacUnidTransp, 'Falta tag "infUnidTransp"');
            }
        }
        if ($std->infUnidCarga != null) {
            $infUnidCarga = $this->taginfUnidCarga($std->infUnidCarga);
            $this->dom->appChild($infUnidTransp, $infUnidCarga, 'Falta tag "infUnidTransp"');
        }
        $this->dom->addChild(
            $infUnidTransp,
            "qtdRat",
            $std->qtdRat,
            false,
            "Quantidade rateada (Peso,Volume) "
        );
        return $infUnidTransp;
    }

    /**
     * taginfUnidCarga
     * tag MDFe/infMDFe/infDoc/infMunDescarga/(infCTe/infNFe)/infUnidCarga
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfUnidCarga(stdClass $std)
    {
        $possible = [
            'tpUnidCarga',
            'idUnidCarga',
            'lacUnidCarga',
            'qtdRat'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $infUnidCarga = $this->dom->createElement("infUnidCarga");
        $this->dom->addChild(
            $infUnidCarga,
            "tpUnidCarga",
            $std->tpUnidCarga,
            false,
            "Tipo da Unidade de Carga"
        );
        $this->dom->addChild(
            $infUnidCarga,
            "idUnidCarga",
            $std->idUnidCarga,
            false,
            "Identificação da Unidade de Carga "
        );
        if ($std->lacUnidCarga != null) {
            $possible = [
                'nLacre'
            ];
            $stdlacUnidCarga = $this->equilizeParameters($std->lacUnidCarga, $possible);
            foreach ($stdlacUnidCarga->nLacre as $nLacre) {
                $lacUnidCarga = $this->dom->createElement("lacUnidCarga");
                $this->dom->addChild(
                    $lacUnidCarga,
                    "nLacre",
                    $nLacre,
                    true,
                    "Número do lacre"
                );
                $this->dom->appChild($infUnidCarga, $lacUnidCarga, 'Falta tag "infUnidCarga"');
            }
        }
        $this->dom->addChild(
            $infUnidCarga,
            "qtdRat",
            $std->qtdRat,
            false,
            "Quantidade rateada (Peso,Volume) "
        );
        
        return $infUnidCarga ;
    }
    
    /**
     * tagseg
     * tag MDFe/infMDFe/seg
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagseg(stdClass $std)
    {
        $possible = [
            'respSeg',
            'CNPJ',
            'CPF',
            'infSeg',
            'nApol',
            'nAver'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $seg = $this->dom->createElement("seg");
        $infResp = $this->dom->createElement("infResp");
        $this->dom->addChild(
            $infResp,
            "respSeg",
            $std->respSeg,
            true,
            "Responsável pelo seguro"
        );
        $this->dom->addChild(
            $infResp,
            "CNPJ",
            $std->CNPJ,
            false,
            "Número do CNPJ do responsável pelo seguro"
        );
        $this->dom->addChild(
            $infResp,
            "CPF",
            $std->CPF,
            false,
            "Número do CPF do responsável pelo seguro"
        );
        $this->dom->appChild($seg, $infResp, 'Falta tag "seg"');
        if ($std->infSeg != null) {
            $possible = [
                'xSeg',
                'CNPJ'
            ];
            $stdinfSeg = $this->equilizeParameters($std->infSeg, $possible);
            $infSeg = $this->dom->createElement("infSeg");
            $this->dom->addChild(
                $infSeg,
                "xSeg",
                $stdinfSeg->xSeg,
                true,
                "Nome da Seguradora"
            );
            $this->dom->addChild(
                $infSeg,
                "CNPJ",
                $stdinfSeg->CNPJ,
                false,
                "Número do CNPJ da seguradora"
            );
            $this->dom->appChild($seg, $infSeg, 'Falta tag "seg"');
        }
        $this->dom->addChild(
            $seg,
            "nApol",
            $std->nApol,
            false,
            "Número da Apólice"
        );
        if ($std->nAver != null) {
            foreach ($std->nAver as $nAver) {
                $this->dom->addChild(
                    $seg,
                    "nAver",
                    $nAver,
                    true,
                    "Número da Averbação"
                );
            }
        }
        $this->seg = $seg;
        return $seg;
    }

    /**
     * tagTot
     * tag MDFe/infMDFe/tot
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagtot(stdClass $std)
    {
        $possible = [
            'qCTe',
            'qNFe',
            'qMDFe',
            'vCarga',
            'cUnid',
            'qCarga'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $tot = $this->dom->createElement("tot");
        $this->dom->addChild(
            $tot,
            "qCTe",
            $std->qCTe,
            false,
            "Quantidade total de CT-e relacionados no Manifesto"
        );
        $this->dom->addChild(
            $tot,
            "qNFe",
            $std->qNFe,
            false,
            "Quantidade total de NF-e relacionados no Manifesto"
        );
        $this->dom->addChild(
            $tot,
            "qMDFe",
            $std->qMDFe,
            false,
            "Quantidade total de MDF-e relacionados no Manifesto"
        );
        $this->dom->addChild(
            $tot,
            "vCarga",
            $std->vCarga,
            true,
            "Valor total da mercadoria/carga transportada"
        );
        $this->dom->addChild(
            $tot,
            "cUnid",
            $std->cUnid,
            true,
            "Código da unidade de medida do Peso Bruto da Carga / Mercadoria Transportada"
        );
        $this->dom->addChild(
            $tot,
            "qCarga",
            $std->qCarga,
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taglacres(stdClass $std)
    {
        $possible = [
            'nLacre'
        ];
        $std = $this->equilizeParameters($std, $possible);
        foreach ($std->nLacre as $nLacre) {
            $lacres = $this->dom->createElement("lacres");
            $this->dom->addChild(
                $lacres,
                "nLacre",
                $nLacre,
                false,
                "Número do lacre"
            );
            $this->aLacres[] = $lacres; //array de DOMNode
        }
        return $this->aLacres;
    }

    /**
     * taginfAdic
     * Grupo de Informações Adicionais Z01 pai A01
     * tag MDFe/infMDFe/infAdic (opcional)
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfAdic(stdClass $std)
    {
        $possible = [
            'infAdFisco',
            'infCpl'
        ];
        $std = $this->equilizeParameters($std, $possible);
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
     * tagautXML
     * tag MDFe/infMDFe/autXML
     *
     * Autorizados para download do XML do MDF-e
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagautXML(stdClass $std)
    {
        $possible = [
            'CNPJ',
            'CPF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $autXML = $this->dom->createElement("autXML");
        $this->dom->addChild(
            $autXML,
            "CNPJ",
            $std->CNPJ,
            false,
            "CNPJ do autorizado"
        );
        $this->dom->addChild(
            $autXML,
            "CPF",
            $std->CPF,
            false,
            "CPF do autorizado"
        );
        $this->autXML[] = $autXML;
        return $this->autXML;
    }

    /**
     * buildInfModal
     * tag MDFe/infMDFe/infModal
     *
     * @return DOMElement
     */
    public function buildInfModal()
    {
        $infModal = $this->dom->createElement("infModal");
        $infModal->setAttribute("versaoModal", $this->versao);
        $this->infModal = $infModal;
        return $infModal;
    }

    /**
     * tagAereo
     * tag MDFe/infMDFe/infModal/aereo
     *
     * @param string $nac
     * @param string $matr
     * @param string $nVoo
     * @param string $cAerEmb
     * @param string $cAerDes
     * @param string $dVoo
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
     * @param string $xPref
     * @param string $dhTrem
     * @param string $xOri
     * @param string $xDest
     * @param string $qVag
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
     * @param string $serie
     * @param string $nVag
     * @param string $nSeq
     * @param string $tonUtil
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
     * @param string $cnpjAgeNav
     * @param string $tpEmb
     * @param string $cEmbar
     * @param string $nViagem
     * @param string $cPrtEmb
     * @param string $cPrtDest
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
     * @param string $cTermCarreg
     *
     * @return DOMElement
     */
    public function taginfTermCarreg(
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
     * @param string cTermDescarreg
     *
     * @return DOMElement
     */
    public function taginfTermDescarreg(
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
     * @param string cEmbComb
     *
     * @return DOMElement
     */
    public function taginfEmbComb(
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
     * tagVeicTracao
     * tag MDFe/infMDFe/infModal/rodo/veicTracao
     *
     * @param  stdClass $std
     * @return DOMElement
     */

    public function tagveicTracao(stdClass $std)
    {
        $possible = [
            'cInt',
            'placa',
            'RENAVAM',
            'tara',
            'capKG',
            'capM3',
            'prop',
            'condutor',
            'tpRod',
            'tpCar',
            'UF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $veicTracao = $this->dom->createElement("veicTracao");
        $this->dom->addChild(
            $veicTracao,
            "cInt",
            $std->cInt,
            false,
            "Código interno do veículo"
        );
        $this->dom->addChild(
            $veicTracao,
            "placa",
            $std->placa,
            true,
            "Placa do veículo"
        );
        $this->dom->addChild(
            $veicTracao,
            "RENAVAM",
            $std->RENAVAM,
            false,
            "RENAVAM"
        );
        $this->dom->addChild(
            $veicTracao,
            "tara",
            $std->tara,
            true,
            "Tara em KG"
        );
        $this->dom->addChild(
            $veicTracao,
            "capKG",
            $std->capKG,
            false,
            "Capacidade em KG"
        );
        $this->dom->addChild(
            $veicTracao,
            "capM3",
            $std->capM3,
            false,
            "Capacidade em M3"
        );
        if ($std->prop != null) {
            $possible = [
                'CPF',
                'CNPJ',
                'RNTRC',
                'xNome',
                'IE',
                'UF',
                'tpProp'
            ];
            $stdprop = $this->equilizeParameters($std->prop, $possible);
            $prop = $this->dom->createElement("prop");
            $this->dom->addChild(
                $prop,
                "CPF",
                $stdprop->CPF,
                false,
                "Número do CPF"
            );
            $this->dom->addChild(
                $prop,
                "CNPJ",
                $stdprop->CNPJ,
                false,
                "Número do CNPJ"
            );
            $this->dom->addChild(
                $prop,
                "RNTRC",
                $stdprop->RNTRC,
                true,
                "RNTRC"
            );
            $this->dom->addChild(
                $prop,
                "xNome",
                $stdprop->xNome,
                true,
                "Razão Social"
            );
            $this->dom->addChild(
                $prop,
                "IE",
                $stdprop->IE,
                true,
                "Inscrição Estadual"
            );
            $this->dom->addChild(
                $prop,
                "UF",
                $stdprop->UF,
                true,
                "Unidade da Federação"
            );
            $this->dom->addChild(
                $prop,
                "tpProp",
                $stdprop->tpProp,
                true,
                "Tipo Proprietário"
            );
            $this->dom->appChild($veicTracao, $prop, 'Falta tag "veicTracao"');
        }
        
        if ($std->condutor != null) {
            $possible = [
                'xNome',
                'CPF'
            ];
            foreach ($std->condutor as $condutor) {
                $stdcondutor = $this->equilizeParameters($condutor, $possible);
                $tagcondutor = $this->dom->createElement("condutor");
                $this->dom->addChild(
                    $tagcondutor,
                    "xNome",
                    $stdcondutor->xNome,
                    true,
                    "Nome do Condutor "
                );
                $this->dom->addChild(
                    $tagcondutor,
                    "CPF",
                    $stdcondutor->CPF,
                    true,
                    "CPF do Condutor "
                );
                $this->dom->appChild($veicTracao, $tagcondutor, 'Falta tag "veicTracao"');
            }
        }
        $this->dom->addChild(
            $veicTracao,
            "tpRod",
            $std->tpRod,
            true,
            "Tipo de rodado"
        );
        $this->dom->addChild(
            $veicTracao,
            "tpCar",
            $std->tpCar,
            true,
            "Tipo de carroceria"
        );
        $this->dom->addChild(
            $veicTracao,
            "UF",
            $std->UF,
            true,
            "UF de licenciamento do veículo"
        );

        $this->dom->appChild($this->rodo, $veicTracao, 'Falta tag "rodo"');
        return $this->rodo;
    }

    /**
     * tagVeicReboque
     * tag MDFe/infMDFe/infModal/rodo/VeicReboque
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagveicReboque(stdClass $std)
    {
        $possible = [
            'cInt',
            'placa',
            'RENAVAM',
            'tara',
            'capKG',
            'capM3',
            'prop',
            'tpCar',
            'UF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $veicReboque = $this->dom->createElement("veicReboque");
        $this->dom->addChild(
            $veicReboque,
            "cInt",
            $std->cInt,
            false,
            "Código interno do veículo"
        );
        $this->dom->addChild(
            $veicReboque,
            "placa",
            $std->placa,
            true,
            "Placa do veículo"
        );
        $this->dom->addChild(
            $veicReboque,
            "RENAVAM",
            $std->RENAVAM,
            false,
            "RENAVAM"
        );
        $this->dom->addChild(
            $veicReboque,
            "tara",
            $std->tara,
            true,
            "Tara em KG"
        );
        $this->dom->addChild(
            $veicReboque,
            "capKG",
            $std->capKG,
            false,
            "Capacidade em KG"
        );
        $this->dom->addChild(
            $veicReboque,
            "capM3",
            $std->capM3,
            false,
            "Capacidade em M3"
        );
        if ($std->prop != null) {
            $possible = [
                'CPF',
                'CNPJ',
                'RNTRC',
                'xNome',
                'IE',
                'UF',
                'tpProp'
            ];
            $stdprop = $this->equilizeParameters($std->prop, $possible);
            $prop = $this->dom->createElement("prop");
            $this->dom->addChild(
                $prop,
                "CPF",
                $stdprop->CPF,
                false,
                "Número do CPF"
            );
            $this->dom->addChild(
                $prop,
                "CNPJ",
                $stdprop->CNPJ,
                false,
                "Número do CNPJ"
            );
            $this->dom->addChild(
                $prop,
                "RNTRC",
                $stdprop->RNTRC,
                true,
                "RNTRC"
            );
            $this->dom->addChild(
                $prop,
                "xNome",
                $stdprop->xNome,
                true,
                "Razão Social"
            );
            $this->dom->addChild(
                $prop,
                "IE",
                $stdprop->IE,
                true,
                "Inscrição Estadual"
            );
            $this->dom->addChild(
                $prop,
                "UF",
                $stdprop->UF,
                true,
                "Unidade da Federação"
            );
            $this->dom->addChild(
                $prop,
                "tpProp",
                $stdprop->tpProp,
                true,
                "Tipo Proprietário"
            );
            $this->dom->appChild($veicReboque, $prop, 'Falta tag "veicReboque"');
        }
        $this->dom->addChild(
            $veicReboque,
            "tpCar",
            $std->tpCar,
            true,
            "Tipo de carroceria"
        );
        $this->dom->addChild(
            $veicReboque,
            "UF",
            $std->UF,
            true,
            "UF de licenciamento do veículo"
        );

        $this->dom->appChild($this->rodo, $veicReboque, 'Falta tag "rodo"');
        return $this->rodo;
    }

    /**
     * tagcodAgPorto
     * tag MDFe/infMDFe/infModal/rodo/codAgPorto
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagcodAgPorto(stdClass $std)
    {
        $possible = [
            'codAgPorto'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->dom->addChild(
            $this->rodo,
            "codAgPorto",
            $std->codAgPorto,
            false,
            "Código de Agendamento no porto"
        );
        return $this->rodo;
    }

    /**
     * taglacRodo
     * tag MDFe/infMDFe/infModal/rodo/lacRodo
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taglacRodo(stdClass $std)
    {
        $possible = [
            'nLacre'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $lacRodo = $this->dom->createElement("lacRodo");
        $this->dom->addChild(
            $lacRodo,
            "nLacre",
            $std->nLacre,
            false,
            "Número do Lacre"
        );
        $this->dom->appChild($this->rodo, $lacRodo, 'Falta tag "rodo"');
        return $this->rodo;
    }

    /**
     * buildMDFe
     * Tag raiz da MDFe
     * tag MDFe DOMNode
     * Função chamada pelo método [ monta ]
     *
     * @return DOMElement
     */
    protected function buildMDFe()
    {
        if (empty($this->MDFe)) {
            $this->MDFe = $this->dom->createElement("MDFe");
            $this->MDFe->setAttribute("xmlns", "http://www.portalfiscal.inf.br/mdfe");
        }
        return $this->MDFe;
    }

    /**
     * buildTagIde
     * Adiciona as tags
     * infMunCarrega e infPercurso
     * a tag ide
     */
    
    protected function buildTagIde()
    {
        if (! empty($this->aInfMunCarrega)) {
            $this->dom->addArrayChild($this->ide, $this->aInfMunCarrega);
        }
        if (! empty($this->aInfPercurso)) {
            $this->dom->addArrayChild($this->ide, $this->aInfPercurso);
        }
    }
    
    /**
     * checkMDFKey
     * Remonta a chave do MDFe de 44 digitos com base em seus dados
     * Isso é útil no caso da chave informada estar errada
     * se a chave estiver errada a mesma é substituida
     *
     * @param object $dom
     */
    private function checkMDFKey($dom)
    {
        $infMDFe = $dom->getElementsByTagName("infMDFe")->item(0);
        $ide = $dom->getElementsByTagName("ide")->item(0);
        $emit = $dom->getElementsByTagName("emit")->item(0);
        $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
        $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        if (!empty($emit->getElementsByTagName('CNPJ')->item(0)->nodeValue)) {
            $doc = $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        } else {
            $doc = $emit->getElementsByTagName('CPF')->item(0)->nodeValue;
        }
        $mod = $ide->getElementsByTagName('mod')->item(0)->nodeValue;
        $serie = $ide->getElementsByTagName('serie')->item(0)->nodeValue;
        $nMDF = $ide->getElementsByTagName('nMDF')->item(0)->nodeValue;
        $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $cNF = $ide->getElementsByTagName('cMDF')->item(0)->nodeValue;
        $chave = str_replace('MDFe', '', $infMDFe->getAttribute("Id"));
        $dt = new DateTime($dhEmi);
        $chaveMontada = Keys::build(
            $cUF,
            $dt->format('y'),
            $dt->format('m'),
            $doc,
            $mod,
            $serie,
            $nMDF,
            $tpEmis,
            $cNF
        );
        //caso a chave contida na NFe esteja errada
        //substituir a chave
        if ($chaveMontada != $chave) {
            $ide->getElementsByTagName('cDV')->item(0)->nodeValue = substr($chaveMontada, -1);
            $infMDFe = $dom->getElementsByTagName("infMDFe")->item(0);
            $infMDFe->setAttribute("Id", "MDFe" . $chaveMontada);
            $infMDFe->setAttribute("versao", $this->versao);
            $this->chMDFe = $chaveMontada;
        }
    }

    /**
     * Includes missing or unsupported properties in stdClass
     * Replace all unsuported chars
     *
     * @param  stdClass $std
     * @param  array    $possible
     * @return stdClass
     */
    protected function equilizeParameters(stdClass $std, $possible)
    {
        $arr = get_object_vars($std);
        foreach ($possible as $key) {
            if (!array_key_exists($key, $arr)) {
                $std->$key = null;
            } else {
                if (is_string($std->$key)) {
                    $std->$key = trim(Strings::replaceUnacceptableCharacters($std->$key));
                    if ($this->replaceAccentedChars) {
                        $std->$key = Strings::toASCII($std->$key);
                    }
                }
            }
        }
        return $std;
    }
}
