<?php

declare(strict_types=1);

namespace PositiveDigits\Controller;

use PositiveDigits\DTO\Offer\OfferRequestDTO;
use PositiveDigits\EventListener\ProductFlowTokenValidationEventListener;
use PositiveDigits\Service\ProductFlow\Offer\OfferSyncer;
use Shopware\Core\Framework\Context;
use Shopware\Core\PlatformRequest;
use Shopware\Storefront\Framework\Routing\StorefrontRouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

#[Route(defaults: [
    PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StorefrontRouteScope::ID],
    ProductFlowTokenValidationEventListener::TOKEN_VALIDATION_REQUIRED => true,
])]
final class OffersController extends AbstractController
{
    public function __construct(
        private readonly OfferSyncer $offerSyncer,
    ) {
    }

    #[Route(path: '/offer', name: 'positivedigits.productflow.offers.upsert', methods: ['POST'])]
    public function upsert(
        #[MapRequestPayload(acceptFormat: JsonEncoder::FORMAT)]
        OfferRequestDTO $offerRequest,
        Context $context,
    ): Response {
        $this->offerSyncer->sync($offerRequest, $context);

        return new Response();
    }

    #[Route(path: '/offer', name: 'positivedigits.productflow.offers.delete', methods: ['DELETE'])]
    public function delete(
        #[MapRequestPayload(acceptFormat: JsonEncoder::FORMAT)]
        OfferRequestDTO $offerRequest,
        Context $context,
    ): Response {
        return new Response();
    }
}
