<?php

namespace App\Http\Controllers\Payment;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class CoinbaseGateway
{
    const BASE_URI = "https://api.commerce.coinbase.com";

    private $apiKey;

    private $apiVersion;

    private $client;

    public function __construct()
    {
        $this->apiKey = 'fcfacda6-a6cd-4092-a404-2000b4847a55';
        $this->apiVersion = '2018-03-22';
        $this->client = new Client([
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Content-Type' => 'application/json',
                'X-CC-Api-Key' => $this->apiKey,
                'X-CC-Version' => $this->apiVersion
            ]
        ]);
    }

    /**
     * Make Request
     *
     * @param string $method
     * @param string $uri
     * @param null|array $query
     * @param null|array $params
     * @return array
     */
    public function makeRequest($method, $uri, $params = [])
    {
        try{
            $response = $this->client->request($method, $uri, [
                'body' => json_encode($params)
            ]);

            return json_decode($response->getBody(), true);

        }catch(GuzzleException $e){
            Log::error($e->getMessage());
        }
    }

    /**
     * Lists all charges
     * @param null|array $query
     * @return array
     */
    public function getCharges($query = [])
    {
        return $this->makeRequest('GET', 'charges', $query);
    }

    /**
     * Create a new charge
     * @param null|param $query
     */

    public function createCharges($query = [])
    {
        return $this->makeRequest('post', 'charges', $query);
    }


    /**
     * Retrieves an existing charge
     * @param string $chargeId
     * @return array
     */

    public function getCharge($chargeId)
    {
        return $this->makeRequest('get', "charges/{$chargeId}");
    }

    /**
     * Cancel Charge
     * @param string $chargeId
     * @return array
     */
    public function cancelCharge($chargeId)
    {
        return $this->makeRequest('post', "charges/{$chargeId}/cancel");
    }


    /**
     * Lists all checkouts.
     *
     * @param null|array $query
     * @return array
     */

    public function getCheckouts($query = [])
    {
        return $this->makeRequest('get', 'checkouts', $query);
    }


    /**
     * Creates a new checkout.
     *
     * @param  array  $params
     * @return array
     */

    public function createCheckout($params = [])
    {
        return $this->makeRequest('post', 'checkouts', $params);
    }


    /**
     * Retrieves an existing checkout.
     *
     * @param  string  $checkoutId
     * @return array
     */
    public function getCheckout($checkoutId)
    {
        return $this->makeRequest('get', "checkouts/{$checkoutId}");
    }


    /**
     * Updates an existing checkout.
     *
     * @param  string  $checkoutId
     * @param  array   $params
     * @return array
     */
    public function updateCheckout($checkoutId, $params = [])
    {
        return $this->makeRequest('put', "checkouts/{$checkoutId}", $params);
    }


    /**
     * Deletes an existing checkout.
     *
     * @param  string  $checkoutId
     * @return array
     */
    public function deleteCheckout($checkoutId)
    {
        return $this->makeRequest('delete', "checkouts/{$checkoutId}");
    }


    /**
     * Lists all events.
     *
     * @param null|array $query
     * @return array
     */
    public function getEvents($query = [])
    {
        return $this->makeRequest('get', 'events', $query);
    }


    /**
     * Retrieves an existing event.
     *
     * @param  string  $eventId
     * @return array
     */
    public function getEvent($eventId)
    {
        return $this->makeRequest('get', "events/{$eventId}");
    }
}
