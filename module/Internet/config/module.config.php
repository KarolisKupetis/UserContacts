<?php
return [
    'service_manager' => [
        'factories' => [
            \Internet\V1\Rest\Contacts\ContactsResource::class => \Internet\V1\Rest\Contacts\ContactsResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'internet.rest.contacts' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/internet/users/:id/contacts',
                    'defaults' => [
                        'controller' => 'Internet\\V1\\Rest\\Contacts\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'internet.rest.contacts',
        ],
    ],
    'zf-rest' => [
        'Internet\\V1\\Rest\\Contacts\\Controller' => [
            'listener' => \Internet\V1\Rest\Contacts\ContactsResource::class,
            'route_name' => 'internet.rest.contacts',
            'route_identifier_name' => 'contacts_id',
            'collection_name' => 'contacts',
            'entity_http_methods' => [
                0 => 'POST',
                1 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Internet\V1\Rest\Contacts\ContactsEntity::class,
            'collection_class' => \Internet\V1\Rest\Contacts\ContactsCollection::class,
            'service_name' => 'contacts',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Internet\\V1\\Rest\\Contacts\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Internet\\V1\\Rest\\Contacts\\Controller' => [
                0 => 'application/vnd.internet.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Internet\\V1\\Rest\\Contacts\\Controller' => [
                0 => 'application/vnd.internet.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Internet\V1\Rest\Contacts\ContactsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'internet.rest.contacts',
                'route_identifier_name' => 'contacts_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Internet\V1\Rest\Contacts\ContactsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'internet.rest.contacts',
                'route_identifier_name' => 'contacts_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'Internet\\V1\\Rest\\Contacts\\Controller' => [
            'input_filter' => 'Internet\\V1\\Rest\\Contacts\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Internet\\V1\\Rest\\Contacts\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\NotEmpty::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'phone_number',
                'description' => 'Phone number of user.',
                'field_type' => 'string',
                'error_message' => 'Invalid phone number',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\NotEmpty::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'adress',
                'description' => 'Users adress',
                'field_type' => 'string',
                'error_message' => 'Invalid adress',
            ],
        ],
    ],
];
