<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType\InfMunCarregaType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType\InfPercursoType;

/**
 * Class representing IdeType
 */
class IdeType
{

    /**
     * Código da UF do emitente do MDF-eCódigo da UF do emitente do Documento Fiscal.
     * Utilizar a
     * Tabela do IBGE de código de unidades da federação.
     *
     * @property string $cUF
     */
    private $cUF = null;

    /**
     * Tipo do Ambiente1 - Produção
     * 2 - Homologação
     *
     * @property string $tpAmb
     */
    private $tpAmb = null;

    /**
     * Tipo do Emitente
     * 1 - Prestador de serviço de transporte
     * 2 - Transportador de Carga Própria
     * OBS: Deve ser preenchido com 2 para emitentes de NF-e e pelas transportadoras
     * quando estiverem fazendo transporte de carga própria
     *
     * @property string $tpEmit
     */
    private $tpEmit = null;

    /**
     * Tipo do Transportador1 - ETC
     *
     * 2 - TAC
     *
     * 3 - CTC
     *
     * @property string $tpTransp
     */
    private $tpTransp = null;

    /**
     * Modelo do Manifesto EletrônicoUtilizar o código 58 para identificação do
     * MDF-e
     *
     * @property string $mod
     */
    private $mod = null;

    /**
     * Série do ManifestoInformar a série do documento fiscal (informar zero se
     * inexistente).
     *
     * @property string $serie
     */
    private $serie = null;

    /**
     * Número do ManifestoNúmero que identifica o Manifesto. 1 a 999999999.
     *
     * @property string $nMDF
     */
    private $nMDF = null;

    /**
     * Código numérico que compõe a Chave de Acesso. Código aleatório gerado pelo
     * emitente, com o objetivo de evitar acessos indevidos ao documento.
     *
     * @property string $cMDF
     */
    private $cMDF = null;

    /**
     * Digito verificador da chave de acesso do ManifestoInformar o dígito de controle
     * da chave de acesso do MDF-e, que deve ser calculado com a aplicação do
     * algoritmo módulo 11 (base 2,9) da chave de acesso.
     *
     * @property string $cDV
     */
    private $cDV = null;

    /**
     * Modalidade de transporte1 - Rodoviário;
     * 2 - Aéreo; 3 - Aquaviário; 4 - Ferroviário.
     *
     * @property string $modal
     */
    private $modal = null;

    /**
     * Data e hora de emissão do ManifestoFormato AAAA-MM-DDTHH:MM:DD TZD
     *
     * @property string $dhEmi
     */
    private $dhEmi = null;

    /**
     * Forma de emissão do Manifesto (Normal ou Contingência)1 - Normal
     * ; 2 - Contingência
     *
     * @property string $tpEmis
     */
    private $tpEmis = null;

    /**
     * Identificação do processo de emissão do Manifesto0 - emissão de MDF-e com
     * aplicativo do contribuinte;
     * 3- emissão MDF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
     *
     * @property string $procEmi
     */
    private $procEmi = null;

    /**
     * Versão do processo de emissãoInformar a versão do aplicativo emissor de
     * MDF-e.
     *
     * @property string $verProc
     */
    private $verProc = null;

    /**
     * Sigla da UF do CarregamentoUtilizar a Tabela do IBGE de código de unidades da
     * federação.
     * Informar 'EX' para operações com o exterior.
     *
     * @property string $UFIni
     */
    private $UFIni = null;

    /**
     * Sigla da UF do DescarregamentoUtilizar a Tabela do IBGE de código de unidades
     * da federação.
     * Informar 'EX' para operações com o exterior.
     *
     * @property string $UFFim
     */
    private $UFFim = null;

    /**
     * Informações dos Municípios de Carregamento
     *
     * @property InfMunCarregaType[] $infMunCarrega
     */
    private $infMunCarrega = null;

    /**
     * Informações do Percurso do MDF-e
     *
     * @property InfPercursoType[] $infPercurso
     */
    private $infPercurso = null;

    /**
     * Data e hora previstos de inicio da viagemFormato AAAA-MM-DDTHH:MM:DD TZD
     *
     * @property string $dhIniViagem
     */
    private $dhIniViagem = null;

    /**
     * Gets as cUF
     *
     * Código da UF do emitente do MDF-eCódigo da UF do emitente do Documento Fiscal.
     * Utilizar a
     * Tabela do IBGE de código de unidades da federação.
     *
     * @return string
     */
    public function getCUF()
    {
        return $this->cUF;
    }

    /**
     * Sets a new cUF
     *
     * Código da UF do emitente do MDF-eCódigo da UF do emitente do Documento Fiscal.
     * Utilizar a
     * Tabela do IBGE de código de unidades da federação.
     *
     * @param string $cUF
     * @return self
     */
    public function setCUF($cUF)
    {
        $this->cUF = $cUF;
        return $this;
    }

    /**
     * Gets as tpAmb
     *
     * Tipo do Ambiente1 - Produção
     * 2 - Homologação
     *
     * @return string
     */
    public function getTpAmb()
    {
        return $this->tpAmb;
    }

    /**
     * Sets a new tpAmb
     *
     * Tipo do Ambiente1 - Produção
     * 2 - Homologação
     *
     * @param string $tpAmb
     * @return self
     */
    public function setTpAmb($tpAmb)
    {
        $this->tpAmb = $tpAmb;
        return $this;
    }

    /**
     * Gets as tpEmit
     *
     * Tipo do Emitente
     * 1 - Prestador de serviço de transporte
     * 2 - Transportador de Carga Própria
     * OBS: Deve ser preenchido com 2 para emitentes de NF-e e pelas transportadoras
     * quando estiverem fazendo transporte de carga própria
     *
     * @return string
     */
    public function getTpEmit()
    {
        return $this->tpEmit;
    }

    /**
     * Sets a new tpEmit
     *
     * Tipo do Emitente
     * 1 - Prestador de serviço de transporte
     * 2 - Transportador de Carga Própria
     * OBS: Deve ser preenchido com 2 para emitentes de NF-e e pelas transportadoras
     * quando estiverem fazendo transporte de carga própria
     *
     * @param string $tpEmit
     * @return self
     */
    public function setTpEmit($tpEmit)
    {
        $this->tpEmit = $tpEmit;
        return $this;
    }

    /**
     * Gets as tpTransp
     *
     * Tipo do Transportador1 - ETC
     *
     * 2 - TAC
     *
     * 3 - CTC
     *
     * @return string
     */
    public function getTpTransp()
    {
        return $this->tpTransp;
    }

    /**
     * Sets a new tpTransp
     *
     * Tipo do Transportador1 - ETC
     *
     * 2 - TAC
     *
     * 3 - CTC
     *
     * @param string $tpTransp
     * @return self
     */
    public function setTpTransp($tpTransp)
    {
        $this->tpTransp = $tpTransp;
        return $this;
    }

    /**
     * Gets as mod
     *
     * Modelo do Manifesto EletrônicoUtilizar o código 58 para identificação do
     * MDF-e
     *
     * @return string
     */
    public function getMod()
    {
        return $this->mod;
    }

    /**
     * Sets a new mod
     *
     * Modelo do Manifesto EletrônicoUtilizar o código 58 para identificação do
     * MDF-e
     *
     * @param string $mod
     * @return self
     */
    public function setMod($mod)
    {
        $this->mod = $mod;
        return $this;
    }

    /**
     * Gets as serie
     *
     * Série do ManifestoInformar a série do documento fiscal (informar zero se
     * inexistente).
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Sets a new serie
     *
     * Série do ManifestoInformar a série do documento fiscal (informar zero se
     * inexistente).
     *
     * @param string $serie
     * @return self
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * Gets as nMDF
     *
     * Número do ManifestoNúmero que identifica o Manifesto. 1 a 999999999.
     *
     * @return string
     */
    public function getNMDF()
    {
        return $this->nMDF;
    }

    /**
     * Sets a new nMDF
     *
     * Número do ManifestoNúmero que identifica o Manifesto. 1 a 999999999.
     *
     * @param string $nMDF
     * @return self
     */
    public function setNMDF($nMDF)
    {
        $this->nMDF = $nMDF;
        return $this;
    }

    /**
     * Gets as cMDF
     *
     * Código numérico que compõe a Chave de Acesso. Código aleatório gerado pelo
     * emitente, com o objetivo de evitar acessos indevidos ao documento.
     *
     * @return string
     */
    public function getCMDF()
    {
        return $this->cMDF;
    }

    /**
     * Sets a new cMDF
     *
     * Código numérico que compõe a Chave de Acesso. Código aleatório gerado pelo
     * emitente, com o objetivo de evitar acessos indevidos ao documento.
     *
     * @param string $cMDF
     * @return self
     */
    public function setCMDF($cMDF)
    {
        $this->cMDF = $cMDF;
        return $this;
    }

    /**
     * Gets as cDV
     *
     * Digito verificador da chave de acesso do ManifestoInformar o dígito de controle
     * da chave de acesso do MDF-e, que deve ser calculado com a aplicação do
     * algoritmo módulo 11 (base 2,9) da chave de acesso.
     *
     * @return string
     */
    public function getCDV()
    {
        return $this->cDV;
    }

    /**
     * Sets a new cDV
     *
     * Digito verificador da chave de acesso do ManifestoInformar o dígito de controle
     * da chave de acesso do MDF-e, que deve ser calculado com a aplicação do
     * algoritmo módulo 11 (base 2,9) da chave de acesso.
     *
     * @param string $cDV
     * @return self
     */
    public function setCDV($cDV)
    {
        $this->cDV = $cDV;
        return $this;
    }

    /**
     * Gets as modal
     *
     * Modalidade de transporte1 - Rodoviário;
     * 2 - Aéreo; 3 - Aquaviário; 4 - Ferroviário.
     *
     * @return string
     */
    public function getModal()
    {
        return $this->modal;
    }

    /**
     * Sets a new modal
     *
     * Modalidade de transporte1 - Rodoviário;
     * 2 - Aéreo; 3 - Aquaviário; 4 - Ferroviário.
     *
     * @param string $modal
     * @return self
     */
    public function setModal($modal)
    {
        $this->modal = $modal;
        return $this;
    }

    /**
     * Gets as dhEmi
     *
     * Data e hora de emissão do ManifestoFormato AAAA-MM-DDTHH:MM:DD TZD
     *
     * @return string
     */
    public function getDhEmi()
    {
        return $this->dhEmi;
    }

    /**
     * Sets a new dhEmi
     *
     * Data e hora de emissão do ManifestoFormato AAAA-MM-DDTHH:MM:DD TZD
     *
     * @param string $dhEmi
     * @return self
     */
    public function setDhEmi($dhEmi)
    {
        $this->dhEmi = $dhEmi;
        return $this;
    }

    /**
     * Gets as tpEmis
     *
     * Forma de emissão do Manifesto (Normal ou Contingência)1 - Normal
     * ; 2 - Contingência
     *
     * @return string
     */
    public function getTpEmis()
    {
        return $this->tpEmis;
    }

    /**
     * Sets a new tpEmis
     *
     * Forma de emissão do Manifesto (Normal ou Contingência)1 - Normal
     * ; 2 - Contingência
     *
     * @param string $tpEmis
     * @return self
     */
    public function setTpEmis($tpEmis)
    {
        $this->tpEmis = $tpEmis;
        return $this;
    }

    /**
     * Gets as procEmi
     *
     * Identificação do processo de emissão do Manifesto0 - emissão de MDF-e com
     * aplicativo do contribuinte;
     * 3- emissão MDF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
     *
     * @return string
     */
    public function getProcEmi()
    {
        return $this->procEmi;
    }

    /**
     * Sets a new procEmi
     *
     * Identificação do processo de emissão do Manifesto0 - emissão de MDF-e com
     * aplicativo do contribuinte;
     * 3- emissão MDF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
     *
     * @param string $procEmi
     * @return self
     */
    public function setProcEmi($procEmi)
    {
        $this->procEmi = $procEmi;
        return $this;
    }

    /**
     * Gets as verProc
     *
     * Versão do processo de emissãoInformar a versão do aplicativo emissor de
     * MDF-e.
     *
     * @return string
     */
    public function getVerProc()
    {
        return $this->verProc;
    }

    /**
     * Sets a new verProc
     *
     * Versão do processo de emissãoInformar a versão do aplicativo emissor de
     * MDF-e.
     *
     * @param string $verProc
     * @return self
     */
    public function setVerProc($verProc)
    {
        $this->verProc = $verProc;
        return $this;
    }

    /**
     * Gets as UFIni
     *
     * Sigla da UF do CarregamentoUtilizar a Tabela do IBGE de código de unidades da
     * federação.
     * Informar 'EX' para operações com o exterior.
     *
     * @return string
     */
    public function getUFIni()
    {
        return $this->UFIni;
    }

    /**
     * Sets a new UFIni
     *
     * Sigla da UF do CarregamentoUtilizar a Tabela do IBGE de código de unidades da
     * federação.
     * Informar 'EX' para operações com o exterior.
     *
     * @param string $UFIni
     * @return self
     */
    public function setUFIni($UFIni)
    {
        $this->UFIni = $UFIni;
        return $this;
    }

    /**
     * Gets as UFFim
     *
     * Sigla da UF do DescarregamentoUtilizar a Tabela do IBGE de código de unidades
     * da federação.
     * Informar 'EX' para operações com o exterior.
     *
     * @return string
     */
    public function getUFFim()
    {
        return $this->UFFim;
    }

    /**
     * Sets a new UFFim
     *
     * Sigla da UF do DescarregamentoUtilizar a Tabela do IBGE de código de unidades
     * da federação.
     * Informar 'EX' para operações com o exterior.
     *
     * @param string $UFFim
     * @return self
     */
    public function setUFFim($UFFim)
    {
        $this->UFFim = $UFFim;
        return $this;
    }

    /**
     * Adds as infMunCarrega
     *
     * Informações dos Municípios de Carregamento
     *
     * @return self
     * @param InfMunCarregaType $infMunCarrega
     */
    public function addToInfMunCarrega(InfMunCarregaType $infMunCarrega)
    {
        $this->infMunCarrega[] = $infMunCarrega;
        return $this;
    }

    /**
     * isset infMunCarrega
     *
     * Informações dos Municípios de Carregamento
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfMunCarrega($index)
    {
        return isset($this->infMunCarrega[$index]);
    }

    /**
     * unset infMunCarrega
     *
     * Informações dos Municípios de Carregamento
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfMunCarrega($index)
    {
        unset($this->infMunCarrega[$index]);
    }

    /**
     * Gets as infMunCarrega
     *
     * Informações dos Municípios de Carregamento
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType\InfMunCarregaType[]
     */
    public function getInfMunCarrega()
    {
        return $this->infMunCarrega;
    }

    /**
     * Sets a new infMunCarrega
     *
     * Informações dos Municípios de Carregamento
     *
     * @param InfMunCarregaType[] $infMunCarrega
     * @return self
     */
    public function setInfMunCarrega(array $infMunCarrega)
    {
        $this->infMunCarrega = $infMunCarrega;
        return $this;
    }

    /**
     * Adds as infPercurso
     *
     * Informações do Percurso do MDF-e
     *
     * @return self
     * @param InfPercursoType $infPercurso
     */
    public function addToInfPercurso(InfPercursoType $infPercurso)
    {
        $this->infPercurso[] = $infPercurso;
        return $this;
    }

    /**
     * isset infPercurso
     *
     * Informações do Percurso do MDF-e
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfPercurso($index)
    {
        return isset($this->infPercurso[$index]);
    }

    /**
     * unset infPercurso
     *
     * Informações do Percurso do MDF-e
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfPercurso($index)
    {
        unset($this->infPercurso[$index]);
    }

    /**
     * Gets as infPercurso
     *
     * Informações do Percurso do MDF-e
     *
     * @return InfPercursoType[]
     */
    public function getInfPercurso()
    {
        return $this->infPercurso;
    }

    /**
     * Sets a new infPercurso
     *
     * Informações do Percurso do MDF-e
     *
     * @param InfPercursoType[] $infPercurso
     * @return self
     */
    public function setInfPercurso(array $infPercurso)
    {
        $this->infPercurso = $infPercurso;
        return $this;
    }

    /**
     * Gets as dhIniViagem
     *
     * Data e hora previstos de inicio da viagemFormato AAAA-MM-DDTHH:MM:DD TZD
     *
     * @return string
     */
    public function getDhIniViagem()
    {
        return $this->dhIniViagem;
    }

    /**
     * Sets a new dhIniViagem
     *
     * Data e hora previstos de inicio da viagemFormato AAAA-MM-DDTHH:MM:DD TZD
     *
     * @param string $dhIniViagem
     * @return self
     */
    public function setDhIniViagem($dhIniViagem)
    {
        $this->dhIniViagem = $dhIniViagem;
        return $this;
    }
}
