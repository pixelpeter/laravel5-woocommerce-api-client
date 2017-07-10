<?php namespace Pixelpeter\Woocommerce\Test;

use Mockery;
use PHPUnit_Framework_TestCase;
use Pixelpeter\Woocommerce\Facades\Woocommerce;
use Pixelpeter\Woocommerce\WoocommerceClient;

/**
 * @property Mockery\MockInterface client
 */
class WoocommerceClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * set up
     */
    public function setUp()
    {
        $this->client = Mockery::mock('Automattic\WooCommerce\Client');
        $this->httpClient = Mockery::mock('Automattic\WooCommerce\HttpClient\HttpClient');
        $this->response = Mockery::mock('Automattic\WooCommerce\HttpClient\response');
            
        $this->woocommerce = new WoocommerceClient($this->client);
    }

    /**
     * @test
     */
    public function post_can_be_called()
    {
        $this->client
            ->shouldReceive('post')
            ->once()
            ->with('someurl',['bar' => 'baz'])
            ->andReturn('foo');

        $this->assertEquals('foo', $this->woocommerce->post('someurl', ['bar' => 'baz']));
    }

    /**
     * @test
     */
    public function put_can_be_called()
    {
        $this->client
            ->shouldReceive('put')
            ->once()
            ->with('someurl',['bar' => 'baz'])
            ->andReturn('foo');

        $this->assertEquals('foo', $this->woocommerce->put('someurl', ['bar' => 'baz']));
    }

    /**
     * @test
     */
    public function get_can_be_called()
    {
        $this->client
            ->shouldReceive('get')
            ->once()
            ->with('someurl',[])
            ->andReturn('foo');

        $this->assertEquals('foo', $this->woocommerce->get('someurl'));
    }

    /**
     * @test
     */
    public function delete_can_be_called()
    {
        $this->client
            ->shouldReceive('delete')
            ->once()
            ->with('someurl',[])
            ->andReturn('foo');

        $this->assertEquals('foo', $this->woocommerce->delete('someurl'));
    }

    /**
     * @test
     */
    public function getrequest_can_be_called()
    {
        $this->httpClient
            ->shouldReceive('getRequest')
            ->once()
            ->andReturn('foo');
        $this->client->http = $this->httpClient;

        $this->assertEquals('foo', $this->woocommerce->getRequest());
    }

    /**
     * @test
     */
    public function getresponse_can_be_called()
    {
        $this->httpClient
            ->shouldReceive('getResponse')
            ->once()
            ->andReturn('foo');
        $this->client->http = $this->httpClient;

        $this->assertEquals('foo', $this->woocommerce->getResponse());
    }

    /**
     * @test
     */
    public function pagination_first_page_returns_valid_page_number()
    {
        $this->assertEquals(1, $this->woocommerce->firstPage());
    }

    /**
     * @test
     */
    public function pagination_last_page_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->once()
            ->andReturn([
                'X-WP-TotalPages' => 12
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals(12, $this->woocommerce->lastPage());
    }

    /**
     * @test
     */
    public function pagination_current_page_returns_first_page_when_empty()
    {
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->once()
            ->andReturn([]);
        $this->client->http = $this->httpClient;

        $this->assertEquals(1, $this->woocommerce->currentPage());
    }

    /**
     * @test
     */
    public function pagination_current_page_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 6
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals(6, $this->woocommerce->currentPage());
    }

    /**
     * @test
     */
    public function pagination_total_results_returns_valid_number()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->once()
            ->andReturn([
                'X-WP-Total' => 1234
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals(1234, $this->woocommerce->totalResults());
    }

    /**
     * @test
     */
    public function pagination_total_pages_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->once()
            ->andReturn([
                'X-WP-TotalPages' => 13
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals(13, $this->woocommerce->lastPage());
    }

    /**
     * @test
     */
    public function pagination_previous_page_is_null_when_on_first_page()
    {
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 1
            ]);
        $this->client->http = $this->httpClient;

        $this->assertNull($this->woocommerce->previousPage());
        $this->assertFalse($this->woocommerce->hasPreviousPage());
        $this->assertTrue($this->woocommerce->hasNotPreviousPage());
    }

    /**
     * @test
     */
    public function pagination_previous_page_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 5
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals(4, $this->woocommerce->previousPage());
        $this->assertTrue($this->woocommerce->hasPreviousPage());
        $this->assertFalse($this->woocommerce->hasNotPreviousPage());
    }

    /**
     * @test
     */
    public function pagination_next_page_is_null_when_on_last_page()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->andReturn([
                'X-WP-TotalPages' => 13
            ]);
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 13
            ]);
        $this->client->http = $this->httpClient;

        $this->assertNull($this->woocommerce->nextPage());
        $this->assertFalse($this->woocommerce->hasNextPage());
        $this->assertTrue($this->woocommerce->hasNotNextPage());
    }

    /**
     * @test
     */
    public function pagination_next_page_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->andReturn([
                'X-WP-TotalPages' => 13
            ]);
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 5
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals(6, $this->woocommerce->nextPage());
        $this->assertTrue($this->woocommerce->hasNextPage());
        $this->assertFalse($this->woocommerce->hasNotNextPage());
    }

    /**
     * @test
     */
    public function getrequest_can_be_called()
    {
        $this->httpClient
            ->shouldReceive('getRequest')
            ->once()
            ->andReturn('foo');
        $this->client->http = $this->httpClient;

        $this->assertEquals($this->woocommerce->getRequest(), 'foo');
    }

    /**
     * @test
     */
    public function getresponse_can_be_called()
    {
        $this->httpClient
            ->shouldReceive('getResponse')
            ->once()
            ->andReturn('foo');
        $this->client->http = $this->httpClient;

        $this->assertEquals($this->woocommerce->getResponse(), 'foo');
    }

    /**
     * @test
     */
    public function pagination_first_page_returns_valid_page_number()
    {
        $this->assertEquals($this->woocommerce->firstPage(), 1);
    }

    /**
     * @test
     */
    public function pagination_last_page_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->once()
            ->andReturn([
                'X-WP-TotalPages' => 12
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals($this->woocommerce->lastPage(), 12);
    }

    /**
     * @test
     */
    public function pagination_current_page_returns_first_page_when_empty()
    {
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->once()
            ->andReturn([]);
        $this->client->http = $this->httpClient;

        $this->assertEquals($this->woocommerce->currentPage(), 1);
    }

    /**
     * @test
     */
    public function pagination_current_page_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 6
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals($this->woocommerce->currentPage(), 6);
    }

    /**
     * @test
     */
    public function pagination_total_results_returns_valid_number()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->once()
            ->andReturn([
                'X-WP-Total' => 1234
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals($this->woocommerce->totalResults(), 1234);
    }

    /**
     * @test
     */
    public function pagination_total_pages_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->once()
            ->andReturn([
                'X-WP-TotalPages' => 13
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals($this->woocommerce->lastPage(), 13);
    }

    /**
     * @test
     */
    public function pagination_previous_page_is_null_when_on_first_page()
    {
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 1
            ]);
        $this->client->http = $this->httpClient;

        $this->assertNull($this->woocommerce->previousPage());
        $this->assertFalse($this->woocommerce->hasPreviousPage());
        $this->assertTrue($this->woocommerce->hasNotPreviousPage());
    }

    /**
     * @test
     */
    public function pagination_previous_page_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 5
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals($this->woocommerce->previousPage(), 4);
        $this->assertTrue($this->woocommerce->hasPreviousPage());
        $this->assertFalse($this->woocommerce->hasNotPreviousPage());
    }

    /**
     * @test
     */
    public function pagination_next_page_is_null_when_on_last_page()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->andReturn([
                'X-WP-TotalPages' => 13
            ]);
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 13
            ]);
        $this->client->http = $this->httpClient;

        $this->assertNull($this->woocommerce->nextPage());
        $this->assertFalse($this->woocommerce->hasNextPage());
        $this->assertTrue($this->woocommerce->hasNotNextPage());
    }

    /**
     * @test
     */
    public function pagination_next_page_returns_valid_page_number()
    {
        $this->httpClient
            ->shouldReceive('getResponse->getHeaders')
            ->andReturn([
                'X-WP-TotalPages' => 13
            ]);
        $this->httpClient
            ->shouldReceive('getRequest->getParameters')
            ->andReturn([
                'page' => 5
            ]);
        $this->client->http = $this->httpClient;

        $this->assertEquals($this->woocommerce->nextPage(), 6);
        $this->assertTrue($this->woocommerce->hasNextPage());
        $this->assertFalse($this->woocommerce->hasNotNextPage());
    }

    /**
     * tear down
     */
    public function tearDown()
    {
        Mockery::close();
    }
}