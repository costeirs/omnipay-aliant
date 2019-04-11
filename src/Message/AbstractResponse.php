<?php

namespace Omnipay\Aliant\Message;

use Omnipay\Aliant\AccountTrait;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;
use Omnipay\Common\Message\RequestInterface;

/**
 * Abstract Response
 */
abstract class AbstractResponse extends OmnipayAbstractResponse
{
    use AccountTrait;

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    /**
     * @param RequestInterface $request
     * @param $data
     * @throws InvalidResponseException
     */
    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        if (empty($data)) {
            throw new InvalidResponseException;
        }

        /**
         * byzantine data deserialization procedure:
         *  - it's json, inside an xml SOAP response
         *  - and there's no type field to tell what class it'll be;
         *  - status will always be 200 OK even if it errors out
         *  - but there's no status field if everything actually was OK
         */

        // break out of xml
        $message = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOWARNING);
        $message = trim($message);
        $message = json5_decode($message, true);

        // done
        $this->data = $message;
    }

    public function isSuccessful()
    {
        $hasData = !empty($this->data);
        $hasErrorCode = array_key_exists('error', $this->data) && array_key_exists('code', $this->data['error']);
        return $hasData && !$hasErrorCode;
    }

    /**
     * Transaction ID as assigned from Aliant
     */
    public function getTransactionReference()
    {
        if (empty($this->data) || $this->getCode() !== null || !array_key_exists('sale_id', $this->data)) {
            return null;
        }
        return $this->data['sale_id'];
    }

    /**
     * Error code
     */
    public function getCode()
    {
        return !empty($this->data) && array_key_exists('error', $this->data) ? $this->data['error']['code'] : null;
    }

    /**
     * Error message
     */
    public function getMessage()
    {
        return !empty($this->data) && array_key_exists('error', $this->data) ? $this->data['error']['message'] : null;
    }
}
