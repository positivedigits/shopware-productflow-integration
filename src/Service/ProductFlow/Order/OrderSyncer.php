<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Order;

use PositiveDigits\DTO\Order\OrderResponseDTO;
use PositiveDigits\DTO\Order\OrdersResponseDTO;
use Shopware\Core\Framework\Context;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final readonly class OrderSyncer
{
    /**
     * @param ListOpenOrdersTransformer $listOpenOrdersTransformer
     * @param OpenOrderTransformer      $openOrderTransformer
     */
    public function __construct(
        #[Autowire(service: ListOpenOrdersTransformer::class)]
        private AbstractOrderTransformer $listOpenOrdersTransformer,
        #[Autowire(service: OpenOrderTransformer::class)]
        private AbstractOrderTransformer $openOrderTransformer,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function listOpenOrders(OrderStatus $orderStatus, Context $context): OrdersResponseDTO
    {
        $ordersResponseDTO = $this->listOpenOrdersTransformer->transform($orderStatus, $context);

        $this->eventDispatcher->dispatch(new AfterListOpenOrderEvent($orderStatus, $ordersResponseDTO, $context));

        return $ordersResponseDTO;
    }

    public function getOpenOrder(
        string $id,
        OrderStatus $orderStatus,
        Context $context,
    ): OrderResponseDTO {
        return $this->openOrderTransformer->transform($id, $orderStatus, $context);
    }
}
