<?php

declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxShopwareImageProxy\Services;

use nlxShopwareImageProxy\DTO\ImageProxyOptionDTO;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UrlGenerator implements UrlGeneratorInterface
{
    public function __construct(
        #[Autowire(env: 'default::string:IMGPROXY_KEY')]
        private ?string $imgProxySecret,
        #[Autowire(env: 'default::string:IMGPROXY_SALT')]
        private ?string $imgProxySalt,
        #[Autowire(env: 'default::string:IMAGE_PROXY_HOST')]
        private ?string $imageProxyHost,
    ) {
        $this->imgProxySecret = pack("H*", $imgProxySecret);
        $this->imgProxySalt = pack("H*", $imgProxySalt);
    }

    public function generateUrl(string $imagePath, ?ImageProxyOptionDTO $imageProxyOption = null): string
    {
        $mediaPath = 'local://' . $imagePath;
        $path = rtrim(strtr(base64_encode($mediaPath), '+/', '-_'), '=');

        if ($imageProxyOption !== null) {
            $path = sprintf('resize:fit:%s:%s:no:0/%s', $imageProxyOption->width, $imageProxyOption->height, $path);
        }

        $sha256 = hash_hmac('sha256', $this->imgProxySalt . '/' . $path, $this->imgProxySecret, true);
        $sha256Encoded = base64_encode($sha256);
        $signature = str_replace(["+", "/", "="], ["-", "_", ""], $sha256Encoded);

        return sprintf('%s/%s/%s', $this->imageProxyHost, $signature, $path);
    }
}
