<?php
namespace Omnipay\Aliant\Message;

use \Omnipay\Aliant\AccountTrait;

use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Exception\InvalidResponseException;
/**
 * Aliant Response
 */
class Response extends AbstractResponse
{
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
        $message = json_decode($message, true);

        // done
        $this->data = $message;
    }
    public function isSuccessful()
    {
        $hasErrorCode = array_key_exists('sale', $this->data) && array_key_exists('errorcode', $this->data->sale);
        return !$hasErrorCode;
    }

    public function getTransactionReference()
    {
        return $this->data['sale_id'] ?: null;
    }

    public function getMessage()
    {
        return isset($this->data['RESPMSG']) ? $this->data['RESPMSG'] : null;
    }

    public function getCode()
    {
        return isset($this->data['RESULT']) ? (int) $this->data['RESULT'] : null;
    }
}
