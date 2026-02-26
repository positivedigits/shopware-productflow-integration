<?php

declare(strict_types=1);

namespace PositiveDigits\Controller;

use PositiveDigits\EventListener\ProductFlowTokenValidationEventListener;
use PositiveDigits\Routing\ProductFlowRouteScope;
use PositiveDigits\Service\ProductFlow\Order\OrderStatus;
use PositiveDigits\Service\ProductFlow\Order\OrderSyncer;
use Shopware\Core\Framework\Context;
use Shopware\Core\PlatformRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route(defaults: [
    PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [ProductFlowRouteScope::ID],
    ProductFlowTokenValidationEventListener::TOKEN_VALIDATION_REQUIRED => true,
])]
final class OrderController extends AbstractProductFlowController
{
    public function __construct(
        private readonly OrderSyncer $orderSyncer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route(path: '/orders', name: 'positivedigits.productflow.orders', methods: ['GET'])]
    public function orders(Request $request, Context $context): Response
    {
        $status = $request->query->getEnum('status', OrderStatus::class);

        if (null === $status) {
            throw new BadRequestException('Missing required parameter "status".');
        }

        $orderResponseDTO = $this->orderSyncer->listOpenOrders($status, $context);

        return $this->serializedJsonResponse($orderResponseDTO);
    }

    #[Route(path: '/orders/{id}', name: 'positivedigits.productflow.order', methods: ['GET'])]
    public function order(string $id, Request $request, Context $context): Response
    {
        $status = $request->query->getEnum('status', OrderStatus::class);

        if (null === $status) {
            throw new BadRequestException('Missing required parameter "status".');
        }

        $orderResponseDTO = $this->orderSyncer->getOpenOrder($id, $status, $context);

        return $this->serializedJsonResponse($orderResponseDTO);
    }
}
