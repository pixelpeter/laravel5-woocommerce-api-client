<?php namespace Pixelpeter\Woocommerce;

use Automattic\WooCommerce\Client;

/**
 * @property mixed config
 */
class WoocommerceClient
{
    /**
     * @var \Automattic\WooCommerce\Client
     */
    protected $client;

    /**
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

    /**
     * Get the http request header from the last request
     *
     * @return \Automattic\WooCommerce\HttpClient\Request
     */
    public function getRequest()
    {
        return $this->client->http->getRequest();
    }

    /**
     * Get the http response headers from the last request
     *
     * @return \Automattic\WooCommerce\HttpClient\Response
     */
    public function getResponse()
    {
        return $this->client->http->getResponse();
    }
}
