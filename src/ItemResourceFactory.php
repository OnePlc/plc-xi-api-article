<?php
namespace Item;

use Application\Form\FormService;
use Application\Form\FormServiceFactory;

class ItemResourceFactory
{
    public function __invoke($services)
    {
        return new ItemResource(
            new ItemTableGateway('item', $services->get('api')),
            (new FormServiceFactory())->__invoke($services)
        );
    }
}
