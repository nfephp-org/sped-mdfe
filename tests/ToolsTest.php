<?php

/**
 * Class ToolsMDFeTest
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\MDFe\Tools;

class ToolsMDFeTest extends PHPUnit_Framework_TestCase
{
    public $mdfe;

    /**
     * @expectedException NFePHP\Common\Exception\InvalidArgumentException
     */
    public function testeInstanciar()
    {
        $configJson = dirname(dirname(__FILE__)) . '/tests/fixtures/config/fakeconfig.json';
        $this->mdfe = new Tools($configJson);
    }
}
