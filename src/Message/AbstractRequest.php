<?php

namespace Omnipay\Aliant\Message;

use Omnipay\Aliant\AccountTrait;
use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;

/**
 * Abstract Request
 */
abstract class AbstractRequest extends OmnipayAbstractRequest
{
    use AccountTrait;

    protected $endpoint = 'https://aliantpay.io/api/payments.asmx';

    protected $negativeAmountAllowed = false;
    protected $zeroAmountAllowed = false;

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function getAuthString()
    {
        return
            base64_encode($this->getParameter('username')) .
            ':' .
            base64_encode($this->getParameter('password'));
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

    public function getSendInvoice()
    {
        return $this->getParameter('email_it');
    }

    public function setSendInvoice($email_it)
    {
        return $this->setParameter('email_it', $email_it);
    }
}
