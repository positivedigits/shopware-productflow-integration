<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Offer;

final readonly class OfferIdentifierDTO
{
    public function __construct(
        public string $sku,
        public string $ean,
        public string $mpn,
    ) {
    }
}
