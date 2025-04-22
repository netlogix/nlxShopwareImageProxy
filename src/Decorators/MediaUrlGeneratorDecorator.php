<?php

declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxShopwareImageProxy\Decorators;

use nlxShopwareImageProxy\Services\UrlGeneratorInterface;
use Shopware\Core\Content\Media\Core\Application\AbstractMediaUrlGenerator;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: AbstractMediaUrlGenerator::class)]
class MediaUrlGeneratorDecorator extends AbstractMediaUrlGenerator
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function generate(array $paths): array
    {
        return array_map(function ($value) {
            return $this->urlGenerator->generateUrl($value->path);
        }, $paths);
    }
}
