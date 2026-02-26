<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Offer;

final readonly class OfferIdentifierDTO
{
    public function __construct(
        public string $sku,
        public ?string $ean = null,
        public ?string $mpn = null,
    ) {
    }
}
