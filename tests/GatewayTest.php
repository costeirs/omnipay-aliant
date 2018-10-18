<?php
namespace Omnipay\Aliant;

use Omnipay\Tests\GatewayTestCase;

class AliantGatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->options = array(
			'amount' => '1.00'
        );
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('101118', $response->getTransactionReference());
	}
}
