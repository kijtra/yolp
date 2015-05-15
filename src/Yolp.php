<?php
/**
 * Yolp
 * Yahoo JAPAN YOLP API library for PHP
 *
 * @copyright    Copyright © 2015 Kijtra (http://kijtra.com)
 * @link         https://github.com/kijtra/yolp
 * @package      Yolp
 * @license      MIT License
 */

namespace Kijtra;

/**
* Yolp
* Yahoo JAPAN YOLP API library for PHP
 *
 * @package			Yolp
 */
class Yolp {
    /**
     * Yahoo JAPAN API Key.
     * API Key get from Yahoo JAPAN Developer Network http://developer.yahoo.co.jp/
     */
    protected $api_key = NULL;

    /**
     * Constructor
     * Set Yahoo JAPAN API Key.
     * http://developer.yahoo.co.jp/
     *
     * @param string $api_key Yahoo JAPAN API Key
     */
    public function __construct($api_key = NULL)
    {
        $this->setApiKey($api_key);
    }

    public function setApiKey($api_key)
    {
        if (is_string($api_key)) {
            $this->api_key = $api_key;
        }

        return $this;
    }
}
