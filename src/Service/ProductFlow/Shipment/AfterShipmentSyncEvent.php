<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Shipment;

use PositiveDigits\DTO\Shipment\ShipmentRequestDTO;
use Shopware\Core\Framework\Context;

final readonly class AfterShipmentSyncEvent
{
    /**
     * @param array<string, mixed> $orderData
     */
    public function __construct(
        private ShipmentRequestDTO $shipmentRequestDTO,
        private array $orderData,
        private Context $context,
    ) {
    }

    public function getShipmentRequestDTO(): ShipmentRequestDTO
    {
        return $this->shipmentRequestDTO;
    }

    /**
     * @return array<string, mixed>
     */
    public function getOrderData(): array
    {
        return $this->orderData;
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
