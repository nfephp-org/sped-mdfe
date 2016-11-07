<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing TEnviMDFeType
 *
 * Tipo Pedido de Concessão de Autorização de MDF-e
 * XSD Type: TEnviMDFe
 */
class TEnviMDFeType
{

    /**
     * @property string $versao
     */
    private $versao = null;

    /**
     * @property string $idLote
     */
    private $idLote = null;

    /**
     * @property \NFePHP\MDFe\XsdType\MDFe\TMDFeType $MDFe
     */
    private $MDFe = null;

    /**
     * Gets as versao
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
     * @param string $versao
     * @return self
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;
        return $this;
    }

    /**
     * Gets as idLote
     *
     * @return string
     */
    public function getIdLote()
    {
        return $this->idLote;
    }

    /**
     * Sets a new idLote
     *
     * @param string $idLote
     * @return self
     */
    public function setIdLote($idLote)
    {
        $this->idLote = $idLote;
        return $this;
    }

    /**
     * Gets as MDFe
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType
     */
    public function getMDFe()
    {
        return $this->MDFe;
    }

    /**
     * Sets a new MDFe
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType $MDFe
     * @return self
     */
    public function setMDFe(\NFePHP\MDFe\XsdType\MDFe\TMDFeType $MDFe)
    {
        $this->MDFe = $MDFe;
        return $this;
    }
}
