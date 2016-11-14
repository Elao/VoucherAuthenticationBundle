# Elao Voucher Authentication Bundle ![](https://img.shields.io/badge/Symfony-3.0-blue.svg)

Provide authentication through vouchers (for email link).

## Installation

### Require the package through composer:

    composer require elao/voucher-authentication-bundle

### Register the bundle in your `app/AppKernel.php`:

```php
class AppKernel extends Kernel {
    public function registerBundles() {
        return [
            // ...
            new Elao\Bundle\VoucherAuthenticationBundle\ElaoVoucherAuthenticationBundle(),
        ];
    }
}
```

### Declare the voucher route

By importing the provided route configuration in your `app/config/routing.yml`:

```yml
elao_voucher_authentication:
    resource: "@ElaoVoucherAuthenticationBundle/Resources/config/routing.xml"
    prefix:   /
```

__Note:__ You can also declare your own route as long as you specify the corresponding `check_path` and `token_parameter` parameters in your voucher security configuration.

## Usage

The Voucher Authentication bundle porvider a `voucher` security provider.

You can enable voucher authentication very simply in your `security.yml`:

```yml
security:
    firewalls:
        main:
            voucher: ~
```

### Generate a voucher token from CLI

Generate a voucher for the given username (optionally set a time-to-live):

    bin/console elao:voucher:generate [username] (--ttl="+1 hour")

## Full configuration

```yml
security:
    firewalls:
        main:
            voucher:
                remember_me: true
                check_path: voucher
                use_forward: false
                require_previous_session: true
                token_parameter: token
                always_use_default_target_path: false
                default_target_path: /
                login_path: /login
                target_path_parameter: _target_path
                use_referer: false
                failure_path: null
                failure_forward: false
                failure_path_parameter: _failure_path
                voucher_provider: elao_voucher_authentication.voucher_provider.default
```
