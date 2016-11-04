<?php

namespace Tests\NFePHP\MDFe\Auxiliar;

/**
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\MDFe\Auxiliar\Response;
use PHPUnit_Framework_TestCase;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public $mdfe;

    public function testInstanciar()
    {
        $this->mdfe = new Response();
    }
}
