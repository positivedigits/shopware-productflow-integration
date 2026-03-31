<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Shipment;

use PositiveDigits\DTO\Shipment\ShipmentRequestDTO;
use Shopware\Core\Checkout\Order\OrderCollection;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final readonly class ShipmentSyncer
{
    /**
     * @param ShipmentTransformer               $shipmentTransformer
     * @param EntityRepository<OrderCollection> $orderRepository
     */
    public function __construct(
        #[Autowire(service: ShipmentTransformer::class)]
        private AbstractShipmentTransformer $shipmentTransformer,
        #[Autowire(service: 'order.repository')]
        private EntityRepository $orderRepository,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function sync(ShipmentRequestDTO $shipmentRequest, Context $context): void
    {
        $orderData = $this->shipmentTransformer->transform($shipmentRequest, $context);

        $this->orderRepository->update([$orderData], $context);

        $this->eventDispatcher->dispatch(new AfterShipmentSyncEvent($shipmentRequest, $orderData, $context));
    }
}
