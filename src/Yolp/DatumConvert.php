<?php

/**
 * @license    MIT License
 */

namespace Kijtra\Yolp;
use Kijtra\Yolp;

/**
 * @author Kijtra <kijtra@gmail.com>
 */
class DatumConvert extends Yolp
{
    public $base_url = 'http://datum.search.olp.yahooapis.jp/OpenLocalPlatform/V1/datumConvert';
    public $params = array();
    private $results = NULL;

    public function __construct($coordinates)
    {
        $this->request_url = NULL;
        $params = array();
        $params['coordinates'] = $coordinates;
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

    private function formatItems($feature = NULL)
    {
        if (empty($feature[0])) {
            return NULL;
        }

        $items = array();
        foreach($feature as $val) {
            $explode = explode(',', $val['Geometry']['Coordinates']);
            $items[] = array(
                'lat' => floatval($explode[1]),
                'lon' => floatval($explode[0])
            );
        }

        return $items;
    }

    public function items()
    {
        $params = $this->getParams();
        if (!empty($params['datum'])) {
            if (!$results = $this->getResults()) {
                return false;
            }

            return (!empty($results['Feature']) ? $this->formatItems($results['Feature']) : NULL);
        } else {
            return $this->wsg();
        }
    }

    public function wsg()
    {
        $this->setParams(array('datum' => 'wsg'));

        if (!$results = $this->getResults()) {
            return false;
        }

        return (!empty($results['Feature']) ? $this->formatItems($results['Feature']) : NULL);
    }

    public function tky()
    {
        $this->setParams(array('datum' => 'tky'));

        if (!$results = $this->getResults()) {
            return false;
        }

        return (!empty($results['Feature']) ? $this->formatItems($results['Feature']) : NULL);
    }
}
