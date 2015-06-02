<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller'    => 'application-controller-index',
                        'action'        => 'index',
                    ),
                ),
            ),
            'listener-test' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/listener',
                    'defaults' => array(
                        'controller'    => 'application-controller-index',
                        'action'        => 'listener-test',
                    ),
                ),
            ),
            'form-test' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/form',
                    'defaults' => array(
                        'controller'    => 'application-controller-index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'annotation' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/annotation[/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action'        => 'form-annotation',
                            ),
                        ),
                    ),
                    'fieldset' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/fieldset[/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action'        => 'form-fieldset',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'services' => array(
            'application-test' => array(1,2,3,4,5),
        ),
        'invokables' => array(
            'application-delegator-something-else' => 'Application\Delegator\SomethingElseDelegator',
            'application-entity-customer'          => 'Application\Entity\Customer',
            'application-service-customer'         => 'Application\Service\CustomerService',
            'application-doctrine-listener'        => 'Application\Listeners\DoctrineListener',
        ),
        'factories' => array(
            'ProfileFieldset'    => 'Application\Factory\FormProfileFactory',
            'PurchasesFieldset'  => 'Application\Factory\FormPurchasesFactory',
            'application-test-service'    => 'Application\Factory\TestServiceFactory',
            'application-form-annotation' => 'Application\Factory\FormAnnotationFactory',
            'application-form-fieldset'   => 'Application\Factory\FormFieldsetFactory',
            'application-repo-customer'   => 'Application\Factory\RepoFactory',
        ),
        'shared' => array(
            'PurchasesFieldset' => FALSE,
        ),
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'delegators' => array(
            'application-test-service' => array('application-delegator-something-else'),
        ),        
    ),
    'listeners' => array(
        'application-doctrine-listener',
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'application-controller-index' => 'Application\Factory\IndexControllerFactory'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
