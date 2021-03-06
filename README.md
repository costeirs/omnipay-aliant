# omnipay-aliant

## Aliant driver for the Omnipay PHP payment processing library

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic,
multi-gateway payment processing library for PHP.
This package implements Aliant support for Omnipay.
This version only supports PHP 7.1+.

## Usage

### Create new invoice

```php
// Create the gateway
$gateway = Omnipay::create('Aliant');

// Initialise the gateway
$gateway->initialize([
    'username' => 'YOUR-USERNAME',
    'password' => 'YOUR-PASSWORD',
    'testMode' => false,
));

// create a new invoice
$request = $gateway->purchase([
    'amount' => 10,
    'email' => 'example@example.com',
    'returnUrl' => 'http://.../complete'
]);

// returns data regarding the created invoice (i.e. id)
$response = $request->send();

// redirect to hosted invoice page
$response->redirect();
```

### See status of existing invoice

```php
// check on status of invoice
$status = $gateway->fetchTransaction([
    'transactionReference' => 101118
]);

var_dump($status);
```

### Refund an existing invoice

```php
$status = $gateway->refund([
    'transactionReference' => 101118
]);

var_dump($status);
```
