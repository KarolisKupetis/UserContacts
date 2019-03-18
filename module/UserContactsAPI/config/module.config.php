<?php

return [
    \Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory::class => [
        \Users\Repository\UsersRepository::class,
       \UserContacts\Repository\UserContactsRepository::class,

        \UserContacts\Creator\UserContactsCreator::class=>[
            \Doctrine\ORM\EntityManager::class,
        ],

        \Users\Service\UserService::class=>[
            \Users\Repository\UsersRepository::class,
        ],

        \UserContacts\Service\UserContactsService::class=>[
            \UserContacts\Repository\UserContactsRepository::class,
            \UserContacts\Creator\UserContactsCreator::class,
            \Users\Service\UserService::class,
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            0 => \Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory::class,
            1 => \UserContacts\Repository\AbstractRepositoryFactory::class,
        ],
        'factories' => [
            \UserContacts\Repository\UserContactsRepository::class => \UserContacts\Repository\AbstractRepositoryFactory::class,
            \Users\Repository\UsersRepository::class => \UserContacts\Repository\AbstractRepositoryFactory::class,
            \UserContactsAPI\V1\Rest\Usercontacts\UsercontactsResource::class => \UserContactsAPI\V1\Rest\Usercontacts\UsercontactsResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'user-contacts-api.rest.usercontacts' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/company/users/:id/contacts',
                    'defaults' => [
                        'controller' => 'UserContactsAPI\\V1\\Rest\\Usercontacts\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'user-contacts-api.rest.usercontacts',
        ],
    ],
    'zf-rest' => [
        'UserContactsAPI\\V1\\Rest\\Usercontacts\\Controller' => [
            'listener' => \UserContactsAPI\V1\Rest\Usercontacts\UsercontactsResource::class,
            'route_name' => 'user-contacts-api.rest.usercontacts',
            'route_identifier_name' => 'usercontacts_id',
            'collection_name' => 'usercontacts',
            'entity_http_methods' => [
                0 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \UserContactsAPI\V1\Rest\Usercontacts\UsercontactsEntity::class,
            'collection_class' => \UserContactsAPI\V1\Rest\Usercontacts\UsercontactsCollection::class,
            'service_name' => 'Usercontacts',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'UserContactsAPI\\V1\\Rest\\Usercontacts\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'UserContactsAPI\\V1\\Rest\\Usercontacts\\Controller' => [
                0 => 'application/vnd.user-contacts-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'UserContactsAPI\\V1\\Rest\\Usercontacts\\Controller' => [
                0 => 'application/vnd.user-contacts-api.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \UserContactsAPI\V1\Rest\Usercontacts\UsercontactsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user-contacts-api.rest.usercontacts',
                'route_identifier_name' => 'usercontacts_id',
                'hydrator' => \Zend\Hydrator\Reflection::class,
            ],
            \UserContactsAPI\V1\Rest\Usercontacts\UsercontactsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user-contacts-api.rest.usercontacts',
                'route_identifier_name' => 'usercontacts_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'UserContactsAPI\\V1\\Rest\\Usercontacts\\Controller' => [
            'input_filter' => 'UserContactsAPI\\V1\\Rest\\Usercontacts\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'UserContactsAPI\\V1\\Rest\\Usercontacts\\Validator' => [
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
                'description' => 'Users phone number.',
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
