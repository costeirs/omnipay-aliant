<?php
namespace Omnipay\Aliant\Message;

use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Dummy Authorize Request
 */
class PurchaseRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        return parent::getEndpoint() . '/NewSale';
    }

    public function getData()
    {
        $this->validate('amount');

        if ($this->getSendInvoice() && empty($this->getEmail())) {
            throw new InvalidRequestException("The email paramater cannot be empty if email_it is true");
        }

        $data = array(
            'amount' => $this->getAmount(),
            'description' => $this->getDescription(),
            'email_it' => $this->getSendInvoice()
        );
        if (!empty($this->getEmail())) {
            $data['email'] = $this->getEmail();
        }
        return $data;
    }

    public function sendData($data)
    {
        $json = json_encode($data);

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getEndpoint(),
            [
                "Content-Type" => "application/x-www-form-urlencoded; charset=utf-8"
            ],
            // byzantine parameter serialization
            "authorization=".$this->getAuthString()."&json=".$json
        );
        return $this->response = new PurchaseResponse($this, $httpResponse->getBody()->getContents());
    }
}
