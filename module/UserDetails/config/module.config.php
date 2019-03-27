<?php

namespace UserDetails;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use User\Repository\UserRepository;
use User\Service\UserService;
use UserDetails\Creator\UserContactsCreator;
use UserDetails\Editor\UserContactsEditor;
use UserDetails\Entity\UserPosition;
use UserDetails\Repository\AbstractRepositoryFactory;
use UserDetails\Repository\UserContactsRepository;
use UserDetails\Service\UserContactsService;
use UserDetails\Service\UserPhoneNumberService;
use UserDetails\Service\UserPositionService;
use UserDetails\UserPhoneNumber\UserPhoneNumberCreator;
use UserDetails\Validator\UserContactsValidator;
use UserDetails\Creator\UserPositionCreator;
use UserDetails\Repository\UserPositionRepository;
use UserDetails\Validator\UserPositionValidator;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;

return [
    ConfigAbstractFactory::class => [
        UserContactsRepository::class => [],
        UserContactsValidator::class => [],
        UserRepository::class => [],
        UserPosition::class => [],
        UserPositionValidator::class => [],
        EntityManager::class => [],

        UserContactsEditor::class => [
            EntityManager::class,
            UserPhoneNumberService::class,
        ],

        UserService::class => [
            UserRepository::class,
        ],

        UserContactsCreator::class => [
            EntityManager::class,
            UserService::class,
            UserPhoneNumberService::class,
        ],

        UserPositionCreator::class => [
            EntityManager::class,
        ],

        UserPhoneNumberCreator::class=>[
            EntityManager::class,
        ],

        UserPhoneNumberService::class=>[
            UserPhoneNumberCreator::class,
            UserContactsValidator::class,
        ],

        UserPositionService::class => [
            UserPositionCreator::class,
            UserService::class,
            UserPositionValidator::class,
            UserPositionRepository::class,
        ],

        UserContactsService::class => [
            UserContactsRepository::class,
            UserContactsCreator::class,
            UserContactsValidator::class,
            UserContactsEditor::class,
            UserPhoneNumberService::class,
        ],


    ],
    'service_manager' => [
        'abstract_factories' => [
            0 => ConfigAbstractFactory::class,
            1 => AbstractRepositoryFactory::class,
        ],
        'factories' => [
            UserContactsRepository::class => AbstractRepositoryFactory::class,
            UserRepository::class => AbstractRepositoryFactory::class,
            UserPositionRepository::class => AbstractRepositoryFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'module-name-here' => [
                'type' => 'Literal',
                'options' => [
                    // Change this to something specific to your module
                    'route' => '/module-specific-root',
                    'defaults' => [

                        'action' => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    // You can place additional routes that match under the
                    // route defined above here.
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'ZendSkeletonModule' => __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];
