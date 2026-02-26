<?php

declare(strict_types=1);

namespace PositiveDigits\DTO\Offer;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class OfferRequestDTO
{
    public function __construct(
        #[SerializedName('identifiers')]
        public OfferIdentifierDTO $identifier,
        public OfferDTO $offer,
    ) {
    }
}
