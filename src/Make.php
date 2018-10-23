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
 * @copyright 2009-2018 NFePHP
 * @license   http://www.gnu.org/licenses/lesser.html LGPL v3
 * @link      http://github.com/nfephp-org/sped-mdfe for the canonical source repository
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 */

use NFePHP\Common\Keys;
use NFePHP\Common\DOMImproved as Dom;
use DOMElement;
use stdClass;
use DateTime;

class Make
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
    public $chMDFe;

    //propriedades privadas utilizadas internamente pela classe
    /**
     * @type string|\DOMNode
     */
    private $MDFe = '';

    /**
     * @var DOMElement
     */
    private $infMDFe;

    /**
     * @var DOMElement
     */
    protected $ide;

    /**
     * @var DOMElement
     */
    protected $emit;

    /**
     * @var DOMElement
     */
    protected $enderEmit;

    /**
     * @var DOMElement
     */
    private $infModal;

    /**
     * @var DOMElement
     */
    private $tot;

    /**
     * @var DOMElement
     */
    private $infAdic;

    /**
     * @var DOMElement
     */
    private $rodo;

    /**
     * @var DOMElement
     */
    private $veicTracao;

    /**
     * @var DOMElement
     */
    private $aereo;

    /**
     * @var DOMElement
     */
    private $trem;

    /**
     * @var DOMElement
     */
    private $aquav;

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
     * Returns xml string and assembly it is necessary
     * @return string
     */
    public function getXML()
    {
        if (empty($this->xml)) {
            $this->monta();
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
     * Mdfe xml mount method
     * @return boolean
     */
    public function monta()
    {
        if (count($this->erros) > 0) {
            return false;
        }
        //cria a tag raiz da MDFe
        $this->buildMDFe();
        //tag ide [4]
        $this->dom->appChild($this->infMDFe, $this->ide, 'Falta tag "infMDFe"');
        //tag emit [27]
        $this->dom->appChild($this->infMDFe, $this->emit, 'Falta tag "infMDFe"');
        //tag infModal [43]
        $this->buildInfModal();
        $this->dom->appChild($this->infMDFe, $this->infModal, 'Falta tag "infMDFe"');
        //tag infDoc [46]
        $this->buildInfDoc();
        $this->dom->appChild($this->infMDFe, $this->infDoc, 'Falta tag "infMDFe"');
        //tag seg [118]
        $this->dom->appChild($this->infMDFe, $this->seg, 'Falta tag "infMDFe"');
        //tag tot [128]
        $this->dom->appChild($this->infMDFe, $this->tot, 'Falta tag "infMDFe"');
        //tag lacres [135]
        $this->dom->addArrayChild($this->infMDFe, $this->aLacres);
        //tag lacres [137]
        $this->dom->addArrayChild($this->infMDFe, $this->aAutXML);
        //tag lacres [140]
        $this->dom->appChild($this->infMDFe, $this->infAdic, 'Falta tag "infMDFe"');
        //[1] tag infNFe [1]
        $this->dom->appChild($this->MDFe, $this->infMDFe, 'Falta tag "MDFe"');
        //[0] tag MDFe
        $this->dom->appendChild($this->MDFe);
        // testa da chave
        $this->checkMDFeKey($this->dom);
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
    public function taginfMDFe(stdClass $std)
    {
        $chave = preg_replace('/[^0-9]/', '', $std->Id);
        $this->infMDFe = $this->dom->createElement("infMDFe");
        $this->infMDFe->setAttribute("Id", 'MDFe' . $chave);
        $this->infMDFe->setAttribute("versao", $std->versao);
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
    public function tagide(stdClass $std)
    {
        $this->tpAmb = $std->tpAmb;
        if ($std->dhEmi == '') {
            $std->dhEmi = DateTime::convertTimestampToSefazTime();
        }
        if (empty($std->cDV)) {
            $std->cDV = 0;
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
    public function tagInfMunCarrega(stdClass $std)
    {
        if(empty($this->ide)){
            $this->ide = $this->dom->createElement("ide");
        }
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
        if ($this->ide->getElementsByTagName("infMunCarrega")->length > 0) {
            $node = $this->ide->getElementsByTagName("infMunCarrega")->item(0);
        }else{
            $node = $this->ide->getElementsByTagName("dhIniViagem")->item(0);
        }
        $this->ide->insertBefore($infMunCarrega, $node);
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
    public function tagInfPercurso(stdClass $std)
    {
        if(empty($this->ide)){
            $this->ide = $this->dom->createElement("ide");
        }
        $infPercurso = $this->dom->createElement("infPercurso");
        $this->dom->addChild(
            $infPercurso,
            "UFPer",
            $std->ufPer,
            true,
            "Sigla das Unidades da Federação do percurso"
        );
        if ($this->ide->getElementsByTagName("infPercurso")->length > 0) {
            $node = $this->ide->getElementsByTagName("infPercurso")->item(0);
        }else{
            $node = $this->ide->getElementsByTagName("dhIniViagem")->item(0);
        }
        $this->ide->insertBefore($infPercurso, $node);
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
    public function tagemit(stdClass $std)
    {
        $identificador = '[25] <emit> - ';
        $emit = $this->dom->createElement("emit");
        $this->dom->addChild(
            $emit,
            "CNPJ",
            $std->CNPJ,
            true,
            $identificador . "CNPJ do emitente"
        );
        $this->dom->addChild(
            $emit,
            "IE",
            $std->IE,
            true,
            $identificador . "Inscrição Estadual do emitente"
        );
        $this->dom->addChild(
            $emit,
            "xNome",
            $std->xNome,
            true,
            $identificador . "Razão Social ou Nome do emitente"
        );
        $this->dom->addChild(
            $emit,
            "xFant",
            $std->xFant,
            false,
            $identificador . "Nome fantasia do emitente"
        );
        $this->emit = $emit;
        return $emit;
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
        if(empty($this->emit)){
            $this->emit = $this->dom->createElement("emit");
        }
        $identificador = '[30] <enderEmit> - ';
        $enderEmit = $this->dom->createElement("enderEmit");
        $this->dom->addChild(
            $enderEmit,
            "xLgr",
            $std->xLgr,
            true,
            $identificador . "Logradouro do Endereço do emitente"
        );
        $this->dom->addChild(
            $enderEmit,
            "nro",
            $std->nro,
            true,
            $identificador . "Número do Endereço do emitente"
        );
        $this->dom->addChild(
            $enderEmit,
            "xCpl",
            $std->xCpl,
            false,
            $identificador . "Complemento do Endereço do emitente"
        );
        $this->dom->addChild(
            $enderEmit,
            "xBairro",
            $std->xBairro,
            true,
            $identificador . "Bairro do Endereço do emitente"
        );
        $this->dom->addChild(
            $enderEmit,
            "cMun",
            $std->cMun,
            true,
            $identificador . "Código do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $enderEmit,
            "xMun",
            $std->xMun,
            true,
            $identificador . "Nome do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $enderEmit,
            "CEP",
            $std->CEP,
            true,
            $identificador . "Código do CEP do Endereço do emitente"
        );
        $this->dom->addChild(
            $enderEmit,
            "UF",
            $std->UF,
            true,
            $identificador . "Sigla da UF do Endereço do emitente"
        );
        $this->dom->addChild(
            $enderEmit,
            "fone",
            $std->fone,
            false,
            $identificador . "Número de telefone do emitente"
        );
        $this->dom->addChild(
            $enderEmit,
            "email",
            $std->email,
            false,
            $identificador . "Endereço de email do emitente"
        );
        $this->emit->appendChild($enderEmit);
        $this->enderEmit = $enderEmit;
        return $enderEmit;
    }

    /**
     * tagInfModal
     * tag MDFe/infMDFe/infModal
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfModal(stdClass $std)
    {
        $infModal = $this->dom->createElement("infModal");
        $infModal->setAttribute("versaoModal", $std->versaoModal);
        $this->infModal = $infModal;
        return $infModal;
    }

    /**
     * tagRodo
     * tag MDFe/infMDFe/infModal/rodo
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagRodo(stdClass $std)
    {
        $rodo = $this->dom->createElement("rodo");
        $this->dom->addChild(
            $rodo,
            "codAgPorto",
            $std->codAgPorto,
            false,
            "Código de Agendamento no porto"
        );
        $this->rodo = $rodo;
        return $rodo;
    }

    /**
     * tagInfANTT
     * tag MDFe/infMDFe/infModal/rodo/infANTT
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfANTT(stdClass $std)
    {
        if (empty($this->rodo)) {
            $this->rodo = $this->dom->createElement("rodo");
        }
        $infANTT = $this->dom->createElement("infANTT");
        $this->dom->addChild(
            $infANTT,
            "RNTRC",
            $std->RNTRC,
            false,
            "Registro Nacional de Transportadores Rodoviários de Carga"
        );
        $this->rodo->insertBefore($infANTT);
        return $infANTT;
    }

    /**
     * tagInfCIOT
     * tag MDFe/infMDFe/infModal/rodo/infANTT/infCIOT
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfCIOT(stdClass $std)
    {
        $infCIOT = $this->dom->createElement("infCIOT");
        $this->dom->addChild(
            $infCIOT,
            "CIOT",
            $std->CIOT,
            false,
            "Código Identificador da Operação de Transporte"
        );
        $this->dom->addChild(
            $infCIOT,
            "CPF",
            $std->CPF,
            false,
            "Número do CPF responsável pela geração do CIOT"
        );
        $this->dom->addChild(
            $infCIOT,
            "CNPJ",
            $std->CNPJ,
            false,
            "Número do CNPJ responsável pela geração do CIOT"
        );
        $this->aInfCIOT[] = $infCIOT;
        return $infCIOT;
    }

    /**
     * tagDisp
     * tag MDFe/infMDFe/infModal/rodo/infANTT/valePed/disp
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagDisp(stdClass $std)
    {
        $disp = $this->dom->createElement("disp");
        $this->dom->addChild(
            $disp,
            "CNPJForn",
            $std->CNPJForn,
            false,
            "CNPJ da empresa fornecedora do Vale-Pedágio"
        );
        $this->dom->addChild(
            $disp,
            "CNPJPg",
            $std->CNPJPg,
            false,
            "CNPJ do responsável pelo pagamento do Vale-Pedágio"
        );
        $this->dom->addChild(
            $disp,
            "CPFPg",
            $std->CPFPg,
            false,
            "CNPJ do responsável pelo pagamento do Vale-Pedágio"
        );
        $this->dom->addChild(
            $disp,
            "nCompra",
            $std->nCompra,
            false,
            "Número do comprovante de compra"
        );
        $this->dom->addChild(
            $disp,
            "vValePed",
            $std->vValePed,
            false,
            "Valor do Vale-Pedagio"
        );
        $this->aDisp[] = $disp;
        return $disp;
    }

    /**
     * tagInfContratante
     * tag MDFe/infMDFe/infModal/rodo/infANTT/infContratante
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfContratante(stdClass $std)
    {
        $infContratante = $this->dom->createElement("infContratante");
        $this->dom->addChild(
            $infContratante,
            "CPF",
            $std->CPF,
            false,
            "Número do CPF do contratente do serviço"
        );
        $this->dom->addChild(
            $infContratante,
            "CNPJ",
            $std->CNPJ,
            false,
            "Número do CNPJ do contratante do serviço"
        );
        $this->aInfContratante[] = $infContratante;
        return $infContratante;
    }

    /**
     * tagVeicTracao
     * tag MDFe/infMDFe/infModal/rodo/veicTracao
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagVeicTracao(stdClass $std)
    {
        $veicTracao = $this->dom->createElement('veicTracao');
        $this->dom->addChild(
            $veicTracao,
            "cInt",
            $std->cInt,
            true,
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
            true,
            "RENAVAM do veículo"
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
            true,
            "Capacidade em KG"
        );
        $this->dom->addChild(
            $veicTracao,
            "capM3",
            $std->capM3,
            true,
            "Capacidade em M3"
        );
        $this->dom->addChild(
            $veicTracao,
            "tpRod",
            $std->tpRod,
            true,
            "Tipo de Rodado"
        );
        $this->dom->addChild(
            $veicTracao,
            "tpCar",
            $std->tpCar,
            true,
            "Tipo de Carroceria"
        );
        $this->dom->addChild(
            $veicTracao,
            "UF",
            $std->UF,
            true,
            "UF em que veículo está licenciado"
        );
        $this->veicTracao = $veicTracao;
        return $veicTracao;
    }

    /**
     * tagProp
     * tag MDFe/infMDFe/infModal/rodo/veicTracao/prop
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagPropVeicTracao(stdClass $std)
    {
        if (empty($this->veicTracao)) {
            $this->veicTracao = $this->dom->createElement('veicTracao');
        }
        $this->propVeicTracao = $this->dom->createElement(prop);
        $this->dom->addChild(
            $this->propVeicTracao,
            "CPF",
            $std->CPF,
            true,
            "Número do CPF"
        );
        $this->dom->addChild(
            $this->propVeicTracao,
            "CNPJ",
            $std->CNPJ,
            true,
            "Número do CNPJ"
        );
        $this->dom->addChild(
            $this->propVeicTracao,
            "RNTRC",
            $std->RNTRC,
            true,
            "Registro Nacional dos Transportadores Rodoviários de Carga"
        );
        $this->dom->addChild(
            $this->propVeicTracao,
            "xNome",
            $std->xNome,
            true,
            "Razão Social ou Nome do proprietário"
        );
        $this->dom->addChild(
            $this->propVeicTracao,
            "IE",
            $std->IE,
            true,
            "Inscrição Estadual"
        );
        $this->dom->addChild(
            $this->propVeicTracao,
            "UF",
            $std->UF,
            true,
            "UF"
        );
        $this->dom->addChild(
            $this->propVeicTracao,
            "tpProp",
            $std->tpProp,
            true,
            "Tipo Proprietário"
        );

        if ($this->veicTracao->getElementsByTagName("condutor")->length > 0) {
            $node = $this->veicTracao->getElementsByTagName("condutor")->item(0);
        }else{
            $node = $this->veicTracao->getElementsByTagName("tpRod")->item(0);
        }
        $this->veicTracao->insertBefore($this->propVeicTracao, $node);
        return $this->propVeicTracao;
    }

    /**
     * tagCondutor
     * tag MDFe/infMDFe/infModal/rodo/veicTracao/condutor
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagCondutor(stdClass $std)
    {
        $condutor = $this->dom->createElement("condutor");
        $this->dom->addChild(
            $condutor,
            "xNome",
            $std->xNome,
            true,
            "Nome do condutor"
        );
        $this->dom->addChild(
            $condutor,
            "CPF",
            $std->CPF,
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagVeicReboque(stdClass $std)
    {
        $reboque = $this->dom->createElement("veicReboque");
        $this->dom->addChild(
            $reboque,
            "cInt",
            $std->cInt,
            true,
            "Código interno do veículo"
        );
        $this->dom->addChild(
            $reboque,
            "placa",
            $std->placa,
            true,
            "Placa do veículo"
        );
        $this->dom->addChild(
            $reboque,
            "RENAVAM",
            $std->RENAVAM,
            true,
            "RENAVAM do veículo"
        );
        $this->dom->addChild(
            $reboque,
            "tara",
            $std->tara,
            true,
            "Tara em KG"
        );
        $this->dom->addChild(
            $reboque,
            "capKG",
            $std->capKG,
            true,
            "Capacidade em KG"
        );
        $this->dom->addChild(
            $reboque,
            "capM3",
            $std->capM3,
            true,
            "Capacidade em M3"
        );
        $this->dom->addChild(
            $reboque,
            "tpCar",
            $std->tpCar,
            true,
            "Tipo de Carroceria"
        );
        $this->dom->addChild(
            $reboque,
            "UF",
            $std->UF,
            true,
            "UF em que veículo está licenciado"
        );
        $this->aVeicReboque[$std->item] = $reboque;
        return $reboque;
    }

    /**
     * tagProp
     * tag MDFe/infMDFe/infModal/rodo/veicReboque/prop
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagPropVeicReboque(stdClass $std)
    {
        $propVeicReboque = $this->dom->createElement(prop);
        $this->dom->addChild(
            $propVeicReboque,
            "CPF",
            $std->CPF,
            true,
            "Número do CPF"
        );
        $this->dom->addChild(
            $propVeicReboque,
            "CNPJ",
            $std->CNPJ,
            true,
            "Número do CNPJ"
        );
        $this->dom->addChild(
            $propVeicReboque,
            "RNTRC",
            $std->RNTRC,
            true,
            "Registro Nacional dos Transportadores Rodoviários de Carga"
        );
        $this->dom->addChild(
            $propVeicReboque,
            "xNome",
            $std->xNome,
            true,
            "Razão Social ou Nome do proprietário"
        );
        $this->dom->addChild(
            $propVeicReboque,
            "IE",
            $std->IE,
            true,
            "Inscrição Estadual"
        );
        $this->dom->addChild(
            $propVeicReboque,
            "UF",
            $std->UF,
            true,
            "UF"
        );
        $this->dom->addChild(
            $propVeicReboque,
            "tpProp",
            $std->tpProp,
            true,
            "Tipo Proprietário"
        );
        $this->aPropVeicReboque[$std->item] = $propVeicReboque;
        return $propVeicReboque;
    }

    /**
     * tagLacRodo
     * tag MDFe/infMDFe/infModal/rodo/lacRodo
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagLacRodo(stdClass $std)
    {
        $lacre = $this->dom->createElement("lacRodo");
        $this->dom->addChild(
            $lacre,
            "nLacre",
            $std->nLacre,
            true,
            "Código interno do veículo"
        );
        $this->aLacRodo[] = $lacre;
        return $lacre;
    }

    /**
     * tagAereo
     * tag MDFe/infMDFe/infModal/aereo
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagAereo(stdClass $std)
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
     * tagAquav
     * tag MDFe/infMDFe/infModal/aquav
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagAquav(stdClass $std)
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
        $this->aquav = $aquav;
        return $aquav;
    }

    /**
     * tagInfTermCarreg
     * tag MDFe/infMDFe/infModal/aquav/infTermCarreg
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfTermCarreg(stdClass $std)
    {
        $infTermCarreg = $this->dom->createElement("infTermCarreg");
        $this->dom->addChild(
            $infTermCarreg,
            "cTermCarreg",
            $std->cTermCarreg,
            true,
            "Código do Terminal de Carregamento"
        );
        $this->dom->addChild(
            $infTermCarreg,
            "xTermCarreg",
            $std->xTermCarreg,
            true,
            "Nome do Terminal de Carregamento"
        );
        $this->aInfTermCarreg[] = $infTermCarreg;
        return $infTermCarreg;
    }

    /**
     * tagInfTermDescarreg
     * tag MDFe/infMDFe/infModal/aquav/infTermDescarreg
     *
     * @param  string $cTermDescarreg
     *
     * @return DOMElement
     */
    public function tagInfTermDescarreg(stdClass $std)
    {
        $infTermDescarreg = $this->dom->createElement("infTermDescarreg");
        $this->dom->addChild(
            $infTermDescarreg,
            "cTermDescarreg",
            $std->cTermDescarreg,
            true,
            "Código do Terminal de Descarregamento"
        );
        $this->dom->addChild(
            $infTermDescarreg,
            "xTermDescarreg",
            $std->xTermDescarreg,
            true,
            "Nome do Terminal de Descarregamento"
        );
        $this->aInfTermDescarreg[] = $infTermDescarreg;
        return $infTermDescarreg;
    }

    /**
     * tagInfEmbComb
     * tag MDFe/infMDFe/infModal/aquav/infEmbComb
     *
     * @param  string $cTermDescarreg
     *
     * @return DOMElement
     */
    public function tagInfEmbComb(stdClass $std)
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
     * tagInfUnidCargaVazia
     * tag MDFe/infMDFe/infModal/aquav/infUnidCargaVazia
     *
     * @param  string $cTermDescarreg
     *
     * @return DOMElement
     */
    public function tagInfUnidCargaVazia(stdClass $std)
    {
        $infUnidCargaVazia = $this->dom->createElement("infUnidCargaVazia");
        $this->dom->addChild(
            $infUnidCargaVazia,
            "idUnidCargaVazia",
            $std->idUnidCargaVazia,
            true,
            "Identificação da unidades de carga vazia"
        );
        $this->dom->addChild(
            $infUnidCargaVazia,
            "tpUnidCargaVazia",
            $std->tpUnidCargaVazia,
            true,
            "Tipo da unidade de carga vazia"
        );
        $this->aInfUnidCargaVazia[] = $infUnidCargaVazia;
        return $infUnidCargaVazia;
    }

    /**
     * tagInfUnidTranspVazia
     * tag MDFe/infMDFe/infModal/aquav/infUnidTranspVazia
     *
     * @param  string $cTermDescarreg
     *
     * @return DOMElement
     */
    public function tagInfUnidTranspVazia(stdClass $std)
    {
        $infUnidTranspVazia = $this->dom->createElement("infUnidTranspVazia");
        $this->dom->addChild(
            $infUnidTranspVazia,
            "idUnidTranspVazia",
            $std->idUnidTranspVazia,
            true,
            "Identificação da unidades de transporte vazia"
        );
        $this->dom->addChild(
            $infUnidTranspVazia,
            "tpUnidTranspVazia",
            $std->tpUnidTranspVazia,
            true,
            "Tipo da unidade de transporte vazia"
        );
        $this->aInfUnidTranspVazia[] = $infUnidTranspVazia;
        return $infUnidTranspVazia;
    }

    /**
     * tagTrem
     * tag MDFe/infMDFe/infModal/ferrov/trem
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagTrem(stdClass $std)
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
    public function tagVag(stdClass $std)
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
     * tagInfMunDescarga
     * tag MDFe/infMDFe/infDoc/infMunDescarga
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfMunDescarga(stdClass $std)
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
    public function tagInfCTe(stdClass $std)
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
    public function tagInfNFe(stdClass $std)
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
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfMDFeTransp(stdClass $std)
    {
        $infMDFeTransp = $this->dom->createElement("infMDFeTransp");
        $this->dom->addChild(
            $infMDFeTransp,
            "chMDFe",
            $std->chMDFe,
            true,
            "Chave de Acesso da MDFe"
        );
        $this->aInfMDFe[$std->nItem][] = $infMDFeTransp;
        return $infMDFeTransp;
    }

    /**
     * tagSeg
     * tag MDFe/infMDFe/seg
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagSeg(stdClass $std)
    {
        $this->buildSeg();
        $this->dom->addChild(
            $this->seg,
            "nApol",
            $std->nApol,
            false,
            "Número da Apólice"
        );
        $this->dom->addChild(
            $this->seg,
            "nAver",
            $std->nAver,
            false,
            "Número da Averbação"
        );

        return $this->seg;
    }

    /**
     * tagInfResp
     * tag MDFe/infMDFe/seg/infResp
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfResp(stdClass $std)
    {
        $this->buildSeg();
        $infResp = $this->dom->createElement("infResp");
        $this->dom->addChild(
            $infResp,
            "respSeg",
            $std->respSeg,
            false,
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
        $this->dom->appChild($this->seg, $infResp);
        return $infResp;
    }

    /**
     * tagInfSeg
     * tag MDFe/infMDFe/seg/taginfSeg
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagInfSeg(stdClass $std)
    {
        $this->buildSeg();
        $infSeg = $this->dom->createElement("infSeg");
        $this->dom->addChild(
            $infSeg,
            "xSeg",
            $std->xSeg,
            false,
            "Nome da Seguradora"
        );
        $this->dom->addChild(
            $infSeg,
            "CNPJ",
            $std->CNPJ,
            false,
            "Número do CNPJ da seguradora"
        );
        $this->dom->appChild($this->seg, $infSeg);
        return $infSeg;
    }

    /**
     * tagTot
     * tag MDFe/infMDFe/tot
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function tagTot(stdClass $std)
    {
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
    public function tagLacres(stdClass $std)
    {
        $lacres = $this->dom->createElement("lacres");
        $this->dom->addChild(
            $lacres,
            "nLacre",
            $std->nLacre,
            false,
            "Número do lacre"
        );
        $this->aLacres[] = $lacres;
        return $lacres;
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
    public function tagAutXML(stdClass $std)
    {
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
        $this->aAutXML[] = $autXML;
        return $autXML;
    }

    /**
     * taginfAdic
     * Grupo de Informações Adicionais
     * tag MDFe/infMDFe/infAdic (opcional)
     *
     * @param  stdClass $std
     * @return DOMElement
     */
    public function taginfAdic(stdClass $std)
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
     * Remonta a chave da NFe de 44 digitos com base em seus dados
     * já contidos na NFE.
     * Isso é útil no caso da chave informada estar errada
     * se a chave estiver errada a mesma é substituida
     * @param Dom $dom
     * @return void
     */
    protected function checkMDFeKey(Dom $dom)
    {
        $infMDFe = $dom->getElementsByTagName("infMDFe")->item(0);
        $ide = $dom->getElementsByTagName("ide")->item(0);
        $emit = $dom->getElementsByTagName("emit")->item(0);
        $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
        $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $cnpj = $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        $mod = $ide->getElementsByTagName('mod')->item(0)->nodeValue;
        $serie = $ide->getElementsByTagName('serie')->item(0)->nodeValue;
        $nMDF = $ide->getElementsByTagName('nMDF')->item(0)->nodeValue;
        $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $cMDF = $ide->getElementsByTagName('cMDF')->item(0)->nodeValue;
        $chave = str_replace('MDFe', '', $infMDFe->getAttribute("Id"));
        $dt = new DateTime($dhEmi);
        $chaveMontada = Keys::build(
            $cUF,
            $dt->format('y'),
            $dt->format('m'),
            $cnpj,
            $mod,
            $serie,
            $nMDF,
            $tpEmis,
            $cMDF
        );
        //caso a chave contida na NFe esteja errada
        //substituir a chave
        if ($chaveMontada != $chave) {
            //throw new RuntimeException("A chave informada é diferente da chave
            //mondata com os dados [correto: $chaveMontada].");
            $ide->getElementsByTagName('cDV')->item(0)->nodeValue = substr($chaveMontada, -1);
            $infMDFe = $dom->getElementsByTagName("infMDFe")->item(0);
            $infMDFe->setAttribute("Id", "MDFe" . $chaveMontada);
            $this->chMDFe = $chaveMontada;
        }
    }

    /**
     * Informações do modal
     * tag MDFe/infMDFe/InfModal/Rodo
     * Depende de infMunDescarga
     */
    protected function buildInfModal()
    {
        $this->buildRodo();
        $this->buildAereo();
        $this->buildAquav();
        $this->buildFerrov();
    }

    /**
     * Informações do modal Rodoviário
     * tag MDFe/infMDFe/InfModal/Rodo
     * Depende de infMunDescarga
     */
    protected function buildRodo()
    {
        //infCIOT
        if (isset($this->aInfCIOT)) {
            $this->dom->addArrayChild($this->rodo, $this->aInfCIOT);
        }

        //valePed
        $this->buildValePed();

        //infContratante
        if (isset($this->aInfContratante)) {
            $this->dom->addArrayChild($this->rodo, $this->aInfContratante);
        }

        //veicTracao
        $this->buildVeicTracao();

        //veicReboque
        $this->buildVeicReboque();

        //lacRodo
        if (isset($this->aLacRodo)) {
            $this->dom->addArrayChild($this->rodo, $this->aLacRodo);
        }

        $this->infModal->appendChild($this->rodo);
    }

    /**
     * Informações de Vale Pedágio
     * tag MDFe/infMDFe/InfModal/Rodo/infANTT/valePed
     * Depende de infMunDescarga
     */
    protected function buildValePed()
    {
        if (empty($this->aDisp)) {
            return '';
        }
        if (empty($this->valePed)) {
            $this->valePed = $this->dom->createElement("valePed");
        }

        //disp
        if (isset($this->aDisp)) {
            $this->dom->addArrayChild($this->valePed, $this->aDisp);
        }

        $this->rodo->appendChild($this->valePed);
    }

    /**
     * Dados do Veículo com a Tração
     * tag MDFe/infMDFe/InfModal/Rodo/infANTT/valePed
     * Depende de infMunDescarga
     */
    protected function buildVeicTracao()
    {
        if (empty($this->veicTracao)) {
            return '';
        }

        //ccondutor
        if (isset($this->aCondutor)) {
            $node = $this->veicTracao->getElementsByTagName("tpRod")->item(0);
            foreach ($this->aCondutor as $ccondutor){
                $this->veicTracao->insertBefore($ccondutor, $node);
            }
        }
        $this->rodo->appendChild($this->veicTracao);
    }

    /**
     * Dados dos reboques
     * tag MDFe/infMDFe/InfModal/Rodo/infANTT/valePed
     * Depende de infMunDescarga
     */
    protected function buildVeicReboque()
    {
        if (isset($this->aVeicReboque)) {
            foreach ($this->aVeicReboque as $nItem => $veicReboque){
                $node = $this->aVeicReboque[$nItem]->getElementsByTagName("tpCar")->item(0);
                $this->aVeicReboque[$nItem]->insertBefore($this->aPropVeicReboque[$nItem], $node);
                $this->rodo->appendChild($this->aVeicReboque[$nItem]);
            }
        }
    }

    /**
     * Informações do modal Aéreo
     * tag MDFe/infMDFe/InfModal/Rodo/Aereo
     * Depende de infMunDescarga
     */
    protected function buildAereo()
    {
        if (empty($this->aereo)) {
            return '';
        }
        $this->infModal->appendChild($this->aereo);
    }

    /**
     * Informações do modal Aquaviário
     * tag MDFe/infMDFe/InfModal/Rodo/Aquav
     * Depende de infMunDescarga
     */
    protected function buildAquav()
    {
        if (empty($this->aquav)) {
            return '';
        }

        //infTermCarreg
        if (isset($this->aInfTermCarreg)) {
            $this->dom->addArrayChild($this->aquav, $this->aInfTermCarreg);
        }

        //infTermDescarreg
        if (isset($this->aInfTermDescarreg)) {
            $this->dom->addArrayChild($this->aquav, $this->aInfTermDescarreg);
        }

        //infEmbComb
        if (isset($this->aInfEmbComb)) {
            $this->dom->addArrayChild($this->aquav, $this->aInfEmbComb);
        }

        //infUnidCargaVazia
        if (isset($this->aInfUnidCargaVazia)) {
            $this->dom->addArrayChild($this->aquav, $this->aInfUnidCargaVazia);
        }

        //infUnidTranspVazia
        if (isset($this->aInfUnidTranspVazia)) {
            $this->dom->addArrayChild($this->aquav, $this->aInfUnidTranspVazia);
        }

        $this->infModal->appendChild($this->aquav);
    }

    /**
     * Informações do modal Ferroviário
     * tag MDFe/infMDFe/InfModal/Rodo/Ferrov
     * Depende de infMunDescarga
     */
    protected function buildFerrov()
    {
        if (empty($this->ferrov) && !empty($this->trem)) {
            $this->ferrov = $this->dom->createElement("ferrov");
        }
        if (empty($this->ferrov) && !empty($this->vag)) {
            $this->ferrov = $this->dom->createElement("ferrov");
        }

        //trem
        if(!empty($this->trem)){
            $this->ferrov->appendChild($this->trem);
        }

        //vag
        if (isset($this->aVag)) {
            $this->dom->addArrayChild($this->ferrov, $this->aVag);
        }

        if(!empty($this->ferrov)){
            $this->infModal->appendChild($this->ferrov);
        }
    }

    /**
     * Informações dos Documentos fiscais vinculados ao manifesto
     * tag MDFe/infMDFe/infDoc
     * Depende de infMunDescarga
     */
    protected function buildInfDoc()
    {
        if (empty($this->aInfMunDescarga)) {
            return '';
        }

        if (empty($this->infDoc)) {
            $this->infDoc = $this->dom->createElement("infDoc");
        }

        foreach ($this->aInfMunDescarga as $nItem => $infMunDescarga) {

            //infCTe
            if (isset($this->aInfCTe[$nItem])) {
                $this->dom->addArrayChild($infMunDescarga, $this->aInfCTe[$nItem]);
            }

            //infNFe
            if (isset($this->aInfNFe[$nItem])) {
                $this->dom->addArrayChild($infMunDescarga, $this->aInfNFe[$nItem]);
            }

            $this->dom->appChild($this->infDoc, $infMunDescarga, "infDoc");
        }
    }

    /**
     * Informações de Seguro da Carga
     * tag MDFe/infMDFe/seg(opcional)
     * Depende de infResp, infSeg
     */
    protected function buildSeg()
    {
        if (empty($this->seg)) {
            $this->seg = $this->dom->createElement("seg");
        }
    }
}
