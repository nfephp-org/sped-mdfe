<?php

namespace NFePHP\MDFe\Common;

/**
 * Class for validation of config
 *
 * @category  NFePHP
 * @package   NFePHP\MDFe\Common\Config
 * @copyright NFePHP Copyright (c) 2008-2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      https://github.com/nfephp-org/sped-mdfe for the canonical source repository
 */

class Config{

    /**
     * Validate method
     * @param string $content config.json
     * @return StdClass
     * @throws \Exception
     */
    public static function validate($content)
    {
        if (!is_string($content)) {
            throw new \Exception("Não foi passado um json.");
        }
        $std = json_decode($content);
        if (! is_object($std)) {
            throw new \Exception("Não foi passado um json valido.");
        }
        return $std;
    }
}