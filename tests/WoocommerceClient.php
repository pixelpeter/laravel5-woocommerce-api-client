<?php namespace Pixelpeter\Woocommerce\Test;

use Mockery;
use PHPUnit_Framework_TestCase;
use Pixelpeter\Woocommerce\WoocommerceClient;

/**
 * @property Mockery\MockInterface client
 */
class WoocommerceClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * set up
     */
    public function setUp()
    {
        $this->client = Mockery::mock('Automattic\WooCommerce\Client');
        $this->woocommerce = new WoocommerceClient($this->client);
    }

    public function testSomethingIsTrue()
    {
        $this->assertTrue(true);
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

        $this->assertEquals($this->woocommerce->post('someurl', ['bar' => 'baz']), 'foo');
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

        $this->assertEquals($this->woocommerce->put('someurl', ['bar' => 'baz']), 'foo');
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

        $this->assertEquals($this->woocommerce->get('someurl'), 'foo');
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

        $this->assertEquals($this->woocommerce->delete('someurl'), 'foo');
    }

    /**
     * tear down
     */
    public function tearDown()
    {
        Mockery::close();
    }
}