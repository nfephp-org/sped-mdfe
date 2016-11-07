<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType;

/**
 * Class representing InfPercursoType
 */
class InfPercursoType
{

    /**
     * Sigla das Unidades da Federação do percurso do veículo.Não é necessário
     * repetir as UF de Início e Fim
     *
     * @property string $UFPer
     */
    private $UFPer = null;

    /**
     * Gets as UFPer
     *
     * Sigla das Unidades da Federação do percurso do veículo.Não é necessário
     * repetir as UF de Início e Fim
     *
     * @return string
     */
    public function getUFPer()
    {
        return $this->UFPer;
    }

    /**
     * Sets a new UFPer
     *
     * Sigla das Unidades da Federação do percurso do veículo.Não é necessário
     * repetir as UF de Início e Fim
     *
     * @param string $UFPer
     * @return self
     */
    public function setUFPer($UFPer)
    {
        $this->UFPer = $UFPer;
        return $this;
    }
}
