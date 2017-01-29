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

    /**
     * Return the first page number of the result
     *
     * @return int
     */
    public function firstPage()
    {
        return 1;
    }

    /**
     * Return the last page number of the result
     *
     * @return int
     */
    public function lastPage()
    {
        return $this->totalPages();
    }

    /**
     * Return the current page number of the result
     *
     * @return int
     */
    public function currentPage()
    {
        return !empty($this->getRequest()->getParameters()['page']) ? $this->getRequest()->getParameters()['page'] : 1;
    }

    /**
     * Return the total number of results
     *
     * @return int
     */
    public function totalResults()
    {
        return (int)$this->getResponse()->getHeaders()['X-WP-Total'];
    }

    /**
     * Return the total number of pages for this result
     *
     * @return mixed
     */
    public function totalPages()
    {
        return (int)$this->getResponse()->getHeaders()['X-WP-TotalPages'];
    }

    /**
     * Return the previous page number for the current page
     * Will be null if there's no previous page
     *
     * @return int|null
     */
    public function previousPage()
    {
        $previous_page = $this->currentPage() - 1;
        if ($previous_page < 1) {
            $previous_page = null;
        }

        return $previous_page;
    }

    /**
     * Return the next page number for the current page
     * Will be null if there's no next page
     *
     * @return int|null
     */
    public function nextPage()
    {
        $next_page = $this->currentPage() + 1;
        if ($next_page > $this->totalPages()) {
            $next_page = null;
        }

        return $next_page;
    }

    /**
     * Returns true if there's a next page
     *
     * @return bool
     */
    public function hasNextPage()
    {
        return (bool)$this->nextPage();
    }

    /**
     * Returns true if there's a previous page
     *
     * @return bool
     */
    public function hasPreviousPage()
    {
        return (bool)$this->previousPage();
    }

    /**
     * Returns true if there's no next page
     *
     * @return bool
     */
    public function hasNotNextPage()
    {
        return (bool)!$this->nextPage();
    }

    /**
     * Returns true if there's no previous page
     *
     * @return bool
     */
    public function hasNotPreviousPage()
    {
        return (bool)!$this->previousPage();
    }
}
