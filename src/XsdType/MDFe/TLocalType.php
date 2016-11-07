<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing TLocalType
 *
 * Tipo Dados do Local de Origem ou Destino
 * XSD Type: TLocal
 */
class TLocalType
{

    /**
     * Código do município (utilizar a tabela do IBGE)
     *
     * @property string $cMun
     */
    private $cMun = null;

    /**
     * Nome do município
     *
     * @property string $xMun
     */
    private $xMun = null;

    /**
     * Sigla da UF
     *
     * @property string $UF
     */
    private $UF = null;

    /**
     * Gets as cMun
     *
     * Código do município (utilizar a tabela do IBGE)
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
     * Código do município (utilizar a tabela do IBGE)
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
     * Nome do município
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
     * Nome do município
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
     * Sigla da UF
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
     * Sigla da UF
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
