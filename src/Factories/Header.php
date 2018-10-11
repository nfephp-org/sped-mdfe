<?php

namespace NFePHP\MDFe\Factories;


class Header
{
    /**
     * Return header
     * @param string $namespace
     * @param int $cUF
     * @param string $version
     * @return string
     */
    public static function get($namespace, $cUF, $version)
    {
        return "<mdfeCabecMsg "
            . "xmlns=\"$namespace\">"
            . "<cUF>$cUF</cUF>"
            . "<versaoDados>$version</versaoDados>"
            . "</mdfeCabecMsg>";
    }
}