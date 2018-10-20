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
        $parts = [];

        // invoice_id?
        if ($this->getTransactionReference()) {
            $parts['i'] = $this->getTransactionReference();
        }

        // returnUrl?
        if ($this->getRequest()->getReturnUrl()) {
            $parts['w'] = $this->getRequest()->getReturnUrl();
        }

        // assemble url
        $url =
        'https://aliantpay.io/invoice?'.
        http_build_query($parts, '', '&');

        return $url;
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
