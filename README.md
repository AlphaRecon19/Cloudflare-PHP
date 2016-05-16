# Cloudflare-PHP

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AlphaRecon19/Cloudflare-PHP/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/AlphaRecon19/Cloudflare-PHP/?branch=master)

A simple PHP Library that allows you to interact with Cloudflare's API using [guzzle](https://github.com/guzzle/guzzle).
More information about endpoints can be found [here](https://api.cloudflare.com).

## Authentication
Information required to connect to Cloudflare's API are your API Key and Email,
these can be found in your My Account page within [cloudflare](https://www.cloudflare.com/a/account/my-account).
This by default is stored in the Cloudflare.yml file  located in the root of
your project. You can just copy the Cloudflare.yml.dist file replacing your
credentials there.

Alternatively, if this is not an option you can just pass these variables into
the Cloudflare class when you create it.

```php
$APIKEY = "1234567893feefc5f0q5000bfo0c38d90bbeb";
$Email = "example@example.com";

$Cloudflare = new Cloudflare\Cloudflare($APIKEY, $Email);
```
## Example - Getting users details
```php
<?php
require 'vendor/autoload.php';

$Cloudflare = new Cloudflare\Cloudflare();
$User = new Cloudflare\User($Cloudflare);

var_dump($User->get());
```