<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing TEndReEntType
 *
 * Tipo Dados do Local de Retirada ou Entrega
 * XSD Type: TEndReEnt
 */
class TEndReEntType
{

    /**
     * Número do CNPJ
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * Número do CPF
     *
     * @property string $CPF
     */
    private $CPF = null;

    /**
     * Razão Social ou Nome
     *
     * @property string $xNome
     */
    private $xNome = null;

    /**
     * Logradouro
     *
     * @property string $xLgr
     */
    private $xLgr = null;

    /**
     * Número
     *
     * @property string $nro
     */
    private $nro = null;

    /**
     * Complemento
     *
     * @property string $xCpl
     */
    private $xCpl = null;

    /**
     * Bairro
     *
     * @property string $xBairro
     */
    private $xBairro = null;

    /**
     * Código do município (utilizar a tabela do IBGE), informar 9999999 para
     * operações com o exterior.
     *
     * @property string $cMun
     */
    private $cMun = null;

    /**
     * Nome do município, , informar EXTERIOR para operações com o exterior.
     *
     * @property string $xMun
     */
    private $xMun = null;

    /**
     * Sigla da UF, , informar EX para operações com o exterior.
     *
     * @property string $UF
     */
    private $UF = null;

    /**
     * Gets as CNPJ
     *
     * Número do CNPJ
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
     * Número do CNPJ
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
     * Gets as CPF
     *
     * Número do CPF
     *
     * @return string
     */
    public function getCPF()
    {
        return $this->CPF;
    }

    /**
     * Sets a new CPF
     *
     * Número do CPF
     *
     * @param string $CPF
     * @return self
     */
    public function setCPF($CPF)
    {
        $this->CPF = $CPF;
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
     * Gets as xLgr
     *
     * Logradouro
     *
     * @return string
     */
    public function getXLgr()
    {
        return $this->xLgr;
    }

    /**
     * Sets a new xLgr
     *
     * Logradouro
     *
     * @param string $xLgr
     * @return self
     */
    public function setXLgr($xLgr)
    {
        $this->xLgr = $xLgr;
        return $this;
    }

    /**
     * Gets as nro
     *
     * Número
     *
     * @return string
     */
    public function getNro()
    {
        return $this->nro;
    }

    /**
     * Sets a new nro
     *
     * Número
     *
     * @param string $nro
     * @return self
     */
    public function setNro($nro)
    {
        $this->nro = $nro;
        return $this;
    }

    /**
     * Gets as xCpl
     *
     * Complemento
     *
     * @return string
     */
    public function getXCpl()
    {
        return $this->xCpl;
    }

    /**
     * Sets a new xCpl
     *
     * Complemento
     *
     * @param string $xCpl
     * @return self
     */
    public function setXCpl($xCpl)
    {
        $this->xCpl = $xCpl;
        return $this;
    }

    /**
     * Gets as xBairro
     *
     * Bairro
     *
     * @return string
     */
    public function getXBairro()
    {
        return $this->xBairro;
    }

    /**
     * Sets a new xBairro
     *
     * Bairro
     *
     * @param string $xBairro
     * @return self
     */
    public function setXBairro($xBairro)
    {
        $this->xBairro = $xBairro;
        return $this;
    }

    /**
     * Gets as cMun
     *
     * Código do município (utilizar a tabela do IBGE), informar 9999999 para
     * operações com o exterior.
     *
     * @return string
     */
    public function getCMun()
    {
        return $this->cMun;
    }

    /**
     * Sets a new cMun
     *
     * Código do município (utilizar a tabela do IBGE), informar 9999999 para
     * operações com o exterior.
     *
     * @param string $cMun
     * @return self
     */
    public function setCMun($cMun)
    {
        $this->cMun = $cMun;
        return $this;
    }

    /**
     * Gets as xMun
     *
     * Nome do município, , informar EXTERIOR para operações com o exterior.
     *
     * @return string
     */
    public function getXMun()
    {
        return $this->xMun;
    }

    /**
     * Sets a new xMun
     *
     * Nome do município, , informar EXTERIOR para operações com o exterior.
     *
     * @param string $xMun
     * @return self
     */
    public function setXMun($xMun)
    {
        $this->xMun = $xMun;
        return $this;
    }

    /**
     * Gets as UF
     *
     * Sigla da UF, , informar EX para operações com o exterior.
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
     * Sigla da UF, , informar EX para operações com o exterior.
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
