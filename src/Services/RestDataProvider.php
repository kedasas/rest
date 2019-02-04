<?php
/*
 * This file is part of the Weather app.
 *
 * (c) Kestutis Risovas
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class RestDataProvider
{
    /**  @var string */
    private $providerUri;
    /**  @var Guzzle Client */
    private $client;

    public function __construct($providerUri)
    {
        $this->providerUri = $providerUri;

        /** Setting default parameters to Client */
        $this->client = new Client([
            'timeout'  => 10.0,
            'verify' => false
        ]);
    }

    /**
     * Getting data from provider.
     *
     * @param string $restData
     * @throws \Exception
     * @return array
     */
    public function getRestData($queryParams)
    {
        try {
            $response = $this->client->request('GET', $this->providerUri, $queryParams);

        } catch (RequestException $e) {

            if (!empty($e->getHandlerContext()['error'])) {
                return array('error' => $e->getHandlerContext()['error']);
            }

            if ($e->hasResponse()) {
                return array('error' => $e->getMessage());
            }
        }

        try {
            return json_decode($response->getBody()->getContents(),true);

        } catch (\Exception $e) {

            return array("error" =>  $e->getMessage());

        }

    }

}
