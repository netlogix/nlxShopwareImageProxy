<?php

declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxShopwareImageProxy\DTO;

class ImageProxyOptionDTO
{
    public function __construct(
        public readonly string $width,
        public readonly string $height,
    ) {
    }
}
