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

    protected function getBillingData()
    {
        $data = array();
        if ($card = $this->getCard()) {
            if (!empty($card->getBillingName())) {
                $data['name'] = $card->getBillingName();
            } else {
                $data['name'] = $card->getBillingFirstName().' '.$card->getBillingLastName();
            }
            $data['phone'] = $card->getBillingPhone();
            $data['email'] = $card->getEmail();
            $data['address'] = $card->getBillingAddress1();
            $data['city'] = $card->getBillingCity();
            $data['state'] = $card->getBillingState();
            $data['zip'] = $card->getBillingPostcode();
            $data['country'] = $card->getBillingCountry();
        }
        return $data;
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
            'email' => $this->getEmail(),
            'email_it' => $this->getSendInvoice(),
            'sandbox' => $this->getTestMode(),
        );
        
        $data = array_merge($data, $this->getBillingData());

        $data = array_filter($data, 'strlen');
        
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
