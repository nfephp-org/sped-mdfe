<?php

namespace NFePHP\MDFe\Factories;

/**
 * @author     Cleiton Perin <cperin20 at gmail dot com>
 * @package    NFePHP\MDFe\Factories
 * @copyright  Copyright (c) 2008-2019
 * @license    http://www.gnu.org/licenses/lesser.html LGPL v3
 * @category   NFePHP
 * @link       http://github.com/nfephp-org/nfephp for the canonical source repository
 */
class Header
{
    /**
     * Return header
     * @param string $namespace
     * @param string $cUF
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
