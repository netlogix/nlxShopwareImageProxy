# nlxShopwreImageProxy

Plugin to allow shopware to authenticate and support image proxy

## Installation

```shell
composer require netlogix/nlxShopwreImageProxy
```

## Usage

Use the image proxy `darthsim/imgproxy` in your docker-compose file to quickly and easily resize images.

For signing URLs you have to define the following environment variables:
- IMGPROXY_KEY: hex-encoded key
- IMGPROXY_SALT: hex-encoded salt

For more information visit official documentation: https://docs.imgproxy.net/usage/signing_url
