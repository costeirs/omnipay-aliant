<?php
namespace Omnipay\Aliant;

use \Omnipay\Aliant\AccountTrait;

use \Omnipay\Common\AbstractGateway;

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
        return array(
            'username' => '',
            'password' => '',
            'returnUrl' => '',
            'testMode' => false,
        );
    }

    public function gettestMode()
    {
        return $this->getParameter('testMode');
    }

    public function settestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }
    public function getreturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    public function setreturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }
    
    /**
     * Create a new sale request.
     *
     * @param array $parameters
     * @return \Omnipay\Aliant\Message\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Aliant\Message\PurchaseRequest', $parameters);
    }

    /**
     * Create a sale inquiry request.
     *
     * @param array $parameters
     * @return \Omnipay\Aliant\Message\SaleInquiryRequest
     */
    public function fetchTransaction(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Aliant\Message\SaleInquiryRequest', $parameters);
    }
}
