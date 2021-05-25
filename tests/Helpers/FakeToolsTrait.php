<?php

namespace NFePHP\MDFe\Tests\Helpers;

/**
 * Trait FakeToolsTrait
 * Essa Trait tem o objetivo de fornecer um objeto Tools com certificado para fins de testes
 *
 * @package NFePHP\MDFe\Tests\Helpers
 */
trait FakeToolsTrait
{
    use CertificateTrait;

    /**
     * @return \NFePHP\MDFe\Common\Tools
     */
    public function getFakeTools()
    {
        $config = [
            "atualizacao" => date('Y-m-d H:i:s'),
            "tpAmb" => 2,
            "razaosocial" => 'FÁBRICA DE SOFTWARE MATRIZ',
            "cnpj" => '',
            "ie" => '',
            "siglaUF" => 'RS',
            "versao" => '3.00'
        ];
        return new FakeTools(json_encode($config), $this->getCertificate());
    }
}
