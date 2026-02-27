<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Shipment;

use PositiveDigits\DTO\Shipment\ShipmentRequestDTO;
use Shopware\Core\Framework\Context;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

readonly class ShipmentTransformer extends AbstractShipmentTransformer
{
    public function transform(ShipmentRequestDTO $shipmentRequest, Context $context): array /* @phpstan-ignore-line */
    {
        $externalIdentifier = $shipmentRequest->order?->externalIdentifier;

        if (null === $externalIdentifier) {
            throw new BadRequestException('No such order for external identifier provided.');
        }

        $order = $this->getOrderByExternalId($shipmentRequest->order->externalIdentifier, $context);

        return [
            'id' => $order->getId(),
            'deliveries' => [
                [
                    'id' => $order->getDeliveries()?->last()?->getId(),
                    'trackingCodes' => [
                        $shipmentRequest->trackAndTrace,
                    ],
                ],
            ],
        ];
    }
}
