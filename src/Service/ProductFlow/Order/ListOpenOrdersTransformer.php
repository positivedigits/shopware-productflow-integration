<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Order;

use PositiveDigits\DTO\Order\OrderDTO;
use PositiveDigits\DTO\Order\OrdersResponseDTO;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

readonly class ListOpenOrdersTransformer extends AbstractOrderTransformer
{
    public function transform(OrderStatus $orderStatus, Context $context): OrdersResponseDTO
    {
        $orders = $this->getOpenOrders($orderStatus, $context);

        $orderResponse = new OrdersResponseDTO();

        foreach ($orders as $order) {
            $order = new OrderDTO(
                id: $order->getId(),
            );

            unset($order->customAttributes);
            unset($order->orderLines);

            $orderResponse->addOrder($order);
        }

        return $orderResponse;
    }

    /**
     * @return EntityCollection<OrderEntity>
     */
    private function getOpenOrders(OrderStatus $orderStatus, Context $context): EntityCollection
    {
        $criteria = new Criteria()
            ->addFilter(new EqualsFilter('stateMachineState.technicalName', $orderStatus->toShopwareStatus()));

        /** @var EntityCollection<OrderEntity> $orders */
        $orders = $this->orderRepository->search($criteria, $context)->getEntities();

        return $orders;
    }
}
