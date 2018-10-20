<?php
namespace Omnipay\Aliant\Message;

/**
 * Dummy Authorize Request
 */
class SaleInquiryRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/SeeSale';
    }

    public function getData()
    {
        $this->validate('transactionReference');
        return array();
    }

    public function sendData($data)
    {
        $transactionid = $this->getTransactionReference();

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            [
                "Content-Type" => "application/x-www-form-urlencoded; charset=utf-8"
            ],
            "authorization=".$this->getAuthString()."&transactionid=".$transactionid
        );
        return $this->response = new InquiryResponse($this, $httpResponse->getBody()->getContents());
    }
}
