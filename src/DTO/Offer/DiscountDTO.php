<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Offer;

final readonly class DiscountDTO
{
    public function __construct(
        public string $name,
        /** @var DiscountVolumeDTO[] */
        public array $volumes,
    ) {
    }
}
