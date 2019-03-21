<?php
return [
    \Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory::class => [
        \UserContacts\Validator\UserContactsValidator::class => [],
        0 => \User\Repository\UserRepository::class,
        1 => \UserContacts\Repository\UserContactsRepository::class,
        \UserContacts\Creator\UserContactsCreator::class => [
            0 => \Doctrine\ORM\EntityManager::class,
        ],
        \UserContacts\Editor\UserContactsEditor::class => [
            0 => \Doctrine\ORM\EntityManager::class,
        ],
        \User\Service\UserService::class => [
            0 => \User\Repository\UserRepository::class,
        ],
        \UserContacts\Service\UserContactsService::class => [
            0 => \UserContacts\Repository\UserContactsRepository::class,
            1 => \UserContacts\Creator\UserContactsCreator::class,
            2 => \User\Service\UserService::class,
            3 => \UserContacts\Validator\UserContactsValidator::class,
            4 => \UserContacts\Editor\UserContactsEditor::class,
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            0 => \Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory::class,
            1 => \UserContacts\Repository\AbstractRepositoryFactory::class,
        ],
        'factories' => [
            \UserContacts\Repository\UserContactsRepository::class => \UserContacts\Repository\AbstractRepositoryFactory::class,
            \User\Repository\UserRepository::class => \UserContacts\Repository\AbstractRepositoryFactory::class,
            \UserContactsAPI\V1\Rest\UserContacts\UserContactsResource::class => \UserContactsAPI\V1\Rest\UserContacts\UserContactsResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'user-contacts-api.rest.user-contacts' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/company/users/:id/contacts[/:user_contacts_id]',
                    'defaults' => [
                        'controller' => 'UserContactsAPI\\V1\\Rest\\UserContacts\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            1 => 'user-contacts-api.rest.user-contacts',
        ],
    ],
    'zf-rest' => [
        'UserContactsAPI\\V1\\Rest\\UserContacts\\Controller' => [
            'listener' => \UserContactsAPI\V1\Rest\UserContacts\UserContactsResource::class,
            'route_name' => 'user-contacts-api.rest.user-contacts',
            'route_identifier_name' => 'user_contacts_id',
            'collection_name' => 'user_contacts',
            'entity_http_methods' => [
                0 => 'POST',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'POST',
                1 => 'PUT',
                2 => 'PATCH',
                3 => 'GET',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \UserContactsAPI\V1\Rest\UserContacts\UserContactsEntity::class,
            'collection_class' => \UserContactsAPI\V1\Rest\UserContacts\UserContactsCollection::class,
            'service_name' => 'UserContacts',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'UserContactsAPI\\V1\\Rest\\UserContacts\\Controller' => 'Json',
        ],
        'accept_whitelist' => [
            'UserContactsAPI\\V1\\Rest\\UserContacts\\Controller' => [
                0 => 'application/vnd.user-contacts-api.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'UserContactsAPI\\V1\\Rest\\UserContacts\\Controller' => [
                0 => 'application/vnd.user-contacts-api.v1+json',
                1 => 'application/json',
                2 => 'multipart/form-data',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \UserContactsAPI\V1\Rest\UserContacts\UserContactsEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user-contacts-api.rest.user-contacts',
                'route_identifier_name' => 'user_contacts_id',
                'hydrator' => \Zend\Hydrator\ObjectProperty::class,
            ],
            \UserContactsAPI\V1\Rest\UserContacts\UserContactsCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'user-contacts-api.rest.user-contacts',
                'route_identifier_name' => 'user_contacts_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-content-validation' => [
        'UserContactsAPI\\V1\\Rest\\UserContacts\\Controller' => [
            'input_filter' => 'UserContactsAPI\\V1\\Rest\\UserContacts\\Validator',
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
                'name' => 'address',
                'description' => '',
                'field_type' => 'string',
                'error_message' => 'Invalid address',
            ],
        ],
        'UserContactsAPI\\V1\\Rest\\UserContacts\\Validator' => [
            0 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'address',
                'description' => 'users address',
            ],
            1 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'id',
                'field_type' => 'int',
            ],
            2 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'phoneNumber',
            ],
            3 => [
                'required' => false,
                'validators' => [],
                'filters' => [],
                'name' => 'userId',
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'UserContactsAPI\\V1\\Rest\\UserContacts\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
            ],
        ],
    ],
];
