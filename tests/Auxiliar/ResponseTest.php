<?php

/**
 * Class ResponseTest
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\MDFe\Auxiliar\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public $mdfe;
    
    public function testInstanciar()
    {
        $this->mdfe = new Response();
    }
}
