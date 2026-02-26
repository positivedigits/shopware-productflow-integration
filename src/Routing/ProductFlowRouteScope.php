<?php

declare(strict_types=1);

namespace PositiveDigits\Routing;

use Shopware\Core\Framework\Routing\AbstractRouteScope;
use Shopware\Core\Framework\Routing\SalesChannelContextRouteScopeDependant;
use Symfony\Component\HttpFoundation\Request;

class ProductFlowRouteScope extends AbstractRouteScope implements SalesChannelContextRouteScopeDependant
{
    final public const string ID = 'productflow';

    public function isAllowed(Request $request): bool
    {
        return $request->headers->has('Authorization');
    }

    public function getId(): string
    {
        return self::ID;
    }
}
