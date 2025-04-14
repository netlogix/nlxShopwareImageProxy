<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace Tests\Unit\Decorators;

use nlxShopwareImageProxy\Decorators\MediaUrlGeneratorDecorator;
use nlxShopwareImageProxy\Services\UrlGenerator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Media\Core\Params\UrlParams;
use Shopware\Core\Content\Media\Core\Params\UrlParamsSource;

#[CoversClass(MediaUrlGeneratorDecorator::class)]
class MediaUrlGeneratorDecoratorTest extends TestCase
{
    private MediaUrlGeneratorDecorator $subject;

    protected function setUp(): void
    {
        $urlGenerator = new UrlGenerator(
            imgProxySecret: 'aabbccddeeff00112233445566778899',
            imgProxySalt: '11223344556677889900aabbccddeeff',
            imageProxyHost: 'https://image-proxy.example.com'
        );

        $this->subject = new MediaUrlGeneratorDecorator($urlGenerator);
    }

    public function testGenerate(): void
    {
        $paths = [
            new UrlParams('1', UrlParamsSource::MEDIA, 'test/image.jpg'),
            new UrlParams('2', UrlParamsSource::MEDIA, 'test/image2.jpg'),
        ];
        $expectedUrlPattern = '/^https:\/\/image-proxy\.example\.com\/[a-zA-Z0-9_-]+\/[a-zA-Z0-9_-]+$/';

        $result = $this->subject->generate($paths);

        $this->assertCount(2, $result);
        $this->assertMatchesRegularExpression($expectedUrlPattern, $result[0]);
        $this->assertMatchesRegularExpression($expectedUrlPattern, $result[1]);
    }
}
