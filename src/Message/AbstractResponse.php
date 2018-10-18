<?php
namespace Omnipay\Aliant\Message;

use \Omnipay\Aliant\AccountTrait;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;
/**
 * Abstract Request
 */
abstract class AbstractResponse extends OmnipayAbstractResponse
{
    use AccountTrait;

    public function getEmail()
    {
        return $this->getParameter('email');
	}
}
