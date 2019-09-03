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
    private $infMunDescarga = [];
    /**
     * @type string|\DOMNode
     */
    private $veicReboque = [];
    /**
     * @type string|\DOMNode
     */
    private $lacres = [];
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
    private $aquav = '';
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

    public function getXML()
    {
        if (empty($this->xml)) {
            $this->montaMDFe();
        }
        return $this->xml;
    }

    /**
     * Retorns the key number of NFe (44 digits)
     * @return string
     */
    public function getChave()
    {
        return $this->chMDFe;
    }

    /**
     * Returns the model of NFe 55 or 65
     * @return int
     */
    public function getModelo()
    {
        return $this->mod;
    }

    /**
     * Call method of xml assembly. For compatibility only.
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

        $this->dom->appChild($this->infMDFe, $this->ide, 'Falta tag "ide"');
        if ($this->infMunCarrega) {
            $this->dom->addArrayChild($this->ide, $this->infMunCarrega, 'Falta tag "infMunCarrega"');
        }
        if ($this->infPercurso) {
            $this->dom->addArrayChild($this->ide, $this->infPercurso, 'Falta tag "infPercurso"');
        }
        $this->dom->appChild($this->emit, $this->enderEmit, 'Falta tag "enderEmit"');
        $this->dom->appChild($this->infMDFe, $this->emit, 'Falta tag "emit"');
        if ($this->rodo) {

            if ($this->infANTT) {
                if ($this->infCIOT) {
                    $this->dom->addArrayChild($this->infANTT, $this->infCIOT, 'Falta tag "infCIOT"');
                }
                if ($this->valePed) {
                    $this->dom->appChild($this->infANTT, $this->valePed, 'Falta tag "valePed"');
                    if ($this->disp) {
                        $this->dom->addArrayChild($this->valePed, $this->disp, 'Falta tag "disp"');
                    }
                }
                if ($this->infContratante) {
                    $this->dom->addArrayChild($this->infANTT, $this->infContratante, 'Falta tag "infContratante"');
                }
                $this->dom->appChild($this->rodo, $this->infANTT, 'Falta tag "infANTT"');
            }
            if ($this->veicTracao) {
                $this->dom->appChild($this->rodo, $this->veicTracao, 'Falta tag "rodo"');
            }
            if ($this->veicReboque) {
                $this->dom->addArrayChild($this->rodo, $this->veicReboque, 'Falta tag "veicReboque"');
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
                        $this->dom->addArrayChild($value, $this->infNFe[$key], 'Falta tag "infNFe"');
                    }
                    if (isset($this->infMDFeTransp[$key])) {
                        $this->dom->addArrayChild($value, $this->infMDFeTransp[$key], 'Falta tag "infMDFeTransp"');
                    }
                }
            }
        }
        if (!empty($this->seg)) {
            $this->dom->addArrayChild($this->infMDFe, $this->seg, 'Falta tag "seg"');
        }
        $this->dom->appChild($this->infMDFe, $this->tot, 'Falta tag "tot"');
        foreach ($this->lacres as $lacres) {
            $this->dom->appChild($this->infMDFe, $lacres, 'Falta tag "lacres"');
        }
        foreach ($this->autXML as $autXML) {
            $this->dom->appChild($this->infMDFe, $autXML, 'Falta tag "autXML"');
        }
        if (!empty($this->infAdic)) {
            $this->dom->appChild($this->infMDFe, $this->infAdic, 'Falta tag "infAdic"');
        }

        $this->dom->appChild($this->MDFe, $this->infMDFe, 'Falta tag "infMDFe"');

        $this->dom->appendChild($this->MDFe);

        // testa da chave
        $this->checkMDFKey($this->dom);
        $this->xml = $this->dom->saveXML();

        return true;
    }

    /**
     * Informações de identificação da MDFe
     * tag MDFe/infMDFe/ide
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

        $this->mod = $std->mod;
        $this->ide = $ide;
        return $ide;
    }

    /**
     * taginfMunCarrega
     *
     * tag MDFe/infMDFe/ide/infMunCarrega
     *
     * @param  string $cMunCarrega
     * @param  string $xMunCarrega
     *
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
     * @param  string $ufPer
     *
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
     * @param  string $cnpj
     * @param  string $numIE
     * @param  string $xNome
     * @param  string $xFant
     *
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
            true,
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
     * @param  string $xLgr
     * @param  string $nro
     * @param  string $xCpl
     * @param  string $xBairro
     * @param  string $cMun
     * @param  string $xMun
     * @param  string $cep
     * @param  string $UF
     * @param  string $fone
     * @param  string $email
     *
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
    public function tagrodo()
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
    public function tagferrov()
    {
        $this->ferrov = $this->dom->createElement("ferrov");
        return $this->ferrov;
    }

    /**
     * tagrodo
     * tag MDFe/infMDFe/infModal/rodo
     *
     * @return DOMElement
     */
    public function taginfDoc()
    {
        $this->infDoc = $this->dom->createElement("infDoc");
        return $this->infDoc;
    }

    /**
     * valePed
     * tag MDFe/infMDFe/infModal/rodo/infANTT/valePed
     *
     * @return DOMElement
     */
    public function tagvalePed()
    {

        $this->valePed = $this->dom->createElement("valePed");
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
            $identificador . "Registro Nacional de Transportadores Rodoviários de Carga"
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
            'vValePed'
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
            $std->vValePed,
            false,
            $identificador . "Valor do Vale-Pedagio"
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
            'CPF',
            'CNPJ'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = '[4] <infContratante> - ';
        $infContratante = $this->dom->createElement("infContratante");
        if ($std->CPF) {
            $this->dom->addChild(
                $infContratante,
                "CPF",
                $std->CPF,
                true,
                $identificador . "Número do CPF do contratente do serviço"
            );
        } else {
            $this->dom->addChild(
                $infContratante,
                "CNPJ",
                $std->CNPJ,
                true,
                $identificador . "Número do CNPJ do contratente do serviço"
            );
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
     * @param  integer $nItem
     * @param  string  $cMunDescarga
     * @param  string  $xMunDescarga
     *
     * @return DOMElement
     */
    public function taginfMunDescarga(stdClass $std)
    {
        $possible = [
            'cMunDescarga',
            'xMunDescarga'
        ];
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
        $this->infMunDescarga[] = $infMunDescarga;
        return $infMunDescarga;
    }

    /**
     * taginfCTe
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infCTe
     *
     * @param  integer chCTe
     * @param  string  SegCodBarra
     * @param  string  indReentrega
     * @param  string  infUnidTransp
     * @param  string  peri
     * @param  string  infEntregaParcial
     *
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
            'peri'
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
            foreach ($std->infUnidTransp as  $value) {
                $this->dom->appChild($infCTe, $this->taginfUnidTransp($value), 'Falta tag "infUnidTransp"');
            }
        }
        if ($std->peri) {
            foreach ($std->peri as  $value) {
                $this->dom->appChild($infCTe, $this->tagperi($value), 'Falta tag "peri"');
            }
        }
        if ($std->infEntregaParcial != null) {
            $possible = [
                'qtdTotal',
                'qtdParcial'
            ];
            $stdinfEntregaParcial = $this->equilizeParameters($std->infEntregaParcial, $possible);
            $identificadorparcial = '[4] <infEntregaParcial> - ';
            $infEntregaParcial = $this->dom->createElement("infEntregaParcial");
            $this->dom->addChild(
                $infEntregaParcial,
                "qtdTotal",
                $stdinfEntregaParcial->qtdTotal,
                true,
                $identificadorparcial . "Quantidade total de volumes"
            );
            $this->dom->addChild(
                $infEntregaParcial,
                "qtdParcial",
                $stdinfEntregaParcial->qtdParcial,
                true,
                $identificadorparcial . "Quantidade de volumes enviados no MDF-e"
            );
            $this->dom->appChild($infCTe, $infEntregaParcial, 'Falta tag "$peri"');
        }
        $this->infCTe[count($this->infMunDescarga) - 1][] = $infCTe;
        return $infCTe;
    }

    /**
     * tagperi
     * tag MDFe/infMDFe/infDoc/infMunDescarga/(infCTe/infNFe)/peri
     *
     * @param  integer nONU
     * @param  string  xNomeAE
     * @param  string  xClaRisco
     * @param  string  grEmb
     * @param  string  qTotProd
     * @param  string  qVolTipo
     *
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
     * @param  integer chNFe
     * @param  string  SegCodBarra
     * @param  string  indReentrega
     * @param  string  infUnidTransp
     * @param  string  peri
     *
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
        if ($std->infUnidTransp) {
            foreach ($std->infUnidTransp as  $value) {
                $this->dom->appChild($infNFe, $this->taginfUnidTransp($value), 'Falta tag "infUnidTransp"');
            }
        }
        if ($std->peri) {
            foreach ($std->peri as  $value) {
                $this->dom->appChild($infNFe, $this->tagperi($value), 'Falta tag "peri"');
            }
        }
        $this->infNFe[count($this->infMunDescarga) - 1][] = $infNFe;
        return $infNFe;
    }

    /**
     * taginfMDFeTransp
     * tag MDFe/infMDFe/infDoc/infMunDescarga/infMDFeTransp
     *
     * @param  integer chMDFe
     * @param  string  indReentrega
     * @param  string  infUnidTransp
     * @param  string  peri
     *
     * @return DOMElement
     */
    public function taginfMDFeTransp(stdClass $std)
    {
        $possible = [
            'chNFe',
            'indReentrega',
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
        if ($std->infUnidTransp) {
            foreach ($std->infUnidTransp as  $value) {
                $this->dom->appChild($infMDFeTransp, $this->taginfUnidTransp($value), 'Falta tag "infUnidTransp"');
            }
        }
        if ($std->peri) {
            foreach ($std->peri as  $value) {
                $this->dom->appChild($infMDFeTransp, $this->tagperi($value), 'Falta tag "peri"');
            }
        }
        $this->infMDFeTransp[count($this->infMunDescarga) - 1][] = $infMDFeTransp;
        return $infMDFeTransp;
    }

    /**
     * taginfUnidTransp
     * tag MDFe/infMDFe/infDoc/infMunDescarga/(infCTe/infNFe)/infUnidTransp
     *
     * @param  integer tpUnidTrans
     * @param  string  idUnidTrans
     * @param  string  qtdRat
     * @param  string  lacUnidTransp
     * @param  string  infUnidCarga
     *
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
            foreach ($stdlacUnidTransp->nLacre as $nItem => $nLacre) {
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
        if ($std->infUnidCarga) {
            foreach ($std->infUnidCarga as  $value) {
                $this->dom->appChild($infUnidTransp, $this->taginfUnidCarga($value), 'Falta tag "infUnidCarga"');
            }
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
     * @param  integer tpUnidCarga
     * @param  string  idUnidCarga
     * @param  string  lacUnidCarga
     * @param  string  qtdRat
     *
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
            foreach ($stdlacUnidCarga->nLacre as $nItem => $nLacre) {
                $lacUnidCarga = $this->dom->createElement("lacUnidCarga");
                $this->dom->addChild(
                    $lacUnidCarga,
                    "nLacre",
                    $nLacre,
                    true,
                    "Número do lacre"
                );
                $this->dom->appChild($infUnidCarga, $lacUnidCarga, 'Falta tag "lacUnidCarga"');
            }
        }
        $this->dom->addChild(
            $infUnidCarga,
            "qtdRat",
            $std->qtdRat,
            false,
            "Quantidade rateada (Peso,Volume) "
        );
        return $infUnidCarga;
    }

    /**
     * tagseg
     * tag MDFe/infMDFe/seg
     *
     * @param  string $respSeg
     * @param  string $CNPJ
     * @param  string $CPF
     * @param  string $infSeg
     * @param  string $nApol
     * @param  string $nAver
     *
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
        $this->dom->appChild($seg, $infResp, 'Falta tag "infResp"');
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
            $this->dom->appChild($seg, $infSeg, 'Falta tag "infSeg"');
        }
        $this->dom->addChild(
            $seg,
            "nApol",
            $std->nApol,
            false,
            "Número da Apólice"
        );
        if ($std->nAver != null) {
            foreach ($std->nAver as $nItem => $nAver) {
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
     * @param  string $nLacre
     *
     * @return DOMElement
     */
    public function taglacres(stdClass $std)
    {
        $possible = [
            'nLacre'
        ];
        $std = $this->equilizeParameters($std, $possible);
        if ($std->nLacre != null) {
            foreach ($std->nLacre as $nItem => $nLacre) {
                $lacres = $this->dom->createElement("lacres");
                $this->dom->addChild(
                    $lacres,
                    "nLacre",
                    $nLacre,
                    false,
                    "Número do lacre"
                );
                $this->lacres[] = $lacres; //array de DOMNode
            }
        }
        return $this->lacres;
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
     * @param string $cnpj
     * @param string $cpf
     *
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
     * @param  string $versaoModal
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
     * @param  string $serie
     * @param  string $nVag
     * @param  string $nSeq
     * @param  string $tonUtil
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
            $std->TU,
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
     * @param  string $cnpjAgeNav
     * @param  string $tpEmb
     * @param  string $cEmbar
     * @param  string $nViagem
     * @param  string $cPrtEmb
     * @param  string $cPrtDest
     *
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
            foreach ($std->infTermCarreg as  $value) {
                $this->dom->appChild($aquav, $this->taginfTermCarreg($value), 'Falta tag "infTermCarreg"');
            }
        }
        if ($std->infTermDescarreg) {
            foreach ($std->infTermDescarreg as  $value) {
                $this->dom->appChild($aquav, $this->taginfTermDescarreg($value), 'Falta tag "infTermDescarreg"');
            }
        }
        if ($std->infEmbComb) {
            foreach ($std->infEmbComb as  $value) {
                $this->dom->appChild($aquav, $this->taginfEmbComb($value), 'Falta tag "infEmbComb"');
            }
        }
        if ($std->infUnidCargaVazia) {
            foreach ($std->infUnidCargaVazia as  $value) {
                $this->dom->appChild($aquav, $this->taginfUnidCargaVazia($value), 'Falta tag "infUnidCargaVazia"');
            }
        }
        if ($std->infUnidTranspVazia) {
            foreach ($std->infUnidTranspVazia as  $value) {
                $this->dom->appChild($aquav, $this->taginfUnidTranspVazia($value), 'Falta tag "infUnidTranspVazia"');
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
     * tag MDFe/infMDFe/infModal/Aqua/infTermCarreg
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
     * tagInfEmbComb
     * tag MDFe/infMDFe/infModal/Aqua/infEmbComb
     *
     * @param  string $cEmbComb
     *
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
     * @param  string $cEmbComb
     *
     * @return DOMElement
     */
    public function tagcondutor(stdClass $std)
    {
        $possible = [
            'xNome',
            'CPF',
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
                'TpProp'
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
                $identificadorProp . "Inscrição Estadual"
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
                "TpProp",
                $stdprop->TpProp,
                true,
                $identificadorProp . "Tipo Proprietário"
            );
            $this->dom->appChild($veicTracao, $prop, 'Falta tag "prop"');
        }
        if ($std->condutor) {
            foreach ($std->condutor as $value) {
                $this->dom->appChild($veicTracao, $this->tagcondutor($value), 'Falta tag "condutor"');
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
            true,
            $identificador . "UF de licenciamento do veículo"
        );
        $this->veicTracao = $veicTracao;
        return $veicTracao;
    }

    /**
     * tagVeicReboque
     * tag MDFe/infMDFe/infModal/rodo/VeicReboque
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
                'TpProp'
            ];
            $stdprop = $this->equilizeParameters($std->prop, $possible);
            $prop = $this->dom->createElement("prop");
            $this->dom->addChild(
                $prop,
                "CPF",
                $stdprop->CPF,
                true,
                $identificadorprop . "Número do CPF"
            );
            $this->dom->addChild(
                $prop,
                "CNPJ",
                $stdprop->CNPJ,
                true,
                $identificadorprop . "Número do CNPJ"
            );
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
                $identificadorprop . "Inscrição Estadual"
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
                "TpProp",
                $stdprop->TpProp,
                true,
                $identificadorprop . "Tipo Proprietário"
            );
            $this->dom->appChild($veicReboque, $prop, 'Falta tag "prop"');
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
            true,
            $identificador . "UF de licenciamento do veículo"
        );
        $this->veicReboque[] = $veicReboque;
        return $veicReboque;
    }

    /**
     * tagcodAgPorto
     * tag MDFe/infMDFe/infModal/rodo/codAgPorto
     *
     * @param  string codAgPorto
     *
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
     * @param  string nLacre
     *
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
        $cnpj = $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        $mod = $ide->getElementsByTagName('mod')->item(0)->nodeValue;
        $serie = $ide->getElementsByTagName('serie')->item(0)->nodeValue;
        $nNF = $ide->getElementsByTagName('nMDF')->item(0)->nodeValue;
        $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $cNF = $ide->getElementsByTagName('cMDF')->item(0)->nodeValue;
        $chave = str_replace('MDFe', '', $infMDFe->getAttribute("Id"));
        $dt = new DateTime($dhEmi);
        $chaveMontada = Keys::build(
            $cUF,
            $dt->format('y'),
            $dt->format('m'),
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
            $infMDFe->setAttribute("versao", $this->versao);
            $this->chMDFe = $chaveMontada;
        }
    }

    /**
     * Includes missing or unsupported properties in stdClass
     * Replace all unsuported chars
     * @param stdClass $std
     * @param array $possible
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
