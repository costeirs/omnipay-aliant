<?php

namespace Omnipay\Aliant;

use Omnipay\Aliant\Message\PurchaseRequest;
use Omnipay\Aliant\Message\RefundRequest;
use Omnipay\Aliant\Message\SaleInquiryRequest;
use Omnipay\Common\AbstractGateway;

/**
 * Aliant Gateway
 */
class Gateway extends AbstractGateway
{
    use AccountTrait;

    public function getName()
    {
        return 'Aliant';
    }

    public function getDefaultParameters()
    {
        return [
            'username' => '',
            'password' => '',
            'returnUrl' => '',
            'testMode' => false,
        ];
    }

    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    /**
     * Create a new sale request.
     *
     * @param array $parameters
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * Create a sale inquiry request.
     *
     * @param array $parameters
     * @return SaleInquiryRequest
     */
    public function fetchTransaction(array $parameters = [])
    {
        return $this->createRequest(SaleInquiryRequest::class, $parameters);
    }

    /**
     * Issue a refund.
     * Refunds can only be issued for completed invoices.
     *
     * @param array $parameters
     * @return RefundRequest
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }
}
