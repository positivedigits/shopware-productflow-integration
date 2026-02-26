<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Offer;

final readonly class DiscountVolumeDTO
{
    public function __construct(
        public int $quantity,
        public int $price,
    ) {
    }
}
