<?php

namespace Omnipay\Aliant\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Exception\InvalidResponseException;

/**
 * Sale Inquiry Request
 */
class SaleInquiryRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/SeeSale';
    }

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionReference');
        return [];
    }

    /**
     * @param array $data
     * @return InquiryResponse
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {
        $transactionId = $this->getTransactionReference();

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            [
                "Content-Type" => "application/x-www-form-urlencoded; charset=utf-8"
            ],
            "authorization=" . $this->getAuthString() . "&transactionid=" . $transactionId
        );
        return $this->response = new InquiryResponse($this, $httpResponse->getBody()->getContents());
    }
}
