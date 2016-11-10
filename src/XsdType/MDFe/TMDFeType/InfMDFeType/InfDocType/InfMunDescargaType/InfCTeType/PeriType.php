<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfCTeType;

/**
 * Class representing PeriType
 */
class PeriType
{

    /**
     * Número ONU/UNVer a legislação de transporte de produtos perigosos aplicadas
     * ao modal
     *
     * @property string $nONU
     */
    private $nONU = null;

    /**
     * Nome apropriado para embarque do produtoVer a legislação de transporte de
     * produtos perigosos aplicada ao modo de transporte
     *
     * @property string $xNomeAE
     */
    private $xNomeAE = null;

    /**
     * Classe ou subclasse/divisão, e risco subsidiário/risco secundárioVer a
     * legislação de transporte de produtos perigosos aplicadas ao modal
     *
     * @property string $xClaRisco
     */
    private $xClaRisco = null;

    /**
     * Grupo de EmbalagemVer a legislação de transporte de produtos perigosos
     * aplicadas ao modal
     *  Preenchimento obrigatório para o modal aéreo.
     *  A legislação para o modal rodoviário e ferroviário não atribui grupo de
     * embalagem para todos os produtos, portanto haverá casos de não preenchimento
     * desse campo.
     *
     * @property string $grEmb
     */
    private $grEmb = null;

    /**
     * Quantidade total por produtoPreencher conforme a legislação de transporte de
     * produtos perigosos aplicada ao modal
     *
     * @property string $qTotProd
     */
    private $qTotProd = null;

    /**
     * Quantidade e Tipo de volumesPreencher conforme a legislação de transporte de
     * produtos perigosos aplicada ao modal
     *
     * @property string $qVolTipo
     */
    private $qVolTipo = null;

    /**
     * Gets as nONU
     *
     * Número ONU/UNVer a legislação de transporte de produtos perigosos aplicadas
     * ao modal
     *
     * @return string
     */
    public function getNONU()
    {
        return $this->nONU;
    }

    /**
     * Sets a new nONU
     *
     * Número ONU/UNVer a legislação de transporte de produtos perigosos aplicadas
     * ao modal
     *
     * @param string $nONU
     * @return self
     */
    public function setNONU($nONU)
    {
        $this->nONU = $nONU;
        return $this;
    }

    /**
     * Gets as xNomeAE
     *
     * Nome apropriado para embarque do produtoVer a legislação de transporte de
     * produtos perigosos aplicada ao modo de transporte
     *
     * @return string
     */
    public function getXNomeAE()
    {
        return $this->xNomeAE;
    }

    /**
     * Sets a new xNomeAE
     *
     * Nome apropriado para embarque do produtoVer a legislação de transporte de
     * produtos perigosos aplicada ao modo de transporte
     *
     * @param string $xNomeAE
     * @return self
     */
    public function setXNomeAE($xNomeAE)
    {
        $this->xNomeAE = $xNomeAE;
        return $this;
    }

    /**
     * Gets as xClaRisco
     *
     * Classe ou subclasse/divisão, e risco subsidiário/risco secundárioVer a
     * legislação de transporte de produtos perigosos aplicadas ao modal
     *
     * @return string
     */
    public function getXClaRisco()
    {
        return $this->xClaRisco;
    }

    /**
     * Sets a new xClaRisco
     *
     * Classe ou subclasse/divisão, e risco subsidiário/risco secundárioVer a
     * legislação de transporte de produtos perigosos aplicadas ao modal
     *
     * @param string $xClaRisco
     * @return self
     */
    public function setXClaRisco($xClaRisco)
    {
        $this->xClaRisco = $xClaRisco;
        return $this;
    }

    /**
     * Gets as grEmb
     *
     * Grupo de EmbalagemVer a legislação de transporte de produtos perigosos
     * aplicadas ao modal
     *  Preenchimento obrigatório para o modal aéreo.
     *  A legislação para o modal rodoviário e ferroviário não atribui grupo de
     * embalagem para todos os produtos, portanto haverá casos de não preenchimento
     * desse campo.
     *
     * @return string
     */
    public function getGrEmb()
    {
        return $this->grEmb;
    }

    /**
     * Sets a new grEmb
     *
     * Grupo de EmbalagemVer a legislação de transporte de produtos perigosos
     * aplicadas ao modal
     *  Preenchimento obrigatório para o modal aéreo.
     *  A legislação para o modal rodoviário e ferroviário não atribui grupo de
     * embalagem para todos os produtos, portanto haverá casos de não preenchimento
     * desse campo.
     *
     * @param string $grEmb
     * @return self
     */
    public function setGrEmb($grEmb)
    {
        $this->grEmb = $grEmb;
        return $this;
    }

    /**
     * Gets as qTotProd
     *
     * Quantidade total por produtoPreencher conforme a legislação de transporte de
     * produtos perigosos aplicada ao modal
     *
     * @return string
     */
    public function getQTotProd()
    {
        return $this->qTotProd;
    }

    /**
     * Sets a new qTotProd
     *
     * Quantidade total por produtoPreencher conforme a legislação de transporte de
     * produtos perigosos aplicada ao modal
     *
     * @param string $qTotProd
     * @return self
     */
    public function setQTotProd($qTotProd)
    {
        $this->qTotProd = $qTotProd;
        return $this;
    }

    /**
     * Gets as qVolTipo
     *
     * Quantidade e Tipo de volumesPreencher conforme a legislação de transporte de
     * produtos perigosos aplicada ao modal
     *
     * @return string
     */
    public function getQVolTipo()
    {
        return $this->qVolTipo;
    }

    /**
     * Sets a new qVolTipo
     *
     * Quantidade e Tipo de volumesPreencher conforme a legislação de transporte de
     * produtos perigosos aplicada ao modal
     *
     * @param string $qVolTipo
     * @return self
     */
    public function setQVolTipo($qVolTipo)
    {
        $this->qVolTipo = $qVolTipo;
        return $this;
    }
}
