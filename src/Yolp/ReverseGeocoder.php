<?php

/**
 * This file is part of the Geocoder package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Kijtra\Yolp;
use Kijtra\Yolp;

/**
 * @author Kijtra <kijtra@gmail.com>
 */
class ReverseGeocoder extends Yolp
{
    public $base_url = 'http://reverse.search.olp.yahooapis.jp/OpenLocalPlatform/V1/reverseGeoCoder';
    public $params = array();
    private $results = NULL;

    public function __construct($params = array())
    {
        $this->request_url = NULL;
        $params['output'] = 'json';
        unset($params['callback']);
        $this->setParams($params);
    }

    private function getResults()
    {
        if (!empty($this->results)) {
            return $this->results;
        } elseif(empty($this->request_url)) {
            return $this->results = $this->request($this->base_url, $this->getParams());
        }
    }

    public function info()
    {
        if (!$results = $this->getResults()) {
            return false;
        }

        return (!empty($results['ResultInfo']) ? $results['ResultInfo'] : NULL);
    }

    public function items()
    {
        if (!$results = $this->getResults()) {
            return false;
        }

        return (!empty($results['Feature']) ? $results['Feature'] : NULL);
    }
}
