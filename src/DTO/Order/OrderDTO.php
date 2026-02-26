<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Order;

use PositiveDigits\DTO\Customer\CustomerDTO;
use Symfony\Component\Serializer\Attribute\SerializedName;

final class OrderDTO
{
    /**
     * @param string[] $customAttributes
     */
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        #[SerializedName('currency_code')]
        public ?string $currencyCode = null,
        #[SerializedName('placed_at')]
        public ?\DateTimeInterface $placedAt = null,
        public ?string $email = null,
        #[SerializedName('phone_number')]
        public ?string $phoneNumber = null,
        #[SerializedName('shipping_cost')]
        public ?int $shippingCost = null,
        #[SerializedName('shipping_vat_commission')]
        public ?int $shippingVatCommission = null,
        #[SerializedName('transaction_price')]
        public ?int $transactionPrice = null,
        #[SerializedName('transaction_vat_commission')]
        public ?int $transactionVatCommission = null,
        #[SerializedName('discount_price')]
        public ?int $discountPrice = null,
        #[SerializedName('discount_vat_commission')]
        public ?int $discountVatCommission = null,
        #[SerializedName('additional_price')]
        public ?int $additionalPrice = null,
        #[SerializedName('additional_vat_commission')]
        public ?int $additionalVatCommission = null,
        #[SerializedName('shipping_method')]
        public ?string $shippingMethod = null,
        #[SerializedName('payment_method')]
        public ?string $paymentMethod = null,
        public ?string $comment = null,
        #[SerializedName('custom_attributes')]
        public array $customAttributes = [],
        #[SerializedName('billing_customer')]
        public ?CustomerDTO $billingCustomer = null,
        #[SerializedName('shipping_customer')]
        public ?CustomerDTO $shippingCustomer = null,
        /** @var OrderLineDTO[] */
        #[SerializedName('lines')]
        public array $orderLines = [],
    ) {
    }

    public function addOrderLine(OrderLineDTO $orderLineDTO): void
    {
        $this->orderLines[] = $orderLineDTO;
    }
}
