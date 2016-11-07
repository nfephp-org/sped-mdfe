<?php

namespace NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType;

/**
 * Class representing EmiType
 */
class EmiType
{

    /**
     * CNPJ do emitente
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * Razão Social ou Nome
     *
     * @property string $xNome
     */
    private $xNome = null;

    /**
     * UF do EmitenteInformar 'EX' para operações com o exterior.
     *
     * @property string $UF
     */
    private $UF = null;

    /**
     * Gets as CNPJ
     *
     * CNPJ do emitente
     *
     * @return string
     */
    public function getCNPJ()
    {
        return $this->CNPJ;
    }

    /**
     * Sets a new CNPJ
     *
     * CNPJ do emitente
     *
     * @param string $CNPJ
     * @return self
     */
    public function setCNPJ($CNPJ)
    {
        $this->CNPJ = $CNPJ;
        return $this;
    }

    /**
     * Gets as xNome
     *
     * Razão Social ou Nome
     *
     * @return string
     */
    public function getXNome()
    {
        return $this->xNome;
    }

    /**
     * Sets a new xNome
     *
     * Razão Social ou Nome
     *
     * @param string $xNome
     * @return self
     */
    public function setXNome($xNome)
    {
        $this->xNome = $xNome;
        return $this;
    }

    /**
     * Gets as UF
     *
     * UF do EmitenteInformar 'EX' para operações com o exterior.
     *
     * @return string
     */
    public function getUF()
    {
        return $this->UF;
    }

    /**
     * Sets a new UF
     *
     * UF do EmitenteInformar 'EX' para operações com o exterior.
     *
     * @param string $UF
     * @return self
     */
    public function setUF($UF)
    {
        $this->UF = $UF;
        return $this;
    }
}
