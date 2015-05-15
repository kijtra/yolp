<?php

/**
 * This file is part of the Geocoder package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Kijtra\Yolp;

// use GeoIp2\ProviderInterface;
// use Geocoder\Exception\InvalidArgument;
// use Geocoder\Exception\UnsupportedOperation;
// use Geocoder\Provider\LocaleTrait;

/**
 * @author Jens Wiese <jens@howtrueisfalse.de>
 */
class LocalSearch extends Yolp
{
    private $base_url = 'http://search.olp.yahooapis.jp/OpenLocalPlatform/V1/localSearch';
    private $params = array();

    public function __construct($params = array())
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }
}
