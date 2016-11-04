<?php

namespace Tests\NFePHP\MDFe;

/**
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\Common\Exception\InvalidArgumentException;
use NFePHP\MDFe\Tools;
use PHPUnit_Framework_TestCase;

class ToolsTest extends PHPUnit_Framework_TestCase
{
    public $mdfe;

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInstanciar()
    {
        $configJson = dirname(__FILE__) . '/fixtures/config/fakeconfig.json';
        $this->mdfe = new Tools($configJson);
    }
}
