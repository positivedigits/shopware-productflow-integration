<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Order;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class OrderLineDTO
{
    public function __construct(
        #[SerializedName('external_identifier')]
        public ?string $externalIdentifier = null,
        public ?string $title = null,
        public ?string $sku = null,
        public ?string $ean = null,
        public ?int $quantity = null,
        public ?int $price = null,
        #[SerializedName('base_price')]
        public ?int $basePrice = null,
        #[SerializedName('fee_fixed')]
        public ?int $fixedFee = null,
        #[SerializedName('channel_vat_commission')]
        public ?int $channelVatCommission = null,
        #[SerializedName('custom_attributes')]
        public array $customAttributes = [],
    ) {
    }
}
