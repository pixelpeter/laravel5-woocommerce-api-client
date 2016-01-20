<?php namespace Pixelpeter\Woocommerce;

use Automattic\WooCommerce\Client;

/**
 * @property mixed config
 */
class WoocommerceClient
{
    /**
     * @var Automattic\WooCommerce\Client
     */
    protected $client;

    /**
     * @param array $config
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * POST method.
     *
     * @param string $endpoint API endpoint.
     * @param array $data Request data.
     *
     * @return array
     */
    public function post($endpoint, $data)
    {
        return $this->client->post($endpoint, $data);
    }

    /**
     * PUT method.
     *
     * @param string $endpoint API endpoint.
     * @param array $data Request data.
     *
     * @return array
     */
    public function put($endpoint, $data)
    {
        return $this->client->put($endpoint, $data);
    }

    /**
     * GET method.
     *
     * @param string $endpoint API endpoint.
     * @param array $parameters Request parameters.
     *
     * @return array
     */
    public function get($endpoint, $parameters = [])
    {
        return $this->client->get($endpoint, $parameters);
    }

    /**
     * DELETE method.
     *
     * @param string $endpoint API endpoint.
     * @param array $parameters Request parameters.
     *
     * @return array
     */
    public function delete($endpoint, $parameters = [])
    {
        return $this->client->delete($endpoint, $parameters);
    }
}
