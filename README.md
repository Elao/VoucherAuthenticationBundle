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
# routing.yml
elao_voucher_authentication:
    resource: "@ElaoVoucherAuthenticationBundle/Resources/config/routing.xml"
    prefix:   /
```

__Note:__ You can also declare your own route as long as you specify the corresponding `check_path` and `token_parameter` parameters in your voucher security configuration (see "Custom voucher route").

## Usage

### Enabling voucher authentication

The Voucher Authentication bundle porvider a `voucher` security provider.

You can enable voucher authentication very simply in your `security.yml`:

```yml
security:
    firewalls:
        main:
            voucher: ~
```

### Generate a voucher token in your app

Create a new `VoucherInterface` (you can use the provided `DisposableAuthenticationVoucher` implementation or make your own).
Then get its token with `getToken()` and, for example, send it to the user by email:

```php
use Elao\Bundle\VoucherAuthenticationBundle\Voucher\DisposableAuthenticationVoucher;

class SecurityController extends Controller {
    /**
     * @Route("forgot-password", name="forgot_password")
     */
    public function forgotPasswordAction()
    {
        $voucher = new DisposableAuthenticationVoucher('jane_doe', '+1 hour');
        $activationUrl = $this->generateUrl('voucher', ['token' => $voucher->getToken()]);

        // Don't forget to persist the voucher, or the user won't be able to log in.
        $this->get('elao_voucher_authentication.voucher_provider.default')->persist($voucher);

        $this->mailer->sendResetPasswordEmail($activationUrl);
    }
}
```

### Generate a voucher token from CLI

Generate a voucher for the given username (optionally set a time-to-live):

    bin/console voucher:generate:authenticatio [username] (--ttl="+1 hour")

Will result in:

> Authentication voucher for user admin with expiration on  2016-11-15 13:42:24: 6fb11ec1eecd07865d940dd0f990d66b

### Restricting user access using vouchers

You can protect a route, or any part of you app, by requiring a specific voucher authentication.
For exameple, you can allow the route to reset password only to users authenticated via a Voucher with intent `reset_password`.

Use the following security expression: `is_granted('voucher', $intent)` where $intent is the intent you provided to your `Voucher` object.

```php
class SecurityController extends Controller
{
    /**
     * @Route("reset_password", name="reset_password")
     * @Security("is_granted('voucher', 'password')")
     */
    public function resetPasswordAction() {}
}

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

## Custom voucher route

```yml
# routing.yml
my_voucher_route:
    path: /activate/{my_token}
```

```yml
security:
    firewalls:
        main:
            voucher:
                check_path: my_voucher_route
                token_parameter: my_token
```
