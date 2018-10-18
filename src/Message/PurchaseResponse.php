<?php
namespace Omnipay\Aliant\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Aliant Response
 */
class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Gets the redirect target url.
     */
    public function getRedirectUrl()
    {
        return
        'https://aliantpay.io/invoice?i='.
        $this->getTransactionReference().
        '&w='.
        $this->getRequest()->getReturnUrl();
    }

    public function isRedirect()
    {
        return parent::isSuccessful();
    }
    
    public function isSuccessful()
    {
        // redirect requests are never successful
        return false;
    }
}
