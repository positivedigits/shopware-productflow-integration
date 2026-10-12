<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Order;

use Shopware\Core\Framework\Context;

final readonly class BeforeListOpenOrderEvent
{
    public function __construct(
        private OrderStatus $orderStatus,
        private Context $context,
    ) {
    }

    public function getOrderStatus(): OrderStatus
    {
        return $this->orderStatus;
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
