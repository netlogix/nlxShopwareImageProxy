<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace Unit\Subscriber;

use nlxShopwareImageProxy\Services\UrlGenerator;
use nlxShopwareImageProxy\Subscriber\RemoteThumbnailUrlExtensionSubscriber;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Media\Extension\ResolveRemoteThumbnailUrlExtension;

#[CoversClass(RemoteThumbnailUrlExtensionSubscriber::class)]
#[CoversClass(UrlGenerator::class)]
class RemoteThumbnailUrlExtensionSubscriberTest extends TestCase
{
    private RemoteThumbnailUrlExtensionSubscriber $subject;

    protected function setUp(): void
    {
        $urlGenerator = new UrlGenerator(
            imgProxySecret: 'aabbccddeeff00112233445566778899',
            imgProxySalt: '11223344556677889900aabbccddeeff',
            imageProxyHost: 'https://image-proxy.example.com'
        );

        $this->subject = new RemoteThumbnailUrlExtensionSubscriber($urlGenerator);
    }

    public function testInvoke(): void
    {
        $extension = new ResolveRemoteThumbnailUrlExtension('media_url', 'test/image.jpg', '100', '100', 'pattern', null);
        $expectedUrlPattern = '/^https:\/\/image-proxy\.example\.com\/[a-zA-Z0-9_-]+\/resize:fit:\d+:\d+:no:0\/[a-zA-Z0-9_-]+$/';
        $this->subject->__invoke($extension);

        $this->assertTrue($extension->isPropagationStopped());

        $this->assertMatchesRegularExpression($expectedUrlPattern, $extension->result);
    }
}
