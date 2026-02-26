<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Customer;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class CustomerDTO
{
    public function __construct(
        #[SerializedName('first_name')]
        public ?string $firstName = null,
        #[SerializedName('last_name')]
        public ?string $lastName = null,
        #[SerializedName('street_name')]
        public ?string $streetName = null,
        #[SerializedName('house_number')]
        public ?string $houseNumber = null,
        #[SerializedName('house_number_addition')]
        public ?string $houseNumberAddition = null,
        #[SerializedName('zip_code')]
        public ?string $zipCode = null,
        public ?string $city = null,
        #[SerializedName('country_code')]
        public ?string $countryCode = null,
        #[SerializedName('company_name')]
        public ?string $companyName = null,
        #[SerializedName('vat_number')]
        public ?string $vatNumber = null,
    ) {
    }
}
