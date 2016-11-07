<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType;

/**
 * Class representing InfMDFeType
 */
class InfMDFeType
{

    /**
     * Versão do leiauteEx: "3.00"
     *
     * @property string $versao
     */
    private $versao = null;

    /**
     * Identificador da tag a ser assinadaInformar a chave de acesso do MDF-e e
     * precedida do literal "MDFe"
     *
     * @property string $Id
     */
    private $Id = null;

    /**
     * Identificação do MDF-e
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType $ide
     */
    private $ide = null;

    /**
     * Identificação do Emitente do Manifesto
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\EmitType $emit
     */
    private $emit = null;

    /**
     * Informações do modal
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfModalType $infModal
     */
    private $infModal = null;

    /**
     * Informações dos Documentos fiscais vinculados ao manifesto
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType $infDoc
     */
    private $infDoc;

    /**
     * Informações de Seguro da Carga
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\SegType[] $seg
     */
    private $seg = null;

    /**
     * Totalizadores da carga transportada e seus documentos fiscais
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\TotType $tot
     */
    private $tot = null;

    /**
     * Lacres do MDF-ePreechimento opcional para os modais Rodoviário e Ferroviário
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\LacresType[] $lacres
     */
    private $lacres = null;

    /**
     * Autorizados para download do XML do DF-eInformar CNPJ ou CPF. Preencher os zeros
     * não significativos.
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\AutXMLType[] $autXML
     */
    private $autXML = null;

    /**
     * Informações Adicionais
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfAdicType $infAdic
     */
    private $infAdic = null;

    /**
     * Gets as versao
     *
     * Versão do leiauteEx: "3.00"
     *
     * @return string
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Sets a new versao
     *
     * Versão do leiauteEx: "3.00"
     *
     * @param string $versao
     * @return self
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;
        return $this;
    }

    /**
     * Gets as Id
     *
     * Identificador da tag a ser assinadaInformar a chave de acesso do MDF-e e
     * precedida do literal "MDFe"
     *
     * @return string
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * Sets a new Id
     *
     * Identificador da tag a ser assinadaInformar a chave de acesso do MDF-e e
     * precedida do literal "MDFe"
     *
     * @param string $Id
     * @return self
     */
    public function setId($Id)
    {
        $this->Id = $Id;
        return $this;
    }

    /**
     * Gets as ide
     *
     * Identificação do MDF-e
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType
     */
    public function getIde()
    {
        return $this->ide;
    }

    /**
     * Sets a new ide
     *
     * Identificação do MDF-e
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType $ide
     * @return self
     */
    public function setIde(\NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType $ide)
    {
        $this->ide = $ide;
        return $this;
    }

    /**
     * Gets as emit
     *
     * Identificação do Emitente do Manifesto
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\EmitType
     */
    public function getEmit()
    {
        return $this->emit;
    }

    /**
     * Sets a new emit
     *
     * Identificação do Emitente do Manifesto
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\EmitType $emit
     * @return self
     */
    public function setEmit(\NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\EmitType $emit)
    {
        $this->emit = $emit;
        return $this;
    }

    /**
     * Gets as infModal
     *
     * Informações do modal
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfModalType
     */
    public function getInfModal()
    {
        return $this->infModal;
    }

    /**
     * Sets a new infModal
     *
     * Informações do modal
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfModalType $infModal
     * @return self
     */
    public function setInfModal(\NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfModalType $infModal)
    {
        $this->infModal = $infModal;
        return $this;
    }

    /**
     * Gets as infDoc
     *
     * Informações dos Documentos fiscais vinculados ao manifesto
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType
     */
    public function getInfDoc()
    {
        return $this->infDoc;
    }

    /**
     * Sets a new infDoc
     *
     * Informações dos Documentos fiscais vinculados ao manifesto
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType $infDoc
     * @return self
     */
    public function setInfDoc(\NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType $infDoc)
    {
        $this->infDoc = $infDoc;
        return $this;
    }

    /**
     * Adds as seg
     *
     * Informações de Seguro da Carga
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\SegType $seg
     */
    public function addToSeg(\NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\SegType $seg)
    {
        $this->seg[] = $seg;
        return $this;
    }

    /**
     * isset seg
     *
     * Informações de Seguro da Carga
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSeg($index)
    {
        return isset($this->seg[$index]);
    }

    /**
     * unset seg
     *
     * Informações de Seguro da Carga
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSeg($index)
    {
        unset($this->seg[$index]);
    }

    /**
     * Gets as seg
     *
     * Informações de Seguro da Carga
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\SegType[]
     */
    public function getSeg()
    {
        return $this->seg;
    }

    /**
     * Sets a new seg
     *
     * Informações de Seguro da Carga
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\SegType[] $seg
     * @return self
     */
    public function setSeg(array $seg)
    {
        $this->seg = $seg;
        return $this;
    }

    /**
     * Gets as tot
     *
     * Totalizadores da carga transportada e seus documentos fiscais
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\TotType
     */
    public function getTot()
    {
        return $this->tot;
    }

    /**
     * Sets a new tot
     *
     * Totalizadores da carga transportada e seus documentos fiscais
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\TotType $tot
     * @return self
     */
    public function setTot(\NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\TotType $tot)
    {
        $this->tot = $tot;
        return $this;
    }

    /**
     * Adds as lacres
     *
     * Lacres do MDF-ePreechimento opcional para os modais Rodoviário e Ferroviário
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\LacresType $lacres
     */
    public function addToLacres(\NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\LacresType $lacres)
    {
        $this->lacres[] = $lacres;
        return $this;
    }

    /**
     * isset lacres
     *
     * Lacres do MDF-ePreechimento opcional para os modais Rodoviário e Ferroviário
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetLacres($index)
    {
        return isset($this->lacres[$index]);
    }

    /**
     * unset lacres
     *
     * Lacres do MDF-ePreechimento opcional para os modais Rodoviário e Ferroviário
     *
     * @param scalar $index
     * @return void
     */
    public function unsetLacres($index)
    {
        unset($this->lacres[$index]);
    }

    /**
     * Gets as lacres
     *
     * Lacres do MDF-ePreechimento opcional para os modais Rodoviário e Ferroviário
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\LacresType[]
     */
    public function getLacres()
    {
        return $this->lacres;
    }

    /**
     * Sets a new lacres
     *
     * Lacres do MDF-ePreechimento opcional para os modais Rodoviário e Ferroviário
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\LacresType[] $lacres
     * @return self
     */
    public function setLacres(array $lacres)
    {
        $this->lacres = $lacres;
        return $this;
    }

    /**
     * Adds as autXML
     *
     * Autorizados para download do XML do DF-eInformar CNPJ ou CPF. Preencher os zeros
     * não significativos.
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\AutXMLType $autXML
     */
    public function addToAutXML(\NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\AutXMLType $autXML)
    {
        $this->autXML[] = $autXML;
        return $this;
    }

    /**
     * isset autXML
     *
     * Autorizados para download do XML do DF-eInformar CNPJ ou CPF. Preencher os zeros
     * não significativos.
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetAutXML($index)
    {
        return isset($this->autXML[$index]);
    }

    /**
     * unset autXML
     *
     * Autorizados para download do XML do DF-eInformar CNPJ ou CPF. Preencher os zeros
     * não significativos.
     *
     * @param scalar $index
     * @return void
     */
    public function unsetAutXML($index)
    {
        unset($this->autXML[$index]);
    }

    /**
     * Gets as autXML
     *
     * Autorizados para download do XML do DF-eInformar CNPJ ou CPF. Preencher os zeros
     * não significativos.
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\AutXMLType[]
     */
    public function getAutXML()
    {
        return $this->autXML;
    }

    /**
     * Sets a new autXML
     *
     * Autorizados para download do XML do DF-eInformar CNPJ ou CPF. Preencher os zeros
     * não significativos.
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\AutXMLType[] $autXML
     * @return self
     */
    public function setAutXML(array $autXML)
    {
        $this->autXML = $autXML;
        return $this;
    }

    /**
     * Gets as infAdic
     *
     * Informações Adicionais
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfAdicType
     */
    public function getInfAdic()
    {
        return $this->infAdic;
    }

    /**
     * Sets a new infAdic
     *
     * Informações Adicionais
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfAdicType $infAdic
     * @return self
     */
    public function setInfAdic(\NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfAdicType $infAdic)
    {
        $this->infAdic = $infAdic;
        return $this;
    }
}
