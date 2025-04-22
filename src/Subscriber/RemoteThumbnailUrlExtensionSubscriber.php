<?php

declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxShopwareImageProxy\Subscriber;

use nlxShopwareImageProxy\DTO\ImageProxyOptionDTO;
use nlxShopwareImageProxy\Services\UrlGeneratorInterface;
use Shopware\Core\Content\Media\Extension\ResolveRemoteThumbnailUrlExtension;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(ResolveRemoteThumbnailUrlExtension::NAME . '.pre')]
class RemoteThumbnailUrlExtensionSubscriber
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function __invoke(ResolveRemoteThumbnailUrlExtension $extension): void
    {
        $extension->stopPropagation();

        $extension->result = $this->urlGenerator->generateUrl(
            $extension->mediaPath,
            new ImageProxyOptionDTO(width: $extension->width, height: $extension->height),
        );
    }
}
