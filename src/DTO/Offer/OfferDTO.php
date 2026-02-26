<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Offer;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class OfferDTO
{
    public function __construct(
        #[SerializedName('qty_sellable')]
        public int $sellableQuantity,
        public int $price,
        #[SerializedName('base_price')]
        public ?int $basePrice = null,
        #[SerializedName('delivery_code')]
        public ?string $deliveryCode = null,
        public ?DiscountDTO $discount = null,
    ) {
    }
}
