<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Order;

use Shopware\Core\Checkout\Order\Aggregate\OrderTransaction\OrderTransactionStates;

enum OrderStatus: string
{
    case OPEN = 'open';
    case PAID = 'paid';

    public function toShopwareStatus(): string
    {
        return match ($this) {
            OrderStatus::OPEN => OrderTransactionStates::STATE_OPEN,
            OrderStatus::PAID => OrderTransactionStates::STATE_PAID,
        };
    }
}
