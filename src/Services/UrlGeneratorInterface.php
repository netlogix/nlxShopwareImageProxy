<?php

declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxShopwareImageProxy\Services;

use nlxShopwareImageProxy\DTO\ImageProxyOptionDTO;

interface UrlGeneratorInterface
{
    public function generateUrl(string $imagePath, ?ImageProxyOptionDTO $imageProxyOption = null): string;
}
