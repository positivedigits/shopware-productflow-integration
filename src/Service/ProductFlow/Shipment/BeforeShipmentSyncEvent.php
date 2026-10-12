<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Shipment;

use PositiveDigits\DTO\Shipment\ShipmentRequestDTO;
use Shopware\Core\Framework\Context;

final readonly class BeforeShipmentSyncEvent
{
    public function __construct(
        private ShipmentRequestDTO $shipmentRequestDTO,
        private Context $context,
    ) {
    }

    public function getShipmentRequestDTO(): ShipmentRequestDTO
    {
        return $this->shipmentRequestDTO;
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
