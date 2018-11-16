<?php
namespace Omnipay\Aliant\Message;

use \Omnipay\Aliant\AccountTrait;

use Omnipay\Common\Message\AbstractResponse as OmnipayAbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;

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

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        if (empty($data)) {
            throw new InvalidResponseException;
        }

        /**
         * byzantine data deserialization procedure:
         *  - it's json, inside xml
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
        $hasErrorCode = array_key_exists('sale', $this->data) && array_key_exists('errorcode', $this->data['sale']);
        return $hasData && !$hasErrorCode;
    }

    /**
     * Transaction ID as assigned from Aliant
     */
    public function getTransactionReference()
    {
        if (empty($this->data) || $this->getCode() !== null) {
            return null;
        }
        return $this->data['sale_id'] ?: null;
    }

    /**
     * Error message
     */
    public function getMessage()
    {
        return !empty($this->data) && array_key_exists('sale', $this->data) ? $this->data['sale']['message'] : null;
    }

    /**
     * Error code
     */
    public function getCode()
    {
        return !empty($this->data) && array_key_exists('sale', $this->data) ? $this->data['sale']['errorcode'] : null;
    }
}
