<?php
// entity.manager.php
$paths = array(__DIR__ . '/../module/Application/src/Application/Entity', /* add more as needed */ );

// external namespaces to reference
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$driver = new AnnotationDriver(new AnnotationReader(), $paths);
AnnotationRegistry::registerLoader('class_exists');

// NOTE: use "createXMLMetadataConfiguration()" for XML source
//       use "createYAMLMetadataConfiguration()" for YAML source
// NOTE: if the flag is set TRUE caching is done in memory
//       if set to FALSE, will try to use APC, Xcache, Memcache or Redis caching
//       see: http://docs.doctrine-project.org/en/latest/reference/advanced-configuration.html
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

return EntityManager::create($dbParams, $config);
