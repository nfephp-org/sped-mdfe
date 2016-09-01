<?php

/**
 * Class MailMDFeTest
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\MDFe\Mail;

class MailTest extends PHPUnit_Framework_TestCase
{
    public $mail;

    public function testeInstanciar()
    {
        $configJson = file_get_contents(dirname(dirname(__FILE__)) . '/tests/fixtures/config/fakeconfig.json');
        $json = json_decode($configJson);
        $aMail = (array) $json->aMailConf;
        $this->mail = new Mail($aMail);
    }
}
