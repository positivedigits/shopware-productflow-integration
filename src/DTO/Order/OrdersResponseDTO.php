<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Order;

use Symfony\Component\Serializer\Attribute\SerializedName;

final class OrdersResponseDTO
{
    public function __construct(
        /** @var OrderDTO[] */
        #[SerializedName('data')]
        public array $orders = [],
    ) {
    }

    public function addOrder(OrderDTO $order): void
    {
        $this->orders[] = $order;
    }
}
