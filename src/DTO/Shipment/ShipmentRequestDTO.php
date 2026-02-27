<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Shipment;

use PositiveDigits\DTO\Order\OrderDTO;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class ShipmentRequestDTO
{
    public function __construct(
        public ?string $identifier = null,
        #[SerializedName('track_and_trace')]
        public ?string $trackAndTrace = null,
        public ?string $method = null,
        public ?OrderDTO $order = null,
    ) {
    }
}
