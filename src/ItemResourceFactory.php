<?php
namespace Item;

class ItemResourceFactory
{
    public function __invoke($services)
    {
        return new ItemResource(new ItemTableGateway('item', $services->get('api')));
    }
}
