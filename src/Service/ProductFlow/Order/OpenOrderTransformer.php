<?php

declare(strict_types=1);

namespace PositiveDigits\Service\ProductFlow\Order;

use PositiveDigits\DTO\Customer\CustomerDTO;
use PositiveDigits\DTO\Order\OrderDTO;
use PositiveDigits\DTO\Order\OrderLineDTO;
use PositiveDigits\DTO\Order\OrderResponseDTO;
use Shopware\Core\Checkout\Order\OrderEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final readonly class OpenOrderTransformer extends AbstractOrderTransformer
{
    public function transform(
        string $id,
        OrderStatus $orderStatus,
        Context $context,
    ): OrderResponseDTO {
        $orderEntity = $this->getOrder($id, $orderStatus, $context);
        $customerEntity = $orderEntity->getOrderCustomer();

        $orderDTO = new OrderDTO(
            name: $orderEntity->getOrderNumber(),
            currencyCode: $orderEntity->getCurrency()->getIsoCode(),
            placedAt: $orderEntity->getOrderDateTime(),
            email: $customerEntity->getEmail(),
            phoneNumber: $orderEntity->getBillingAddress()->getPhoneNumber(),
            shippingCost: (int) ($orderEntity->getShippingCosts()->getTotalPrice() * 100),
            shippingVatCommission: (int) ($orderEntity->getShippingCosts()->getCalculatedTaxes()->first()->getTax() * 100),
            shippingMethod: $orderEntity->getDeliveries()->last()->getShippingMethod()->getName(),
            paymentMethod: $orderEntity->getTransactions()->last()->getPaymentMethod()->getName(),
            comment: $orderEntity->getCustomerComment(),
            billingCustomer: new CustomerDTO(
                firstName: $customerEntity->getFirstName(),
                lastName: $customerEntity->getLastName(),
                streetName: $orderEntity->getBillingAddress()->getStreet(),
                zipCode: $orderEntity->getBillingAddress()->getZipcode(),
                city: $orderEntity->getBillingAddress()->getZipcode(),
                countryCode: $orderEntity->getBillingAddress()->getCountry()->getIso(),
                companyName: $orderEntity->getBillingAddress()->getCompany(),
                vatNumber: $orderEntity->getBillingAddress()->getVatId(),
            ),
            shippingCustomer: new CustomerDTO(
                firstName: $customerEntity->getFirstName(),
                lastName: $customerEntity->getLastName(),
                streetName: $orderEntity->getDeliveries()->getShippingAddress()->last()->getStreet(),
                zipCode: $orderEntity->getDeliveries()->getShippingAddress()->last()->getZipcode(),
                city: $orderEntity->getDeliveries()->getShippingAddress()->last()->getZipcode(),
                countryCode: $orderEntity->getDeliveries()->getShippingAddress()->last()->getCountry()->getIso(),
                companyName: $orderEntity->getDeliveries()->getShippingAddress()->last()->getCompany(),
                vatNumber: $orderEntity->getDeliveries()->getShippingAddress()->last()->getVatId(),
            ),
        );

        foreach ($orderEntity->getLineItems()->filterGoodsFlat() as $lineItem) {
            $orderDTO->addOrderLine(
                new OrderLineDTO(
                    externalIdentifier: $lineItem->getProductId(),
                    title: $lineItem->getProduct()->getName(),
                    sku: $lineItem->getProduct()->getProductNumber(),
                    ean: $lineItem->getProduct()->getEan(),
                    quantity: $lineItem->getQuantity(),
                    price: (int) ($lineItem->getTotalPrice() * 100),
                )
            );
        }

        return new OrderResponseDTO($orderDTO);
    }

    private function getOrder(
        string $id,
        OrderStatus $orderStatus,
        Context $context,
    ): OrderEntity {
        $criteria = new Criteria([$id])
            ->addFilter(new EqualsFilter('stateMachineState.technicalName', $orderStatus->toShopwareStatus()))
            ->addAssociation('currency')
            ->addAssociation('customer')
            ->addAssociation('billingAddress.country')
            ->addAssociation('deliveries.shippingMethod')
            ->addAssociation('deliveries.shippingOrderAddress.country')
            ->addAssociation('transactions.paymentMethod')
            ->addAssociation('lineItems.product');

        $order = $this->orderRepository->search($criteria, $context)->getEntities()->first();

        if (null === $order) {
            throw new BadRequestException("No such order with id '{$id}'.");
        }

        return $order;
    }
}
