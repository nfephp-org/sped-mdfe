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
 * @author    Cleiton Perin <cperin20 at gmail dot com>
 * @author    Vanderlei Cavassin <cavassin.vanderlei at gmail dot com>
 */

use DOMElement;
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Keys;
use NFePHP\Common\Strings;
use RuntimeException;
use stdClass;

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
    private $infANTT = '';
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
    private $seg = [];
    /**
     * @type string|\DOMNode
     */
    private $prodPred = null;
    /**
     * @type string|\DOMNode
     */
    private $infMunDescarga = [];
    /**
     * @type string|\DOMNode
     */
    private $veicReboque = [];
    /**
     * @type string|\DOMNode
     */
    private $infNFe = [];
    /**
     * @type string|\DOMNode
     */
    private $infCTe = [];
    /**
     * @type string|\DOMNode
     */
    private $infMDFeTransp = [];
    /**
     * @type string|\DOMNode
     */
    private $infContratante = [];
    /**
     * @type string|\DOMNode
     */
    private $infPag = [];
    /**
     * @type string|\DOMNode
     */
    private $infLotacao = null;
    /**
     * @type string|\DOMNode
     */
    private $autXML = [];
    /**
     * @type string|\DOMNode
     */
    private $infCIOT = [];
    /**
     * @type string|\DOMNode
     */
    private $disp = [];
    /**
     * @type string|\DOMNode
     */
    private $infMunCarrega = [];
    /**
     * @type string|\DOMNode
     */
    private $infPercurso = [];
    /**
     * @type string
     */
    private $codAgPorto = '';
    /**
     * @type string|\DOMNode
     */
    private $lacRodo = [];
    /**
     * @type string|\DOMNode
     */
    private $vag = [];
    /**
     * @type string|\DOMNode
     */
    private $infAdic = '';
    /**
     * @type string|\DOMNode
     */
    private $infRespTec = '';
    /**
     * @type string|\DOMNode
     */
    private $rodo = '';
    /**
     * @type string|\DOMNode
     */
    private $ferrov = '';
    /**
     * @type string|\DOMNode
     */
    private $infDoc = '';
    /**
     * @type string|\DOMNode
     */
    private $valePed = '';
    /**
     * @type string|\DOMNode
     */
    private $veicTracao = '';
    /**
     * @type string|\DOMNode
     */
    private $infUnidTransp = '';
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
    private $aquav = '';
    /**
     * @type array
     */
    private $infTermCarreg = [];
    /**
     * @type array
     */
    private $infTermDescarreg = [];
    /**
     * @type array
     */
    private $infEmbComb = [];
    /**
     * @type array
     */
    private $infUnidCargaVazia = [];
    /**
     * @type array
     */
    private $infUnidTranspVazia = [];
    /**
     * @var boolean
     */
    protected $replaceAccentedChars = false;
    /**
     * @var null
     */
    private $categCombVeic = null;
    /**
     * @type \DOMImproved
     */
    protected $dom;
    /**
     * @type false|string
     */
    protected $xml;
    /**
     * @type array
     */
    protected $lacres;
    /**
     * @type string
     */
    protected $tpAmb;    
    /**
    * @type string
    */
    protected $csrt;

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
     * Set character convertion to ASCII only ou not
     * @param bool $option
     */
    public function setOnlyAscii($option = false)
    {
        $this->replaceAccentedChars = $option;
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
     * @param $indDoc
     * @return int|void
     */
    private function contaDoc($indDoc)
    {
        $total = 0;
        foreach ($indDoc as $doc) {
            $total += count($doc);
        }
        return $total;
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
        //cria a tag raiz da MDFe
        $this->buildMDFe();
        $this->buildInfModal();
        $this->infMDFe = $this->dom->createElement("infMDFe");
        $this->buildIde();
        $this->dom->appChild($this->emit, $this->enderEmit, 'Falta tag "enderEmit"');
        $this->dom->appChild($this->infMDFe, $this->emit, 'Falta tag "emit"');
        if ($this->rodo) {
            $tpEmit = $this->ide->getElementsByTagName('tpEmit')->item(0)->nodeValue;
            if (($tpEmit == 1 || $tpEmit == 3) && empty($this->prodPred)) {
                $this->errors[] = "Tag prodPred é obrigatória para modal rodoviário!";
            }
            if (($tpEmit == 1 || $tpEmit == 3) && empty($this->infLotacao)
                && ($this->contaDoc($this->infCTe)
                    + $this->contaDoc($this->infNFe)
                    + $this->contaDoc($this->infMDFeTransp)) == 1
            ) {
                $this->errors[] = "Tag infLotacao é obrigatória quando só "
                    . "existir um Documento informado!";
            }
            if ($this->infANTT) {
                if ($this->infCIOT) {
                    $this->dom->addArrayChild(
                        $this->infANTT,
                        $this->infCIOT,
                        'Falta tag "infCIOT"'
                    );
                }
                if ($this->valePed) {
                    $this->dom->appChild($this->infANTT, $this->valePed, 'Falta tag "valePed"');
                    $this->dom->addArrayChild($this->valePed, $this->disp, 'Falta tag "disp"');
                    if (!empty($this->categCombVeic)) {
                        $this->dom->addChild(
                            $this->valePed,
                            "categCombVeic",
                            $this->categCombVeic,
                            false,
                            "Categoria de Combinação Veicular"
                        );
                    }
                }
                if ($this->infContratante) {
                    $this->dom->addArrayChild(
                        $this->infANTT,
                        $this->infContratante,
                        'Falta tag "infContratante"'
                    );
                }
                if ($this->infPag) {
                    $this->dom->addArrayChild($this->infANTT, $this->infPag, 'Falta tag "infpag"');
                }
                $this->dom->appChild($this->rodo, $this->infANTT, 'Falta tag "infANTT"');
            }
            if ($this->veicTracao) {
                $this->dom->appChild($this->rodo, $this->veicTracao, 'Falta tag "rodo"');
            }
            if ($this->veicReboque) {
                $this->dom->addArrayChild($this->rodo, $this->veicReboque, 'Falta tag "veicReboque"');
            }
            if ($this->codAgPorto) {
                $this->dom->addChild(
                    $this->rodo,
                    "codAgPorto",
                    $this->codAgPorto,
                    false,
                    "Código de Agendamento no porto"
                );
            }
            if ($this->lacRodo) {
                $this->dom->addArrayChild($this->rodo, $this->lacRodo, 'Falta tag "lacRodo"');
            }
            $this->dom->appChild($this->infModal, $this->rodo, 'Falta tag "infModal"');
        }
        if ($this->aereo) {
            $this->dom->appChild($this->infModal, $this->aereo, 'Falta tag "aereo"');
        }
        if ($this->ferrov) {
            if ($this->trem) {
                $this->dom->appChild($this->ferrov, $this->trem, 'Falta tag "ferrov"');
            }
            if ($this->vag) {
                $this->dom->addArrayChild($this->ferrov, $this->vag, 'Falta tag "vag"');
            }
            $this->dom->appChild($this->infModal, $this->ferrov, 'Falta tag "ferrov"');
        }
        if ($this->aquav) {
            foreach ($this->infTermCarreg as $termCarreg) {
                $this->dom->appChild($this->aquav, $termCarreg, 'Falta tag "aquav"');
            }
            foreach ($this->infTermDescarreg as $termDescarreg) {
                $this->dom->appChild($this->aquav, $termDescarreg, 'Falta tag "aquav"');
            }
            foreach ($this->infEmbComb as $embComb) {
                $this->dom->appChild($this->aquav, $embComb, 'Falta tag "aquav"');
            }
            foreach ($this->infUnidCargaVazia as $unidCargaVazia) {
                $this->dom->appChild($this->aquav, $unidCargaVazia, 'Falta tag "aquav"');
            }
            foreach ($this->infUnidTranspVazia as $unidTranspVazia) {
                $this->dom->appChild($this->aquav, $unidTranspVazia, 'Falta tag "aquav"');
            }
            $this->dom->appChild($this->infModal, $this->aquav, 'Falta tag "aquav"');
        }
        $this->dom->appChild($this->infMDFe, $this->infModal, 'Falta tag "infModal"');
        if ($this->infDoc) {
            $this->dom->appChild($this->infMDFe, $this->infDoc, 'Falta tag "infDoc"');
            if ($this->infMunDescarga) {
                foreach ($this->infMunDescarga as $key => $value) {
                    $this->dom->appChild($this->infDoc, $value, 'Falta tag "infMunDescarga"');
                    if (isset($this->infCTe[$key])) {
                        $this->dom->addArrayChild($value, $this->infCTe[$key], 'Falta tag "infCTe"');
                    }
                    if (isset($this->infNFe[$key])) {
                        $this->dom->addArrayChild(
                            $value,
                            $this->infNFe[$key],
                            'Falta tag "infNFe"'
                        );
                    }
                    if (isset($this->infMDFeTransp[$key])) {
                        $this->dom->addArrayChild(
                            $value,
                            $this->infMDFeTransp[$key],
                            'Falta tag "infMDFeTransp"'
                        );
                    }
                }
            }
        }
        if (!empty($this->seg)) {
            $this->dom->addArrayChild($this->infMDFe, $this->seg, 'Falta tag "seg"');
        }
        if (!empty($this->prodPred)) {
            $this->dom->appChild($this->infMDFe, $this->prodPred, 'Falta tag "prodPred"');
        }
        $this->dom->appChild($this->infMDFe, $this->tot, 'Falta tag "tot"');
        if (!empty($this->lacres)) {
            foreach ($this->lacres as $lacres) {
                $this->dom->appChild($this->infMDFe, $lacres, 'Falta tag "lacres"');
            }
        }
        foreach ($this->autXML as $autXML) {
            $this->dom->appChild($this->infMDFe, $autXML, 'Falta tag "infMDFe"');
        }
        if (!empty($this->infAdic)) {
            $this->dom->appChild($this->infMDFe, $this->infAdic, 'Falta tag "infAdic"');
        }
        if (!empty($this->infRespTec)) {
            $this->dom->appChild($this->infMDFe, $this->infRespTec, 'Falta tag "infRespTec"');
        }
        $this->dom->appChild($this->MDFe, $this->infMDFe, 'Falta tag "infMDFe"');
        $this->dom->appendChild($this->MDFe);
        // testa da chave
        $this->checkMDFKey($this->dom);
        $this->xml = $this->dom->saveXML();
        if (count($this->errors) > 0) {
            throw new RuntimeException('Existem erros nas tags. Obtenha os erros com getErrors().');
        }
        return true;
    }

    /**
     * Informações de identificação da MDFe
     * tag MDFe/infMDFe/ide
     *
     * @param stdClass $std
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
            'UFIni',
            'UFFim',
            'dhIniViagem',
            'indCanalVerde',
            'indCarregaPosterior'
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
            str_pad($std->cMDF, 8, '0', STR_PAD_LEFT),
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
        $this->dom->addChild(
            $ide,
            "dhIniViagem",
            $std->dhIniViagem,
            false,
            $identificador . "Data e hora previstos de início da viagem"
        );
        $this->dom->addChild(
            $ide,
            "indCanalVerde",
            $std->indCanalVerde,
            false,
            $identificador . "Indicador de participação do Canal Verde"
        );
        if ($std->indCarregaPosterior && $std->indCarregaPosterior == '1') {
            $this->dom->addChild(
                $ide,
                "indCarregaPosterior",
                $std->indCarregaPosterior,
                false,
                $identificador . "Indicador de MDF-e com inclusão da Carga posterior"
                . " a emissão por evento de inclusão de DF-e"
            );
        }

        $this->mod = $std->mod;
        $this->ide = $ide;
        return $ide;
    }

    /**
     * taginfMunCarrega
     *
     * tag MDFe/infMDFe/ide/infMunCarrega
     *
     * @param stdClass $std
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
        $this->infMunCarrega[] = $infMunCarrega;
        return $infMunCarrega;
    }

    /**
     * tagInfPercurso
     *
     * tag MDFe/infMDFe/ide/infPercurso
     *
     * @param stdClass $std
     * @return DOMElement
     */
    public function taginfPercurso(stdClass $std)
    {
        $possible = [
            'UFPer'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $infPercurso = $this->dom->createElement("infPercurso");
        $this->dom->addChild(
            $infPercurso,
            "UFPer",
            $std->UFPer,
            true,
            "Sigla das Unidades da Federação do percurso"
        );
        $this->infPercurso[] = $infPercurso;
        return $infPercurso;
    }

    /**
     * tagemit
     * Identificação do emitente da MDFe
     * tag MDFe/infMDFe/emit
     *
     * @param stdClass $std
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
        if ($std->CPF) {
            $this->dom->addChild(
                $this->emit,
                "CPF",
                $std->CPF,
                true,
                $identificador . "CPF do emitente"
            );
        } else {
            $this->dom->addChild(
                $this->emit,
                "CNPJ",
                $std->CNPJ,
                true,
                $identificador . "CNPJ do emitente"
            );
        }
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
            substr($std->xNome, 0, 60),
            true,
            $identificador . "Razão Social ou Nome do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "xFant",
            substr($std->xFant, 0, 60),
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
     * @param stdClass $std
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
     * tagrodo
     * tag MDFe/infMDFe/infModal/rodo
     *
     * @return DOMElement
     */
    private function tagrodo()
    {
        $this->rodo = $this->dom->createElement("rodo");
        return $this->rodo;
    }

    /**
     * tagferrov
     * tag MDFe/infMDFe/infModal/ferrov
     *
     * @return DOMElement
     */
    private function tagferrov()
    {
        if (empty($this->ferrov)) {
            $this->ferrov = $this->dom->createElement("ferrov");
        }
        return $this->ferrov;
    }

    /**
     * tagrodo
     * tag MDFe/infMDFe/infModal/rodo
     *
     * @return DOMElement
     */
    private function taginfDoc()
    {
        if (empty($this->infDoc)) {
            $this->infDoc = $this->dom->createElement("infDoc");
        }
        return $this->infDoc;
    }

    /**
     * valePed
     * tag MDFe/infMDFe/infModal/rodo/infANTT/valePed
     *
     * @return DOMElement
     */
    public function tagvalePed($categCombVeic)
    {
        $this->valePed = $this->dom->createElement("valePed");
        $this->categCombVeic = $categCombVeic;
        return $this->valePed;
    }

    /**
     * infANTT
     * tag MDFe/infMDFe/infModal/rodo/infANTT
     *
     * @return DOMElement
     */
    public function taginfANTT(stdClass $std)
    {
        $possible = [
            'RNTRC'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = '[2] <infANTT> - ';
        $infANTT = $this->dom->createElement("infANTT");
        $this->dom->addChild(
            $infANTT,
            "RNTRC",
            $std->RNTRC,
            false,
            $identificador . "Registro Nacional de Transportadores Rodoviários"
            . " de Carga"
        );
        $this->infANTT = $infANTT;
        return $infANTT;
    }

    /**
     * disp
     * tag MDFe/infMDFe/infModal/rodo/infANTT/disp
     *
     * @return DOMElement
     */
    public function tagdisp(stdClass $std)
    {
        $possible = [
            'CNPJForn',
            'CNPJPg',
            'CPFPg',
            'nCompra',
            'vValePed',
            'tpValePed'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = '[4] <disp> - ';
        $disp = $this->dom->createElement("disp");
        $this->dom->addChild(
            $disp,
            "CNPJForn",
            $std->CNPJForn,
            false,
            $identificador . "CNPJ da empresa fornecedora do ValePedágio"
        );
        $this->dom->addChild(
            $disp,
            "CNPJPg",
            $std->CNPJPg,
            false,
            $identificador . "CNPJ do responsável pelo pagamento do Vale-Pedágio"
        );
        $this->dom->addChild(
            $disp,
            "CPFPg",
            $std->CPFPg,
            false,
            $identificador . "CPF do responsável pelo pagamento do Vale-Pedágio"
        );
        $this->dom->addChild(
            $disp,
            "nCompra",
            $std->nCompra,
            false,
            $identificador . "Número do comprovante de compra"
        );
        $this->dom->addChild(
            $disp,
            "vValePed",
            $this->conditionalNumberFormatting($std->vValePed),
            true,
            $identificador . "Valor do Vale-Pedagio"
        );
        $this->dom->addChild(
            $disp,
            "tpValePed",
            $std->tpValePed,
            false,
            $identificador . "Tipo do Vale Pedágio"
        );
        $this->disp[] = $disp;
        return $disp;
    }

    /**
     * infContratante
     * tag MDFe/infMDFe/infModal/rodo/infANTT/infContratante
     *
     * @return DOMElement
     */
    public function taginfContratante(stdClass $std)
    {
        $possible = [
            'xNome',
            'CPF',
            'CNPJ',
            'idEstrangeiro',
            'NroContrato',
            'vContratoGlobal'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = '[4] <infContratante> - ';
        $infContratante = $this->dom->createElement("infContratante");

        $this->dom->addChild(
            $infContratante,
            "xNome",
            $std->xNome,
            false,
            $identificador . "Nome do contratante do serviço"
        );
        if ($std->CPF) {
            $this->dom->addChild(
                $infContratante,
                "CPF",
                $std->CPF,
                true,
                $identificador . "Número do CPF do contratante do serviço"
            );
        } elseif ($std->CNPJ) {
            $this->dom->addChild(
                $infContratante,
                "CNPJ",
                $std->CNPJ,
                true,
                $identificador . "Número do CNPJ do contratante do serviço"
            );
        } else {
            $this->dom->addChild(
                $infContratante,
                "idEstrangeiro",
                $std->idEstrangeiro,
                true,
                $identificador . "Identificador do contratante do serviço em "
                . "caso de ser estrangeiro"
            );
        }
        if (!empty($std->NroContrato) or !empty($std->vContratoGlobal)) {
            $identificador = '[4] <infContrato> - ';
            $infContrato = $this->dom->createElement("infContrato");

            $this->dom->addChild(
                $infContrato,
                "NroContrato",
                $std->NroContrato,
                true,
                $identificador . "Número do contrato do transportador com o contratante quando este existir "
                . "para prestações continuadas"
            );
            $this->dom->addChild(
                $infContrato,
                "vContratoGlobal",
                $this->conditionalNumberFormatting($std->vContratoGlobal),
                true,
                $identificador . "Valor Global do Contrato"
            );
            $infContratante->appendChild($infContrato);
        }
        $this->infContratante[] = $infContratante;
        return $infContratante;
    }

    /**
     * infANTT
     * tag MDFe/infMDFe/infModal/rodo/infANTT/infCIOT
     *
     * @return DOMElement
     */
    public function taginfCIOT(stdClass $std)
    {
        $possible = [
            'CIOT',
            'CPF',
            'CNPJ'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = '[4] <infCIOT> - ';
        $infCIOT = $this->dom->createElement("infCIOT");
        $this->dom->addChild(
            $infCIOT,
            "CIOT",
            $std->CIOT,
            true,
            $identificador . "Código Identificador da Operação de Transporte"
        );
        if ($std->CPF) {
            $this->dom->addChild(
                $infCIOT,
                "CPF",
                $std->CPF,
                true,
                $identificador . "Número do CPF responsável pela geração do CIOT"
            );
        } else {
            $this->dom->addChild(
                $infCIOT,
                "CNPJ",
                $std->CNPJ,
                true,
                $identificador . "Número do CNPJ responsável pela geração do CIOT"
            );
        }
        $this->infCIOT[] = $infCIOT;
        return $infCIOT;
    }

    /**
     * tagInfMunDescarga
     * tag MDFe/infMDFe/infDoc/infMunDescarga
     *
     * @param stdClass $std
     * @return DOMElement
     */
    public function taginfMunDescarga(stdClass $std)
    {
        $possible = [
            'cMunDescarga',
            'xMunDescarga',
            'nItem'
        ];
        $this->taginfDoc();
        $std = $this->equilizeParameters($std, $possible);
        $identificador = '[4] <infMunDescarga> - ';
        $infMunDescarga = $this->dom->createElement("infMunDescarga");
        $this->dom->addChild(
            $infMunDescarga,
            "cMunDescarga",
            $std->cMunDescarga,
            true,
            $identificador . "Código do Município de Descarga"
        );
        $this->dom->addChild(
            $infMunDescarga,
            "xMunDescarga",
            $std->xMunDescarga,
            true,
            $identificador . "Nome do Município de Descarga"
        );
        $this->infMunDescarga[$std->nItem] = $infMunDescarga;
        return $infMunDescarga;
    }

    /**
     * taginfCTe
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infCTe
     *
     * @param stdClass $std
     * @return DOMElement
     */
    public function taginfCTe(stdClass $std)
    {
        $possible = [
            'chCTe',
            'SegCodBarra',
            'indReentrega',
            'infEntregaParcial',
            'infUnidTransp',
            'peri',
            'nItem'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $infCTe = $this->dom->createElement("infCTe");
        $identificador = '[4] <infCTe> - ';
        $this->dom->addChild(
            $infCTe,
            "chCTe",
            $std->chCTe,
            true,
            $identificador . "Chave de Acesso CTe"
        );
        $this->dom->addChild(
            $infCTe,
            "SegCodBarra",
            $std->SegCodBarra,
            false,
            $identificador . "Segundo código de barras do CTe"
        );
        $this->dom->addChild(
            $infCTe,
            "indReentrega",
            $std->indReentrega,
            false,
            $identificador . "Indicador de Reentrega"
        );
        if ($std->infUnidTransp) {
            foreach ($std->infUnidTransp as $value) {
                $this->dom->appChild(
                    $infCTe,
                    $this->taginfUnidTransp($value),
                    'Falta tag "infUnidTransp"'
                );
            }
        }
        if ($std->peri) {
            foreach ($std->peri as $value) {
                $this->dom->appChild(
                    $infCTe,
                    $this->tagperi($value),
                    'Falta tag "peri"'
                );
            }
        }
        if ($std->infEntregaParcial != null) {
            $possible = [
                'qtdTotal',
                'qtdParcial'
            ];
            $stdinfEntregaParcial = $this->equilizeParameters(
                $std->infEntregaParcial,
                $possible
            );
            $identificadorparcial = '[4] <infEntregaParcial> - ';
            $infEntregaParcial = $this->dom->createElement("infEntregaParcial");
            $this->dom->addChild(
                $infEntregaParcial,
                "qtdTotal",
                $this->conditionalNumberFormatting($stdinfEntregaParcial->qtdTotal, 4),
                true,
                $identificadorparcial . "Quantidade total de volumes"
            );
            $this->dom->addChild(
                $infEntregaParcial,
                "qtdParcial",
                $this->conditionalNumberFormatting($stdinfEntregaParcial->qtdParcial, 4),
                true,
                $identificadorparcial . "Quantidade de volumes enviados no MDF-e"
            );
            $this->dom->appChild($infCTe, $infEntregaParcial, 'Falta tag "infCTe"');
        }
        $this->infCTe[$std->nItem][] = $infCTe;
        return $infCTe;
    }

    /**
     * tagperi
     * tag MDFe/infMDFe/infDoc/infMunDescarga/(infCTe/infNFe)/peri
     *
     * @param stdClass $std
     * @return DOMElement
     */
    private function tagperi(stdClass $std)
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
     * @param stdClass $std
     * @return DOMElement
     */
    public function taginfNFe(stdClass $std)
    {
        $possible = [
            'chNFe',
            'SegCodBarra',
            'indReentrega',
            'infUnidTransp',
            'peri',
            'nItem'
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
        if ($std->infUnidTransp) {
            foreach ($std->infUnidTransp as $value) {
                $this->dom->appChild(
                    $infNFe,
                    $this->taginfUnidTransp($value),
                    'Falta tag "infUnidTransp"'
                );
            }
        }
        if ($std->peri) {
            foreach ($std->peri as $value) {
                $this->dom->appChild($infNFe, $this->tagperi($value), 'Falta tag "peri"');
            }
        }
        $this->infNFe[$std->nItem][] = $infNFe;
        return $infNFe;
    }

    /**
     * taginfMDFeTransp
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infMDFeTransp
     *
     * @param stdClass $std
     * @return DOMElement
     */
    public function taginfMDFeTransp(stdClass $std)
    {
        $possible = [
            'chMDFe',
            'indReentrega',
            'nItem'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $infMDFeTransp = $this->dom->createElement("infMDFeTransp");
        $this->dom->addChild(
            $infMDFeTransp,
            "chMDFe",
            $std->chMDFe,
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
        if ($std->infUnidTransp) {
            foreach ($std->infUnidTransp as $value) {
                $this->dom->appChild(
                    $infMDFeTransp,
                    $this->taginfUnidTransp($value),
                    'Falta tag "infUnidTransp"'
                );
            }
        }
        if ($std->peri) {
            foreach ($std->peri as $value) {
                $this->dom->appChild(
                    $infMDFeTransp,
                    $this->tagperi($value),
                    'Falta tag "peri"'
                );
            }
        }
        $this->infMDFeTransp[$std->nItem][] = $infMDFeTransp;
        return $infMDFeTransp;
    }

    /**
     * taginfUnidTransp
     * tag MDFe/infMDFe/infDoc/infMunDescarga/(infCTe/infNFe)/infUnidTransp
     *
     * @param stdClass $std
     * @return DOMElement
     */
    private function taginfUnidTransp(stdClass $std)
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
                $this->dom->appChild(
                    $infUnidTransp,
                    $lacUnidTransp,
                    'Falta tag "infUnidTransp"'
                );
            }
        }
        if ($std->infUnidCarga) {
            foreach ($std->infUnidCarga as $value) {
                $this->dom->appChild(
                    $infUnidTransp,
                    $this->taginfUnidCarga($value),
                    'Falta tag "infUnidCarga"'
                );
            }
        }
        $this->dom->addChild(
            $infUnidTransp,
            "qtdRat",
            $this->conditionalNumberFormatting($std->qtdRat),
            false,
            "Quantidade rateada (Peso,Volume) "
        );
        return $infUnidTransp;
    }

    /**
     * taginfUnidCarga
     * tag MDFe/infMDFe/infDoc/infMunDescarga/(infCTe/infNFe)/infUnidCarga
     *
     * @param stdClass $std
     * @return DOMElement
     */
    private function taginfUnidCarga(stdClass $std)
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
                $this->dom->appChild(
                    $infUnidCarga,
                    $lacUnidCarga,
                    'Falta tag "infUnidCarga"'
                );
            }
        }
        $this->dom->addChild(
            $infUnidCarga,
            "qtdRat",
            $this->conditionalNumberFormatting($std->qtdRat),
            false,
            "Quantidade rateada (Peso,Volume) "
        );
        return $infUnidCarga;
    }

    /**
     * tagseg
     * tag MDFe/infMDFe/seg
     *
     * @param stdClass $std
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
        $this->seg[] = $seg;
        return $seg;
    }

    /**
     * tagprodPred
     * tag MDFe/infMDFe/prodPred
     *
     * @param stdClass $std
     * @return DOMElement
     */
    public function tagprodPred($std)
    {
        $possible = [
            'tpCarga',
            'xProd',
            'cEAN',
            'NCM',
            'infLotacao'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->prodPred = $this->dom->createElement("prodPred");
        $this->dom->addChild(
            $this->prodPred,
            "tpCarga",
            $std->tpCarga,
            true,
            "Tipo da Carga. 01-Granel sólido; 02-Granel líquido; "
            . "03-Frigorificada; 04-Conteinerizada; 05-Carga Geral; "
            . "06-Neogranel; 07-Perigosa (granel sólido); 08-Perigosa (granel "
            . "líquido); 09-Perigosa (carga frigorificada); 10-Perigosa "
            . "(conteinerizada); 11-Perigosa (carga geral)."
        );
        $this->dom->addChild(
            $this->prodPred,
            "xProd",
            $std->xProd,
            true,
            "Descrição do produto predominante"
        );
        $this->dom->addChild(
            $this->prodPred,
            "cEAN",
            $std->cEAN,
            false,
            "GTIN (Global Trade Item Number) do produto, antigo código EAN "
            . "ou código de barras"
        );
        $this->dom->addChild(
            $this->prodPred,
            "NCM",
            $std->NCM,
            false,
            "Código NCM"
        );
        if (!empty($std->infLotacao)) {
            $this->dom->appChild(
                $this->prodPred,
                $this->taginfLotacao($std->infLotacao),
                'Falta tag "infLotacao"'
            );
        }
        return $this->prodPred;
    }

    /**
     *
     */
    private function taginfLotacao(stdClass $std)
    {
        $possible = [
            'infLocalCarrega',
            'infLocalDescarrega'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->infLotacao = $this->dom->createElement("infLotacao");
        if (!empty($std->infLocalCarrega)) {
            $this->dom->appChild(
                $this->infLotacao,
                $this->tagLocalCarrega($std->infLocalCarrega),
                'Falta tag "infLocalCarrega"'
            );
        }
        if (!empty($std->infLocalDescarrega)) {
            $this->dom->appChild(
                $this->infLotacao,
                $this->tagLocalDescarrega($std->infLocalDescarrega),
                'Falta tag "infLocalDescarrega"'
            );
        }
        return $this->infLotacao;
    }

    /**
     * Informações da localização do carregamento do MDF-e de carga lotação
     *
     */
    private function tagLocalCarrega(stdClass $std)
    {
        $possible = [
            'CEP',
            'latitude',
            'longitude'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $tagLocalCarrega = $this->dom->createElement("infLocalCarrega");
        if (!empty($std->CEP)) {
            $this->dom->addChild(
                $tagLocalCarrega,
                "CEP",
                $std->CEP,
                true,
                "CEP onde foi carregado o MDF-e"
            );
        } else {
            $this->dom->addChild(
                $tagLocalCarrega,
                "latitude",
                $std->latitude,
                true,
                "Latitude do ponto geográfico onde foi carregado o MDF-e"
            );
            $this->dom->addChild(
                $tagLocalCarrega,
                "longitude",
                $std->longitude,
                true,
                "Longitude do ponto geográfico onde foi carregado o MDF-e"
            );
        }
        return $tagLocalCarrega;
    }

    /**
     * Informações da localização do descarregamento do MDF-e de carga lotação
     */
    private function tagLocalDescarrega(stdClass $std)
    {
        $possible = [
            'CEP',
            'latitude',
            'longitude'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $tagLocalDescarrega = $this->dom->createElement("infLocalDescarrega");
        if (!empty($std->CEP)) {
            $this->dom->addChild(
                $tagLocalDescarrega,
                "CEP",
                $std->CEP,
                true,
                "CEP onde foi descarregado o MDF-e"
            );
        } else {
            $this->dom->addChild(
                $tagLocalDescarrega,
                "latitude",
                $std->latitude,
                true,
                "Latitude do ponto geográfico onde foi descarregado o MDF-e"
            );
            $this->dom->addChild(
                $tagLocalDescarrega,
                "longitude",
                $std->longitude,
                true,
                "Longitude do ponto geográfico onde foi descarregado o MDF-e"
            );
        }
        return $tagLocalDescarrega;
    }

    /**
     * tagTot
     * tag MDFe/infMDFe/tot
     *
     * @param stdClass $std
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
        if (!isset($std->qCTe)) {
            $std->qCTe = 0;
            foreach ($this->infCTe as $infCTe) {
                $std->qCTe += count($infCTe);
            }
            if ($std->qCTe == 0) {
                $std->qCTe = '';
            }
        }
        if (!isset($std->qNFe)) {
            $std->qNFe = 0;
            foreach ($this->infNFe as $infNFe) {
                $std->qNFe += count($infNFe);
            }
            if ($std->qNFe == 0) {
                $std->qNFe = '';
            }
        }
        if (!isset($std->qMDFe)) {
            $std->qMDFe = 0;
            foreach ($this->infMDFeTransp as $infMDFeTransp) {
                $std->qMDFe += count($infMDFeTransp);
            }
            if ($std->qMDFe == 0) {
                $std->qMDFe = '';
            }
        }
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
            $this->conditionalNumberFormatting($std->vCarga),
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
            $this->conditionalNumberFormatting($std->qCarga, 4),
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
     * @param stdClass $std
     * @return DOMElement
     */
    public function taglacres(stdClass $std)
    {
        $possible = [
            'nLacre'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $lacres = $this->dom->createElement("lacres");
        $this->dom->addChild(
            $lacres,
            "nLacre",
            $std->nLacre,
            false,
            "Número do lacre"
        );
        $this->lacres[] = $lacres; //array de DOMNode
        return $this->lacres;
    }

    /**
     * taginfAdic
     * Grupo de Informações Adicionais Z01 pai A01
     * tag MDFe/infMDFe/infAdic (opcional)
     *
     * @param stdClass $std
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
     * @param stdClass $std
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
    private function buildInfModal()
    {
        $infModal = $this->dom->createElement("infModal");
        $infModal->setAttribute("versaoModal", $this->versao);
        $this->infModal = $infModal;
        $modal = $this->ide->getElementsByTagName('modal')->item(0)->nodeValue;
        /*
         1 - Rodoviário;
         2 - Aéreo;
         3 - Aquaviário;
         4 - Ferroviário;
         */
        if ($modal == '1') {
            $this->tagrodo();
        } elseif ($modal == '4') {
            $this->tagferrov();
        }
        return $infModal;
    }

    private function buildIde()
    {
        $this->dom->appChild($this->infMDFe, $this->ide, 'Falta tag "ide"');
        foreach ($this->infPercurso as $percurso) {
            $node = $this->ide->getElementsByTagName('infPercurso')->item(0);
            if (empty($node)) {
                $node = $this->ide->getElementsByTagName('UFFim')->item(0);
            } else {
                if ($this->ide->getElementsByTagName('infPercurso')->length > 1) {
                    $node = $this->ide->getElementsByTagName('infPercurso')
                        ->item($this->ide->getElementsByTagName('infPercurso')
                                ->length - 1);
                }
            }
            $this->dom->insertAfter($percurso, $node);
        }
        $UFFim = $this->ide->getElementsByTagName('UFFim')->item(0);
        foreach ($this->infMunCarrega as $munCarrega) {
            $this->dom->insertAfter($munCarrega, $UFFim);
        }
    }

    /**
     * tagAereo
     * tag MDFe/infMDFe/infModal/aereo
     *
     * @return DOMElement
     */

    public function tagaereo(stdClass $std)
    {
        $possible = [
            'nac',
            'matr',
            'nVoo',
            'cAerEmb',
            'cAerDes',
            'dVoo'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $aereo = $this->dom->createElement("aereo");
        $identificador = '[1] <aereo> - ';
        $this->dom->addChild(
            $aereo,
            "nac",
            $std->nac,
            true,
            $identificador . "Marca da Nacionalidade da aeronave"
        );
        $this->dom->addChild(
            $aereo,
            "matr",
            $std->matr,
            true,
            $identificador . "Marca de Matrícula da aeronave"
        );
        $this->dom->addChild(
            $aereo,
            "nVoo",
            $std->nVoo,
            true,
            $identificador . "Número do Vôo"
        );
        $this->dom->addChild(
            $aereo,
            "cAerEmb",
            $std->cAerEmb,
            true,
            $identificador . "Aeródromo de Embarque - Código IATA"
        );
        $this->dom->addChild(
            $aereo,
            "cAerDes",
            $std->cAerDes,
            true,
            $identificador . "Aeródromo de Destino - Código IATA"
        );
        $this->dom->addChild(
            $aereo,
            "dVoo",
            $std->dVoo,
            true,
            $identificador . "Data do Vôo"
        );
        $this->aereo = $aereo;
        return $aereo;
    }


    /**
     * tagtrem
     * tag MDFe/infMDFe/infModal/ferrov/trem
     *
     * @return DOMElement
     */

    public function tagtrem(stdClass $std)
    {
        $possible = [
            'xPref',
            'dhTrem',
            'xOri',
            'xDest',
            'qVag'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $trem = $this->dom->createElement("trem");
        $identificador = '[1] <trem> - ';
        $this->dom->addChild(
            $trem,
            "xPref",
            $std->xPref,
            true,
            $identificador . "Prefixo do Trem"
        );
        $this->dom->addChild(
            $trem,
            "dhTrem",
            $std->dhTrem,
            false,
            $identificador . "Data e hora de liberação do trem na origem"
        );
        $this->dom->addChild(
            $trem,
            "xOri",
            $std->xOri,
            true,
            $identificador . "Origem do Trem"
        );
        $this->dom->addChild(
            $trem,
            "xDest",
            $std->xDest,
            true,
            $identificador . "Destino do Trem"
        );
        $this->dom->addChild(
            $trem,
            "qVag",
            $std->qVag,
            true,
            $identificador . "Quantidade de vagões carregados"
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

    public function tagVag(stdClass $std)
    {
        $possible = [
            'pesoBC',
            'pesoR',
            'tpVag',
            'serie',
            'nVag',
            'nSeq',
            'TU'
        ];
        $identificador = '[1] <vag> - ';
        $std = $this->equilizeParameters($std, $possible);
        $vag = $this->dom->createElement("vag");
        $this->dom->addChild(
            $vag,
            "pesoBC",
            $std->pesoBC,
            true,
            $identificador . "Peso Base de Cálculo de Frete em Toneladas"
        );
        $this->dom->addChild(
            $vag,
            "pesoR",
            $std->pesoR,
            true,
            $identificador . "Peso Real em Toneladas"
        );
        $this->dom->addChild(
            $vag,
            "tpVag",
            $std->tpVag,
            false,
            $identificador . "Tipo de Vagão"
        );
        $this->dom->addChild(
            $vag,
            "serie",
            $std->serie,
            true,
            $identificador . "Serie de Identificação do vagão"
        );
        $this->dom->addChild(
            $vag,
            "nVag",
            $std->nVag,
            true,
            $identificador . "Número de Identificação do vagão"
        );
        $this->dom->addChild(
            $vag,
            "nSeq",
            $std->nSeq,
            false,
            $identificador . "Sequência do vagão na composição"
        );
        $this->dom->addChild(
            $vag,
            "TU",
            $this->conditionalNumberFormatting($std->TU, 3),
            true,
            $identificador . "Tonelada Útil"
        );
        $this->vag[] = $vag;
        return $vag;
    }

    /**
     * tagaquav
     * tag MDFe/infMDFe/infModal/aquav
     *
     * @param stdClass $std
     * @return DOMElement
     */

    public function tagaquav(stdClass $std)
    {
        $possible = [
            'irin',
            'tpEmb',
            'cEmbar',
            'xEmbar',
            'nViag',
            'cPrtEmb',
            'cPrtDest',
            'prtTrans',
            'tpNav',
            'infTermCarreg',
            'infTermDescarreg',
            'infEmbComb',
            'infUnidCargaVazia',
            'infUnidTranspVazia'
        ];
        $identificador = '[1] <aquav> - ';
        $std = $this->equilizeParameters($std, $possible);
        $aquav = $this->dom->createElement("aquav");
        $this->dom->addChild(
            $aquav,
            "irin",
            $std->irin,
            true,
            $identificador . "Irin do navio sempre deverá ser informado"
        );
        $this->dom->addChild(
            $aquav,
            "tpEmb",
            $std->tpEmb,
            true,
            $identificador . "Código do tipo de embarcação"
        );
        $this->dom->addChild(
            $aquav,
            "cEmbar",
            $std->cEmbar,
            true,
            $identificador . "Código da embarcação"
        );
        $this->dom->addChild(
            $aquav,
            "xEmbar",
            $std->xEmbar,
            true,
            $identificador . "Nome da embarcação"
        );
        $this->dom->addChild(
            $aquav,
            "nViag",
            $std->nViag,
            true,
            $identificador . "Número da Viagem"
        );
        $this->dom->addChild(
            $aquav,
            "cPrtEmb",
            $std->cPrtEmb,
            true,
            $identificador . "Código do Porto de Embarque"
        );
        $this->dom->addChild(
            $aquav,
            "cPrtDest",
            $std->cPrtDest,
            true,
            $identificador . "Código do Porto de Destino"
        );
        $this->dom->addChild(
            $aquav,
            "prtTrans",
            $std->prtTrans,
            false,
            $identificador . "Porto de Transbordo"
        );
        $this->dom->addChild(
            $aquav,
            "tpNav",
            $std->tpNav,
            false,
            $identificador . "Tipo de Navegação"
        );
        if ($std->infTermCarreg) {
            foreach ($std->infTermCarreg as $value) {
                $this->dom->appChild(
                    $aquav,
                    $this->taginfTermCarreg($value),
                    'Falta tag "infTermCarreg"'
                );
            }
        }
        if ($std->infTermDescarreg) {
            foreach ($std->infTermDescarreg as $value) {
                $this->dom->appChild(
                    $aquav,
                    $this->taginfTermDescarreg($value),
                    'Falta tag "infTermDescarreg"'
                );
            }
        }
        if ($std->infEmbComb) {
            foreach ($std->infEmbComb as $value) {
                $this->dom->appChild(
                    $aquav,
                    $this->taginfEmbComb($value),
                    'Falta tag "infEmbComb"'
                );
            }
        }
        if ($std->infUnidCargaVazia) {
            foreach ($std->infUnidCargaVazia as $value) {
                $this->dom->appChild(
                    $aquav,
                    $this->taginfUnidCargaVazia($value),
                    'Falta tag "infUnidCargaVazia"'
                );
            }
        }
        if ($std->infUnidTranspVazia) {
            foreach ($std->infUnidTranspVazia as $value) {
                $this->dom->appChild(
                    $aquav,
                    $this->taginfUnidTranspVazia($value),
                    'Falta tag "infUnidTranspVazia"'
                );
            }
        }
        $this->aquav = $aquav;
        return $aquav;
    }

    /**
     * infUnidTranspVazia
     * tag MDFe/infMDFe/infModal/Aqua/infUnidTranspVazia
     *
     * @return DOMElement
     */
    public function taginfUnidTranspVazia(stdClass $std)
    {
        $possible = [
            'idUnidTranspVazia',
            'tpUnidTranspVazia'
        ];
        $identificador = '[1] <infUnidTranspVazia> - ';
        $std = $this->equilizeParameters($std, $possible);
        $infUnidTranspVazia = $this->dom->createElement("infUnidTranspVazia");
        $this->dom->addChild(
            $infUnidTranspVazia,
            "idUnidTranspVazia",
            $std->idUnidTranspVazia,
            true,
            $identificador . "dentificação da unidades de transporte vazia"
        );
        $this->dom->addChild(
            $infUnidTranspVazia,
            "tpUnidTranspVazia",
            $std->tpUnidTranspVazia,
            true,
            $identificador . "Tipo da unidade de transporte vazia"
        );
        return $infUnidTranspVazia;
    }

    /**
     * infUnidCargaVazia
     * tag MDFe/infMDFe/infModal/Aqua/infUnidCargaVazia
     *
     * @return DOMElement
     */
    public function taginfUnidCargaVazia(stdClass $std)
    {
        $possible = [
            'idUnidCargaVazia',
            'tpUnidCargaVazia'
        ];
        $identificador = '[1] <infUnidCargaVazia> - ';
        $std = $this->equilizeParameters($std, $possible);
        $infUnidCargaVazia = $this->dom->createElement("infUnidCargaVazia");
        $this->dom->addChild(
            $infUnidCargaVazia,
            "idUnidCargaVazia",
            $std->idUnidCargaVazia,
            true,
            $identificador . "Identificação da unidades de carga vazia"
        );
        $this->dom->addChild(
            $infUnidCargaVazia,
            "tpUnidCargaVazia",
            $std->tpUnidCargaVazia,
            true,
            $identificador . "Tipo da unidade de carga vazia"
        );
        return $infUnidCargaVazia;
    }

    /**
     * taginfTermDescarreg
     * tag MDFe/infMDFe/infModal/Aqua/infTermDescarreg
     *
     * @return DOMElement
     */
    public function taginfTermDescarreg(stdClass $std)
    {
        $possible = [
            'cTermDescarreg',
            'xTermDescarreg'
        ];
        $identificador = '[1] <infTermDescarreg> - ';
        $std = $this->equilizeParameters($std, $possible);
        $infTermDescarreg = $this->dom->createElement("infTermDescarreg");
        $this->dom->addChild(
            $infTermDescarreg,
            "cTermDescarreg",
            $std->cTermDescarreg,
            true,
            $identificador . "Código do Terminal de Descarregamento"
        );
        $this->dom->addChild(
            $infTermDescarreg,
            "xTermDescarreg",
            $std->xTermDescarreg,
            true,
            $identificador . "Nome do Terminal de Descarregamento"
        );
        return $infTermDescarreg;
    }

    /**
     * tagInfTermCarreg
     * tag MDFe/infMDFe/infModal/aquav/infTermCarreg
     *
     * @return DOMElement
     */
    public function taginfTermCarreg(stdClass $std)
    {
        $possible = [
            'cTermCarreg',
            'xTermCarreg'
        ];
        $identificador = '[1] <infTermCarreg> - ';
        $std = $this->equilizeParameters($std, $possible);
        $infTermCarreg = $this->dom->createElement("infTermCarreg");

        $this->dom->addChild(
            $infTermCarreg,
            "cTermCarreg",
            $std->cTermCarreg,
            true,
            $identificador . "Código do Terminal de Carregamento"
        );
        $this->dom->addChild(
            $infTermCarreg,
            "xTermCarreg",
            $std->xTermCarreg,
            true,
            $identificador . "Nome do Terminal de Carregamento"
        );
        return $infTermCarreg;
    }

    /**
     * tagInfTermCarreg
     * tag MDFe/infMDFe/infModal/aquav/infEmbComb
     *
     * @param stdClass $std
     * @return DOMElement
     */
    public function taginfEmbComb(stdClass $std)
    {
        $possible = [
            'cEmbComb',
            'xBalsa'
        ];
        $identificador = '[1] <infEmbComb> - ';
        $std = $this->equilizeParameters($std, $possible);
        $infEmbComb = $this->dom->createElement("infEmbComb");

        $this->dom->addChild(
            $infEmbComb,
            "cEmbComb",
            $std->cEmbComb,
            true,
            $identificador . "Código da embarcação do comboio"
        );
        $this->dom->addChild(
            $infEmbComb,
            "xBalsa",
            $std->xBalsa,
            true,
            $identificador . "Identificador da Balsa"
        );
        return $infEmbComb;
    }

    /**
     * condutor
     * tag MDFe/infMDFe/infModal/rodo/veicTracao/condutor
     *
     * @param string $cEmbComb
     *
     * @return DOMElement
     */
    private function tagcondutor(stdClass $std)
    {
        $possible = [
            'xNome',
            'CPF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $condutor = $this->dom->createElement("condutor");
        $identificador = '[4] <condutor> - ';
        $this->dom->addChild(
            $condutor,
            "xNome",
            $std->xNome,
            true,
            $identificador . "Nome do Condutor "
        );
        $this->dom->addChild(
            $condutor,
            "CPF",
            $std->CPF,
            true,
            $identificador . "CPF do Condutor "
        );
        return $condutor;
    }

    /**
     * tagVeicTracao
     * tag MDFe/infMDFe/infModal/rodo/veicTracao
     *
     * @param stdClass $std
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
            'tpRod',
            'tpCar',
            'UF',
            'condutor'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $veicTracao = $this->dom->createElement("veicTracao");
        $identificador = '[4] <disp> - ';
        $this->dom->addChild(
            $veicTracao,
            "cInt",
            $std->cInt,
            false,
            $identificador . "Código interno do veículo"
        );
        $this->dom->addChild(
            $veicTracao,
            "placa",
            $std->placa,
            true,
            $identificador . "Placa do veículo"
        );
        $this->dom->addChild(
            $veicTracao,
            "RENAVAM",
            $std->RENAVAM,
            false,
            $identificador . "RENAVAM"
        );
        $this->dom->addChild(
            $veicTracao,
            "tara",
            $std->tara,
            true,
            $identificador . "Tara em KG"
        );
        $this->dom->addChild(
            $veicTracao,
            "capKG",
            $std->capKG,
            false,
            $identificador . "Capacidade em KG"
        );
        $this->dom->addChild(
            $veicTracao,
            "capM3",
            $std->capM3,
            false,
            $identificador . "Capacidade em M3"
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
            $identificadorProp = '[4] <prop> - ';
            $stdprop = $this->equilizeParameters($std->prop, $possible);
            $prop = $this->dom->createElement("prop");
            if ($stdprop->CPF) {
                $this->dom->addChild(
                    $prop,
                    "CPF",
                    $stdprop->CPF,
                    true,
                    $identificadorProp . "Número do CPF"
                );
            } else {
                $this->dom->addChild(
                    $prop,
                    "CNPJ",
                    $stdprop->CNPJ,
                    true,
                    $identificadorProp . "Número do CNPJ"
                );
            }
            $this->dom->addChild(
                $prop,
                "RNTRC",
                $stdprop->RNTRC,
                true,
                $identificadorProp . "RNTRC"
            );
            $this->dom->addChild(
                $prop,
                "xNome",
                $stdprop->xNome,
                true,
                $identificadorProp . "Razão Social"
            );
            $this->dom->addChild(
                $prop,
                "IE",
                $stdprop->IE,
                true,
                $identificadorProp . "Inscrição Estadual",
                true
            );
            $this->dom->addChild(
                $prop,
                "UF",
                $stdprop->UF,
                true,
                $identificadorProp . "Unidade da Federação"
            );
            $this->dom->addChild(
                $prop,
                "tpProp",
                $stdprop->tpProp,
                true,
                $identificadorProp . "Tipo Proprietário"
            );
            $this->dom->appChild($veicTracao, $prop, 'Falta tag "veicTracao"');
        }
        if ($std->condutor) {
            foreach ($std->condutor as $value) {
                $this->dom->appChild(
                    $veicTracao,
                    $this->tagcondutor($value),
                    'Falta tag "condutor"'
                );
            }
        }
        $this->dom->addChild(
            $veicTracao,
            "tpRod",
            $std->tpRod,
            true,
            $identificador . "Tipo de rodado"
        );
        $this->dom->addChild(
            $veicTracao,
            "tpCar",
            $std->tpCar,
            true,
            $identificador . "Tipo de carroceria"
        );
        $this->dom->addChild(
            $veicTracao,
            "UF",
            $std->UF,
            false,
            $identificador . "UF de licenciamento do veículo"
        );
        $this->veicTracao = $veicTracao;
        return $veicTracao;
    }

    /**
     * tagVeicReboque
     * tag MDFe/infMDFe/infModal/rodo/VeicReboque
     *
     * @param stdClass $std
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
        $identificador = '[4] <veicReboque> - ';
        $this->dom->addChild(
            $veicReboque,
            "cInt",
            $std->cInt,
            false,
            $identificador . "Código interno do veículo"
        );
        $this->dom->addChild(
            $veicReboque,
            "placa",
            $std->placa,
            true,
            $identificador . "Placa do veículo"
        );
        $this->dom->addChild(
            $veicReboque,
            "RENAVAM",
            $std->RENAVAM,
            false,
            $identificador . "RENAVAM"
        );
        $this->dom->addChild(
            $veicReboque,
            "tara",
            $std->tara,
            true,
            $identificador . "Tara em KG"
        );
        $this->dom->addChild(
            $veicReboque,
            "capKG",
            $std->capKG,
            false,
            $identificador . "Capacidade em KG"
        );
        $this->dom->addChild(
            $veicReboque,
            "capM3",
            $std->capM3,
            false,
            $identificador . "Capacidade em M3"
        );
        if ($std->prop != null) {
            $identificadorprop = '[4] <prop> - ';
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
            if ($stdprop->CPF) {
                $this->dom->addChild(
                    $prop,
                    "CPF",
                    $stdprop->CPF,
                    true,
                    $identificadorprop . "Número do CPF"
                );
            } else {
                $this->dom->addChild(
                    $prop,
                    "CNPJ",
                    $stdprop->CNPJ,
                    true,
                    $identificadorprop . "Número do CNPJ"
                );
            }
            $this->dom->addChild(
                $prop,
                "RNTRC",
                $stdprop->RNTRC,
                true,
                $identificadorprop . "RNTRC"
            );
            $this->dom->addChild(
                $prop,
                "xNome",
                $stdprop->xNome,
                true,
                $identificadorprop . "Razão Social"
            );
            $this->dom->addChild(
                $prop,
                "IE",
                $stdprop->IE,
                true,
                $identificadorprop . "Inscrição Estadual",
                true
            );
            $this->dom->addChild(
                $prop,
                "UF",
                $stdprop->UF,
                true,
                $identificadorprop . "Unidade da Federação"
            );
            $this->dom->addChild(
                $prop,
                "tpProp",
                $stdprop->tpProp,
                true,
                $identificadorprop . "Tipo Proprietário"
            );
            $this->dom->appChild($veicReboque, $prop, 'Falta tag "veicReboque"');
        }
        $this->dom->addChild(
            $veicReboque,
            "tpCar",
            $std->tpCar,
            true,
            $identificador . "Tipo de carroceria"
        );
        $this->dom->addChild(
            $veicReboque,
            "UF",
            $std->UF,
            false,
            $identificador . "UF de licenciamento do veículo"
        );
        $this->veicReboque[] = $veicReboque;
        return $veicReboque;
    }

    /**
     * tagcodAgPorto
     * tag MDFe/infMDFe/infModal/rodo/codAgPorto
     *
     * @param string codAgPorto
     * @return null
     */
    public function tagcodAgPorto($codAgPorto)
    {
        $this->codAgPorto = $codAgPorto;
        return null;
    }

    /**
     * taglacRodo
     * tag MDFe/infMDFe/infModal/rodo/lacRodo
     *
     * @param stdClass $std
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
            true,
            "Número do Lacre"
        );
        $this->lacRodo[] = $lacRodo;
        return $lacRodo;
    }

    /**
     * Informações do Responsável técnico ZD01 pai A01
     * tag NFe/infNFe/infRespTec (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws RuntimeException
     */
    public function taginfRespTec(stdClass $std)
    {
        $possible = [
            'CNPJ',
            'xContato',
            'email',
            'fone',
            'CSRT',
            'idCSRT'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $infRespTec = $this->dom->createElement("infRespTec");
        $this->dom->addChild(
            $infRespTec,
            "CNPJ",
            $std->CNPJ,
            true,
            "Informar o CNPJ da pessoa jurídica responsável pelo sistema "
            . "utilizado na emissão do documento fiscal eletrônico"
        );
        $this->dom->addChild(
            $infRespTec,
            "xContato",
            $std->xContato,
            true,
            "Informar o nome da pessoa a ser contatada na empresa desenvolvedora "
            . "do sistema utilizado na emissão do documento fiscal eletrônico"
        );
        $this->dom->addChild(
            $infRespTec,
            "email",
            $std->email,
            true,
            "Informar o e-mail da pessoa a ser contatada na empresa "
            . "desenvolvedora do sistema."
        );
        $this->dom->addChild(
            $infRespTec,
            "fone",
            $std->fone,
            true,
            "Informar o telefone da pessoa a ser contatada na empresa "
            . "desenvolvedora do sistema."
        );
        if (!empty($std->CSRT) && !empty($std->idCSRT)) {
            $this->csrt = $std->CSRT;
            $this->dom->addChild(
                $infRespTec,
                "idCSRT",
                $std->idCSRT,
                true,
                "Identificador do CSRT utilizado para montar o hash do CSRT"
            );
            $this->dom->addChild(
                $infRespTec,
                "hashCSRT",
                $std->CSRT,
                true,
                "hash do CSRT"
            );
        }
        $this->infRespTec = $infRespTec;
        return $infRespTec;
    }

    /**
     * Metodo responsavel para montagem da tag ingPag - Informações do Pagamento do Frete
     *
     * @param stdClass $std
     * @return DOMElement
     * @throws RuntimeException
     */
    public function taginfPag(stdClass $std)
    {
        $possible = [
            'xNome',
            'CPF',
            'CNPJ',
            'idEstrangeiro',
            'Comp',
            'vContrato',
            'indAltoDesemp',
            'indPag',
            'vAdiant',
            'indAntecipaAdiant',
            'infPrazo',
            'infBanc'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $infPag = $this->dom->createElement("infPag");
        $identificador = '[4] <infPag> - ';
        $this->dom->addChild(
            $infPag,
            "xNome",
            $std->xNome,
            true,
            $identificador . "Nome do responsável pelo pgto"
        );
        if (!empty($std->CPF)) {
            $this->dom->addChild(
                $infPag,
                "CPF",
                $std->CPF,
                true,
                $identificador . "Número do CPF do responsável pelo pgto"
            );
        } elseif (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $infPag,
                "CNPJ",
                $std->CNPJ,
                true,
                $identificador . "Número do CNPJ do responsável pelo pgto"
            );
        } else {
            $this->dom->addChild(
                $infPag,
                "idEstrangeiro",
                $std->idEstrangeiro,
                true,
                $identificador . "Identificador do responsável pelo pgto em "
                . "caso de ser estrangeiro"
            );
        }
        foreach ($std->Comp as $value) {
            $this->dom->appChild($infPag, $this->compPag($value), 'Falta tag "Comp"');
        }
        $this->dom->addChild(
            $infPag,
            "vContrato",
            $std->vContrato,
            true,
            $identificador . "Valor total do contrato"
        );
        $this->dom->addChild(
            $infPag,
            "indAltoDesemp",
            $std->indAltoDesemp,
            false,
            $identificador . "Indicador de operação de transporte de alto desempenho"
        );
        $this->dom->addChild(
            $infPag,
            "indPag",
            $std->indPag,
            true,
            $identificador . "Indicador da Forma de Pagamento"
        );
        if ($std->indPag == 1) {
            $this->dom->addChild(
                $infPag,
                "vAdiant",
                $this->conditionalNumberFormatting($std->vAdiant),
                false,
                $identificador . "Valor do Adiantamento"
            );
        }
        $this->dom->addChild(
            $infPag,
            "indAntecipaAdiant",
            $std->indAntecipaAdiant,
            false,
            $identificador . "Indicador de declaração de concordância em antecipar o adiantamento"
        );
        if ($std->indPag == 1) {
            foreach ($std->infPrazo as $value) {
                $this->dom->appChild($infPag, $this->infPrazo($value), 'Falta tag "infPrazo"');
            }
        }
        $this->dom->appChild($infPag, $this->infBanc($std->infBanc), 'Falta tag "infBanc"');
        $this->infPag[] = $infPag;
        return $infPag;
    }

    /**
     * Componentes do Pagamento do Frete
     * @param stdClass
     *
     */
    private function compPag(stdClass $std)
    {
        $possible = [
            'tpComp',
            'vComp',
            'xComp'
        ];
        $stdComp = $this->equilizeParameters($std, $possible);
        $comp = $this->dom->createElement("Comp");
        $identificador = '[4] <Comp> - ';
        $this->dom->addChild(
            $comp,
            "tpComp",
            $stdComp->tpComp,
            true,
            $identificador . "Tipo do Componente"
        );
        $this->dom->addChild(
            $comp,
            "vComp",
            $stdComp->vComp,
            true,
            $identificador . "Valor do Componente"
        );
        $this->dom->addChild(
            $comp,
            "xComp",
            $stdComp->xComp,
            false,
            $identificador . "Descrição do componente do tipo Outros"
        );
        return $comp;
    }

    /***
     * Informações do pagamento a prazo. Obs: Informar somente se indPag for à Prazo.
     *
     */
    private function infPrazo(stdClass $std)
    {
        $possible = [
            'nParcela',
            'dVenc',
            'vParcela',
            'tpAntecip'
        ];
        $stdPraz = $this->equilizeParameters($std, $possible);
        $prazo = $this->dom->createElement("infPrazo");
        $identificador = '[4] <infPrazo> - ';
        $this->dom->addChild(
            $prazo,
            "nParcela",
            $stdPraz->nParcela,
            false,
            $identificador . "Número da parcela"
        );
        $this->dom->addChild(
            $prazo,
            "dVenc",
            $stdPraz->dVenc,
            false,
            $identificador . "Data de vencimento da Parcela (AAAA-MMDD)"
        );
        $this->dom->addChild(
            $prazo,
            "vParcela",
            $this->conditionalNumberFormatting($stdPraz->vParcela),
            true,
            $identificador . "Valor da Parcela"
        );
        $this->dom->addChild(
            $prazo,
            "tpAntecip",
            $stdPraz->tpAntecip,
            false,
            $identificador . "Tipo de Permissão em relação a antecipação das parcelas"
        );
        return $prazo;
    }

    /**
     * Informações bancárias.
     *
     */
    private function infBanc(stdClass $std)
    {
        $possible = [
            'codBanco',
            'codAgencia',
            'CNPJIPEF',
            'PIX'
        ];
        $stdBanco = $this->equilizeParameters($std, $possible);
        $banco = $this->dom->createElement("infBanc");
        $identificador = '[4] <infBanc> - ';
        if (!empty($stdBanco->codBanco)) {
            $this->dom->addChild(
                $banco,
                "codBanco",
                $stdBanco->codBanco,
                true,
                $identificador . "Número do banco"
            );
            $this->dom->addChild(
                $banco,
                "codAgencia",
                $stdBanco->codAgencia,
                true,
                $identificador . "Número da Agência"
            );
        } elseif (!empty($stdBanco->CNPJIPEF)) {
            $this->dom->addChild(
                $banco,
                "CNPJIPEF",
                $stdBanco->CNPJIPEF,
                true,
                $identificador . "Número do CNPJ da Instituição de pagamento Eletrônico do Frete"
            );
        } else {
            $this->dom->addChild(
                $banco,
                "PIX",
                $stdBanco->PIX,
                true,
                $identificador . "Chave PIX"
            );
        }
        return $banco;
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
        $dt = new \DateTime($dhEmi);
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
     * Retorna os erros detectados
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Includes missing or unsupported properties in stdClass
     * Replace all unsuported chars
     *
     * @param stdClass $std
     * @param array $possible
     * @return stdClass
     */
    private function equilizeParameters(stdClass $std, $possible)
    {
        return Strings::equilizeParameters($std, $possible, $this->replaceAccentedChars);
    }

    /**
     * Formatação numerica condicional
     * @param string|float|int|null $value
     * @param int $decimal
     * @return string
     */
    protected function conditionalNumberFormatting($value = null, $decimal = 2)
    {
        if (is_numeric($value)) {
            return number_format($value, $decimal, '.', '');
        }
        return null;
    }
}
