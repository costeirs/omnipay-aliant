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
            'amount' => '1.00',
            'description' => 'Order 123',
            'returnUrl' => 'http://www.example.com/complete'
        );

        $this->inquiryOptions = [
            'transactionReference' => 101118
        ];
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->purchase($this->options)->send();

        $this->assertTrue($response->isRedirect());
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('101118', $response->getTransactionReference());
        $this->assertEquals('https://aliantpay.io/invoice?i=101118&w=http%3A%2F%2Fwww.example.com%2Fcomplete', $response->getRedirectUrl());
    }
    
    public function testPurchaseFailure()
    {
        $this->setMockHttpResponse('PurchaseFail.txt');

        $response = $this->gateway->purchase($this->options)->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('422', $response->getCode());
    }

    public function testInquirySuccess()
    {
        // inquiry success result is identical to purchase success result
        $this->setMockHttpResponse('PurchaseSuccess.txt');

        $response = $this->gateway->fetchTransaction($this->inquiryOptions)->send();
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('101118', $response->getTransactionReference());
    }

    public function testInquiryFailure()
    {
        $this->setMockHttpResponse('InquiryFail.txt');

        $response = $this->gateway->fetchTransaction($this->inquiryOptions)->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals('404', $response->getCode());
        $this->assertEquals('Unexistent transaction', $response->getMessage());
    }
}
