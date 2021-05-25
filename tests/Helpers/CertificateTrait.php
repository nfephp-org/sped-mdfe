<?php

namespace NFePHP\MDFe\Tests\Helpers;

use NFePHP\Common\Certificate;

/**
 * Helper criado para instanciar um objeto \NFePHP\Common\Certificate para fins de teste
 *
 * @package NFePHP\MDFe\Tests\Helpers
 */
trait CertificateTrait
{
    /**
     * @return \NFePHP\Common\Certificate
     */
    public function getCertificate()
    {
        $path = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR .
            'resources' . DIRECTORY_SEPARATOR .
            'keys' . DIRECTORY_SEPARATOR .
            'test.pfx';

        return Certificate::readPfx(
            \file_get_contents($path),
            '12345'
        );
    }
}
