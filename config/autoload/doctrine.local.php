<?php
// entity.manager.php
$paths = array(__DIR__ . '/../module/Application/src/Application/Entity', /* add more as needed */ );

// external namespaces to reference
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

// event related namespaces
use Application\Listeners\OnFlushListener;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Events;

// get event manager instance + listener
$evm = new EventManager();
$evm->addEventListener(array(Events::onFlush), new OnFlushListener());

$driver = new AnnotationDriver(new AnnotationReader(), $paths);
AnnotationRegistry::registerLoader('class_exists');

$config   = Setup::createConfiguration(TRUE);
$config->setMetadataDriverImpl($driver);

$dbParams = array(
        'driver' => 'pdo_mysql',
        'dsn' => 'mysql:dbname=sweetscomplete;host=localhost',
        'dbname' => 'sweetscomplete',
        'user' => 'test',
    	'password' => 'password',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8 COLLATE utf8_unicode_ci"
        )        
);


return array(
    'service_manager' => [
        'services' => [
            'doctrine.entitymanager.orm_default' => EntityManager::create($dbParams, $config, $evm),
        ]
    ],
);
