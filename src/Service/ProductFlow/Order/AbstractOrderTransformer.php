<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Order;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

abstract readonly class AbstractOrderTransformer
{
    public function __construct(
        #[Autowire(service: 'order.repository')]
        protected EntityRepository $orderRepository,
    ) {
    }
}
