<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Order;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class OrderResponseDTO
{
    public function __construct(
        #[SerializedName('data')]
        public OrderDTO $order,
    ) {
    }
}
