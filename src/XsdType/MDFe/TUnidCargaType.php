<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing TUnidCargaType
 *
 * Tipo Dados Unidade de Carga
 * XSD Type: TUnidCarga
 */
class TUnidCargaType
{

    /**
     * Tipo da Unidade de Carga1 - Container;
     *
     * 2 - ULD;
     *
     * 3 - Pallet;
     *
     * 4 - Outros;
     *
     * @property string $tpUnidCarga
     */
    private $tpUnidCarga = null;

    /**
     * Identificação da Unidade de CargaInformar a identificação da unidade de
     * carga, por exemplo: número do container.
     *
     * @property string $idUnidCarga
     */
    private $idUnidCarga = null;

    /**
     * Lacres das Unidades de Carga
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TUnidCargaType\LacUnidCargaType[]
     * $lacUnidCarga
     */
    private $lacUnidCarga = null;

    /**
     * Quantidade rateada (Peso,Volume)
     *
     * @property string $qtdRat
     */
    private $qtdRat = null;

    /**
     * Gets as tpUnidCarga
     *
     * Tipo da Unidade de Carga1 - Container;
     *
     * 2 - ULD;
     *
     * 3 - Pallet;
     *
     * 4 - Outros;
     *
     * @return string
     */
    public function getTpUnidCarga()
    {
        return $this->tpUnidCarga;
    }

    /**
     * Sets a new tpUnidCarga
     *
     * Tipo da Unidade de Carga1 - Container;
     *
     * 2 - ULD;
     *
     * 3 - Pallet;
     *
     * 4 - Outros;
     *
     * @param string $tpUnidCarga
     * @return self
     */
    public function setTpUnidCarga($tpUnidCarga)
    {
        $this->tpUnidCarga = $tpUnidCarga;
        return $this;
    }

    /**
     * Gets as idUnidCarga
     *
     * Identificação da Unidade de CargaInformar a identificação da unidade de
     * carga, por exemplo: número do container.
     *
     * @return string
     */
    public function getIdUnidCarga()
    {
        return $this->idUnidCarga;
    }

    /**
     * Sets a new idUnidCarga
     *
     * Identificação da Unidade de CargaInformar a identificação da unidade de
     * carga, por exemplo: número do container.
     *
     * @param string $idUnidCarga
     * @return self
     */
    public function setIdUnidCarga($idUnidCarga)
    {
        $this->idUnidCarga = $idUnidCarga;
        return $this;
    }

    /**
     * Adds as lacUnidCarga
     *
     * Lacres das Unidades de Carga
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\MDFe\TUnidCargaType\LacUnidCargaType $lacUnidCarga
     */
    public function addToLacUnidCarga(\NFePHP\MDFe\XsdType\MDFe\TUnidCargaType\LacUnidCargaType $lacUnidCarga)
    {
        $this->lacUnidCarga[] = $lacUnidCarga;
        return $this;
    }

    /**
     * isset lacUnidCarga
     *
     * Lacres das Unidades de Carga
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetLacUnidCarga($index)
    {
        return isset($this->lacUnidCarga[$index]);
    }

    /**
     * unset lacUnidCarga
     *
     * Lacres das Unidades de Carga
     *
     * @param scalar $index
     * @return void
     */
    public function unsetLacUnidCarga($index)
    {
        unset($this->lacUnidCarga[$index]);
    }

    /**
     * Gets as lacUnidCarga
     *
     * Lacres das Unidades de Carga
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TUnidCargaType\LacUnidCargaType[]
     */
    public function getLacUnidCarga()
    {
        return $this->lacUnidCarga;
    }

    /**
     * Sets a new lacUnidCarga
     *
     * Lacres das Unidades de Carga
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TUnidCargaType\LacUnidCargaType[] $lacUnidCarga
     * @return self
     */
    public function setLacUnidCarga(array $lacUnidCarga)
    {
        $this->lacUnidCarga = $lacUnidCarga;
        return $this;
    }

    /**
     * Gets as qtdRat
     *
     * Quantidade rateada (Peso,Volume)
     *
     * @return string
     */
    public function getQtdRat()
    {
        return $this->qtdRat;
    }

    /**
     * Sets a new qtdRat
     *
     * Quantidade rateada (Peso,Volume)
     *
     * @param string $qtdRat
     * @return self
     */
    public function setQtdRat($qtdRat)
    {
        $this->qtdRat = $qtdRat;
        return $this;
    }
}
