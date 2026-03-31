<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Order;

use PositiveDigits\DTO\Order\OrdersResponseDTO;
use Shopware\Core\Framework\Context;

final readonly class AfterListOpenOrderEvent
{
    public function __construct(
        private OrderStatus $orderStatus,
        private OrdersResponseDTO $ordersResponseDTO,
        private Context $context,
    ) {
    }

    public function getOrderStatus(): OrderStatus
    {
        return $this->orderStatus;
    }

    public function getOrdersResponseDTO(): OrdersResponseDTO
    {
        return $this->ordersResponseDTO;
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
