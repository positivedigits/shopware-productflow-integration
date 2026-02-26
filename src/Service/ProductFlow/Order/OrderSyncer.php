<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Order;

use PositiveDigits\DTO\Order\OrderResponseDTO;
use PositiveDigits\DTO\Order\OrdersResponseDTO;
use Shopware\Core\Framework\Context;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class OrderSyncer
{
    public function __construct(
        #[Autowire(service: ListOpenOrdersTransformer::class)]
        private AbstractOrderTransformer $listOpenOrdersTransformer,
        #[Autowire(service: OpenOrderTransformer::class)]
        private AbstractOrderTransformer $openOrderTransformer,
    ) {
    }

    public function listOpenOrders(OrderStatus $orderStatus, Context $context): OrdersResponseDTO
    {
        return $this->listOpenOrdersTransformer->transform($orderStatus, $context);
    }

    public function getOpenOrder(
        string $id,
        OrderStatus $orderStatus,
        Context $context,
    ): OrderResponseDTO {
        return $this->openOrderTransformer->transform($id, $orderStatus, $context);
    }
}
