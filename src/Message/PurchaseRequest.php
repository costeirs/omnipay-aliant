<?php
namespace Omnipay\Aliant\Message;

/**
 * Dummy Authorize Request
 */
class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $data = array(
            'amount' => $this->getAmount(),
            'email' => $this->getEmail(),
            'email_it' => false
        );
        return $data;
    }

    public function sendData($data)
    {
        $json = json_encode($data);

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint().'/NewSale',
            [
                "Content-Type" => "application/x-www-form-urlencoded; charset=utf-8"
            ],
            // byzantine parameter serialization
            "authorization=".$this->getAuthString()."&json=".$json
        );
        return $this->response = new PurchaseResponse($this, $httpResponse->getBody()->getContents());
    }
}
