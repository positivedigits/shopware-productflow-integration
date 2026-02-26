<?php

declare(strict_types=1);

namespace PositiveDigits\Controller;

use PositiveDigits\Enum\OrderStatus;
use Shopware\Core\PlatformRequest;
use Shopware\Storefront\Framework\Routing\StorefrontRouteScope;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StorefrontRouteScope::ID]])]
final class OrderController extends AbstractController
{
    #[Route(path: '/orders', name: 'positivedigits.productflow.orders', methods: ['GET'])]
    public function orders(Request $request): Response
    {
        $status = $request->query->getEnum('status', OrderStatus::class);

        if (null === $status) {
            throw new BadRequestException('Missing required parameter "status".');
        }

        return new Response();
    }
}
