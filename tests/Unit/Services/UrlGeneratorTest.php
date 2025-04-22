<?php

declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace Tests\Unit\Services;

use nlxShopwareImageProxy\DTO\ImageProxyOptionDTO;
use nlxShopwareImageProxy\Services\UrlGenerator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UrlGenerator::class)]
#[CoversClass(ImageProxyOptionDTO::class)]
class UrlGeneratorTest extends TestCase
{
    private UrlGenerator $subject;

    protected function setUp(): void
    {
        $this->subject = new UrlGenerator(
            imgProxySecret: 'aabbccddeeff00112233445566778899',
            imgProxySalt: '11223344556677889900aabbccddeeff',
            imageProxyHost: 'https://image-proxy.example.com'
        );
    }

    public function testGenerateUrlWithoutOptions(): void
    {
        $imagePath = 'test/image.jpg';
        $expectedUrlPattern = '/^https:\/\/image-proxy\.example\.com\/[a-zA-Z0-9_-]+\/[a-zA-Z0-9_-]+$/';

        $generatedUrl = $this->subject->generateUrl($imagePath);

        $this->assertMatchesRegularExpression($expectedUrlPattern, $generatedUrl);
    }

    public function testGenerateUrlWithOptions(): void
    {
        $imagePath = 'test/image.jpg';
        $imageProxyOption = new ImageProxyOptionDTO(width: '200', height: '300');
        $expectedUrlPattern = '/^https:\/\/image-proxy\.example\.com\/[a-zA-Z0-9_-]+\/resize:fit:\d+:\d+:no:0\/[a-zA-Z0-9_-]+$/';;

        $generatedUrl = $this->subject->generateUrl($imagePath, $imageProxyOption);

        $this->assertMatchesRegularExpression($expectedUrlPattern, $generatedUrl);
    }
}
