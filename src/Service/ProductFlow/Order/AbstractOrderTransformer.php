<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Order;

use Shopware\Core\Checkout\Order\OrderCollection;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

abstract readonly class AbstractOrderTransformer
{
    /**
     * @param EntityRepository<OrderCollection> $orderRepository
     */
    public function __construct(
        #[Autowire(service: 'order.repository')]
        protected EntityRepository $orderRepository,
    ) {
    }
}
