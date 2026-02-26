<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Customer;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class CustomerDTO
{
    public function __construct(
        #[SerializedName('first_name')]
        public string $firstName,
        #[SerializedName('last_name')]
        public string $lastName,
        #[SerializedName('street_name')]
        public string $streetName,
        #[SerializedName('house_number')]
        public string $houseNumber,
        #[SerializedName('house_number_addition')]
        public ?string $houseNumberAddition,
        #[SerializedName('zip_code')]
        public string $zipCode,
        public string $city,
        #[SerializedName('country_code')]
        public string $countryCode,
        #[SerializedName('company_name')]
        public ?string $companyName,
        #[SerializedName('vat_number')]
        public ?string $vatNumber,
    ) {
    }
}
