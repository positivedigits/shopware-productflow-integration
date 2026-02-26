<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Order;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class OrderLineDTO
{
    public function __construct(
        #[SerializedName('external_identifier')]
        public string $externalIdentifier,
        public string $title,
        public string $sku,
        public string $ean,
        public int $quantity,
        public int $price,
        #[SerializedName('base_price')]
        public int $basePrice,
        #[SerializedName('fee_fixed')]
        public int $feeFixed,
        #[SerializedName('channel_vat_commission')]
        public int $channelVatCommission,
        #[SerializedName('custom_attributes')]
        public array $customAttributes,
    ) {
    }
}
