<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Shipment;

use Shopware\Core\Checkout\Order\OrderCollection;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

abstract readonly class AbstractShipmentTransformer
{
    /**
     * @param EntityRepository<OrderCollection> $orderRepository
     */
    public function __construct(
        #[Autowire(service: 'order.repository')]
        protected EntityRepository $orderRepository,
    ) {
    }

    protected function getOrderByExternalId(string $externalId, Context $context): OrderEntity
    {
        $criteria = new Criteria([$externalId])
            ->addAssociation('deliveries');

        /** @var ?OrderEntity $order */
        $order = $this->orderRepository->search($criteria, $context)->first();

        if (null === $order) {
            throw new BadRequestException("No such order for external identifier '{$externalId}'.");
        }

        return $order;
    }
}
