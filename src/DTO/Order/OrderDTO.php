<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Order;

use PositiveDigits\DTO\Customer\CustomerDTO;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class OrderDTO
{
    public function __construct(
        public string $name,
        #[SerializedName('currency_code')]
        public string $currencyCode,
        #[SerializedName('placed_at')]
        public \DateTimeImmutable $placedAt,
        public string $email,
        #[SerializedName('phone_number')]
        public string $phoneNumber,
        #[SerializedName('shipping_cost')]
        public int $shippingCost,
        #[SerializedName('shipping_vat_commission')]
        public int $shippingVatCommission,
        #[SerializedName('transaction_price')]
        public int $transactionPrice,
        #[SerializedName('transaction_vat_commission')]
        public int $transactionVatCommission,
        #[SerializedName('discount_price')]
        public int $discountPrice,
        #[SerializedName('discount_vat_commission')]
        public int $discountVatCommission,
        #[SerializedName('additional_price')]
        public int $additionalPrice,
        #[SerializedName('additional_vat_commission')]
        public int $additionalVatCommission,
        #[SerializedName('shipping_method')]
        public string $shippingMethod,
        #[SerializedName('payment_method')]
        public string $paymentMethod,
        public ?string $comment,
        #[SerializedName('custom_attributes')]
        public array $customAttributes,
        #[SerializedName('billing_customer')]
        public CustomerDTO $billingCustomer,
        #[SerializedName('shipping_customer')]
        public CustomerDTO $shippingCustomer,

        /** @var OrderLineDTO[] */
        #[SerializedName('lines')]
        public array $orderLines,
    ) {
    }
}
