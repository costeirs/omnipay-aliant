<?php
namespace Omnipay\Aliant\Message;

use \Omnipay\Aliant\AccountTrait;

use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
/**
 * Abstract Request
 */
abstract class AbstractRequest extends OmnipayAbstractRequest
{
    use AccountTrait;

    protected $endpoint = 'https://aliantpay.io/api/payments.asmx/NewSale';

    public function getEmail()
    {
        return $this->getParameter('email');
	}
	
    public function getAuthString()
    {
        return base64_encode($this->username).':'.base64_encode($this->password);
	}

	public function getEndpoint()
	{
		return $this->endpoint;
	}
	
	public function getData()
	{
		return [];
	}

	public function sendData($data)
	{
		return null;
	}
}
