<?php
namespace Omnipay\Aliant;

/**
 * Appease omnipay test gods
 */
trait AccountTrait
{

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($username)
    {
        return $this->setParameter('username', $username);
    }
    
    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($password)
    {
        return $this->setParameter('password', $password);
    }
}
