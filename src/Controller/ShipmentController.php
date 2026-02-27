<?php

declare(strict_types=1);

namespace PositiveDigits\Controller;

use PositiveDigits\DTO\Shipment\ShipmentRequestDTO;
use PositiveDigits\EventListener\ProductFlowTokenValidationEventListener;
use PositiveDigits\Routing\ProductFlowRouteScope;
use PositiveDigits\Service\ProductFlow\Shipment\ShipmentSyncer;
use Shopware\Core\Framework\Context;
use Shopware\Core\PlatformRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

#[Route(defaults: [
    PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [ProductFlowRouteScope::ID],
    ProductFlowTokenValidationEventListener::TOKEN_VALIDATION_REQUIRED => true,
])]
final class ShipmentController extends AbstractProductFlowController
{
    public function __construct(
        private readonly ShipmentSyncer $shipmentSyncer,
    ) {
    }

    #[Route(path: '/shipments', name: 'positivedigits.productflow.shipments', methods: ['POST'])]
    public function shipments(
        #[MapRequestPayload(acceptFormat: JsonEncoder::FORMAT)]
        ShipmentRequestDTO $shipmentRequestDTO,
        Context $context,
    ): Response {
        $this->shipmentSyncer->sync($shipmentRequestDTO, $context);

        return new Response();
    }
}
