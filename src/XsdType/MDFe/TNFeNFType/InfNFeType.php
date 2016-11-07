<?php

namespace NFePHP\MDFe\XsdType\MDFe\TNFeNFType;

/**
 * Class representing InfNFeType
 */
class InfNFeType
{

    /**
     * Chave de acesso da NF-e
     *
     * @property string $chNFe
     */
    private $chNFe = null;

    /**
     * PIN SUFRAMAPIN atribuído pela SUFRAMA para a operação.
     *
     * @property string $PIN
     */
    private $PIN = null;

    /**
     * Gets as chNFe
     *
     * Chave de acesso da NF-e
     *
     * @return string
     */
    public function getChNFe()
    {
        return $this->chNFe;
    }

    /**
     * Sets a new chNFe
     *
     * Chave de acesso da NF-e
     *
     * @param string $chNFe
     * @return self
     */
    public function setChNFe($chNFe)
    {
        $this->chNFe = $chNFe;
        return $this;
    }

    /**
     * Gets as PIN
     *
     * PIN SUFRAMAPIN atribuído pela SUFRAMA para a operação.
     *
     * @return string
     */
    public function getPIN()
    {
        return $this->PIN;
    }

    /**
     * Sets a new PIN
     *
     * PIN SUFRAMAPIN atribuído pela SUFRAMA para a operação.
     *
     * @param string $PIN
     * @return self
     */
    public function setPIN($PIN)
    {
        $this->PIN = $PIN;
        return $this;
    }
}
