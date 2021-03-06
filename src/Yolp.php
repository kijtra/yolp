<?php
/**
 * Yolp
 * Yahoo JAPAN YOLP API library for PHP
 *
 * @copyright    Copyright © 2015 Kijtra (http://kijtra.com)
 * @link         https://github.com/kijtra/yolp
 * @package      Yolp
 * @license      MIT License
 * @author Kijtra <kijtra@gmail.com>
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
    protected static $api_key = NULL;

    private static $curl_options = array(
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_FAILONERROR => true,
        CURLOPT_USERAGENT => 'PHP Kijtra/Yolp (https://github.com/kijtra/yolp)',
    );

    public $request_url = NULL;
    private $result_info = NULL;

    final static function apiKey($api_key = NULL)
    {
        self::$api_key = $api_key;
    }

    final static function curlSetOpt($options = array())
    {
        self::$curl_options = array_replace(self::$curl_options, $options);
    }

    public function setApiKey($api_key)
    {
        if (is_string($api_key)) {
            self::$api_key = $api_key;
        }

        return $this;
    }

    public function getApiKey()
    {
        return self::$api_key;
    }

    public function setParams($params = NULL)
    {
        if (!empty($params) && is_array($params)) {
            $this->params = array_replace($this->params, $params);
        }
    }

    public function getParams()
    {
        return $this->params;
    }

    protected function request($url, $params = array())
    {
        $params['appid'] = self::$api_key;
        $this->request_url = $url.'?'.http_build_query($params);

        $options = self::$curl_options;
        $options[CURLOPT_URL] = $this->request_url;

        $ch = curl_init();
	    curl_setopt_array($ch, $options);
	    $res = curl_exec($ch);
        $errno = curl_errno($ch);
        $error = curl_error($ch);
	    curl_close($ch);

        if (CURLE_OK !== $errno) {
            throw new YolpException($error, $errno);
        }

        if (!empty($params['output']) && 'json' === $params['output']) {
            $data = json_decode($res, TRUE);
            if (!empty($data['Error'])) {
                if (!empty($data['Error']['Detail'])) {
                    $message = $data['Error']['Detail']['Message'];
                    $code = $data['Error']['Detail']['Status'];
                } else {
                    $message = $data['Error']['Message'];
                    $code = $data['Error']['Code'];
                }

                throw new YolpException($message, $code);
            }
        } else {
            $data = $res;
        }

        return $data;
    }

    public function validLat($value = NULL)
    {
        if (!empty($value)) {
            return (preg_match('/\A([\-\+]?\d{1,2}\.\d+)\z/', $value));
        }

        return FALSE;
    }

    public function validLon($value = NULL)
    {
        if (!empty($value)) {
            return (preg_match('/\A([\-\+]?\d{1,3}\.\d+)\z/', $value));
        }

        return FALSE;
    }
}
