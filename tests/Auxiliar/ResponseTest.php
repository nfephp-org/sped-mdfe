<?php

/**
 * Class ResponseTest
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\MDFe\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public $mdfe;

    public function testeInstanciar()
    {
        $this->mdfe = new Response();
    }
}
