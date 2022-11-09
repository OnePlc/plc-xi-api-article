<?php
namespace Item;

class ItemResourceFactory
{
    public function __invoke($services)
    {
        return new ItemResource();
    }
}
