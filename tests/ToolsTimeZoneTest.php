<?php

use NFePHP\Common\Certificate;
use NFePHP\MDFe\Tools;
use PHPUnit\Framework\TestCase;

class ToolsTimeZoneTest extends TestCase
{
    public function test_should_not_change_default_timezone()
    {
        $this->withDefaultTimeZone('UTC', function () {
            $this->makeTools('AC');

            $this->assertSame('UTC', date_default_timezone_get());
        });
    }

    public function test_should_use_timezone_of_uf_in_event()
    {
        $this->withDefaultTimeZone('UTC', function () {
            $tools = $this->makeTools('AC');

            $tools->sefazEncerra(
                '12241106157250000116580010000000751000000001',
                '912240000000001',
                '12',
                '1200401'
            );

            $hoje = new \DateTime('now', new \DateTimeZone('America/Rio_Branco'));
            $this->assertNotFalse(strpos($tools->lastRequest, '<dtEnc>' . $hoje->format('Y-m-d') . '</dtEnc>'));
            $this->assertSame(1, preg_match('/<dhEvento>[0-9T:-]+-05:00<\/dhEvento>/', $tools->lastRequest));
            $this->assertSame('UTC', date_default_timezone_get());
        });
    }

    private function withDefaultTimeZone($timezone, callable $test)
    {
        $default = date_default_timezone_get();
        date_default_timezone_set($timezone);
        try {
            $test();
        } finally {
            date_default_timezone_set($default);
        }
    }

    private function makeTools($uf)
    {
        $config = [
            'tpAmb' => 2,
            'razaosocial' => 'EMPRESA TESTE',
            'cnpj' => '06157250000116',
            'siglaUF' => $uf,
            'versao' => '3.00'
        ];
        $pfx = file_get_contents(TESTS_FIXTURES . '/certs/cert_cnpj_06157250000116_senha_minhasenha.pfx');
        $certificate = Certificate::readPfx($pfx, 'minhasenha');

        return new class(json_encode($config), $certificate) extends Tools {
            protected function sendRequest($request, array $parameters = [])
            {
                return '';
            }
        };
    }
}
