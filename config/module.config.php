<?php
return [
    'service_manager' => [
        'factories' => [
            \Item\ItemResource::class => \Item\ItemResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'item.rest.item' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/item[/:item_id]',
                    'defaults' => [
                        'controller' => 'Item\\V1\\Rest\\Item\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'item.rest.item',
        ],
    ],
    'api-tools-rest' => [
        'Item\\V1\\Rest\\Item\\Controller' => [
            'listener' => \Item\ItemResource::class,
            'route_name' => 'item.rest.item',
            'route_identifier_name' => 'item_id',
            'collection_name' => 'item',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Item\ItemEntity::class,
            'collection_class' => \Item\ItemCollection::class,
            'service_name' => 'Item',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Item\\V1\\Rest\\Item\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Item\\V1\\Rest\\Item\\Controller' => [
                0 => 'application/vnd.item.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Item\\V1\\Rest\\Item\\Controller' => [
                0 => 'application/vnd.item.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \Item\ItemEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'item.rest.item',
                'route_identifier_name' => 'item_id',
                'hydrator' => \Laminas\Hydrator\ObjectPropertyHydrator::class,
            ],
            \Item\ItemCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'item.rest.item',
                'route_identifier_name' => 'item_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authentication' => [
            'map' => [
                'Item\\V1' => 'api',
            ],
        ],
        'authorization' => [
            'Item\\V1\\Rest\\Item\\Controller' => [
                'collection' => [
                    'GET' => true,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => true,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'Item\\V1\\Rest\\Item\\Controller' => [
            'input_filter' => 'Item\\V1\\Rest\\Item\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Item\\V1\\Rest\\Item\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'items',
                'field_type' => '',
                'description' => 'List of Items',
                'allow_empty' => true,
            ],
            1 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'ack',
                'description' => 'asdad',
            ],
        ],
    ],
];
