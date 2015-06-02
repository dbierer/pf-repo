<?php
namespace Application\Config;

// external namespaces to reference
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\EventManager;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\MongoDBCache;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Base
{
    
    const CACHE_NAMESPACE = 'Doctrine\Common\Cache\\';
    
    protected $cache;
    protected $em;
    protected $params;
    protected $driver;
    protected $eventManager;
    
    public function __construct($params)
    {

        // cache
        $this->cache = new \stdClass();
        if (isset($params['cache']['class'])) {
            $this->cache = $this->buildCache($params['cache']['class'], $params['cache']['params']);
        }

        // NOTE: for development it is recommended to use ArrayCache
        $this->driver = new AnnotationDriver(new AnnotationReader(), $params['entityDirs']);
        AnnotationRegistry::registerLoader('class_exists');

        // see: http://docs.doctrine-project.org/en/latest/reference/advanced-configuration.html
        $this->config = Setup::createConfiguration(FALSE);
        $this->config->setMetadataDriverImpl($this->driver);

        // CACHE CONFIG
        $this->config->setQueryCacheImpl($this->cache);
        $this->config->setMetadataCacheImpl($this->cache);

        // PROXY CONFIG
        // set auto generation to TRUE for development
        //$config->setAutoGenerateProxyClasses(true);
        // set auto generation to FALSE for production
        // to generate proxies, use this command:
        // doctrine orm:generate-proxies
        $this->config->setProxyDir($params['proxyDir']);
        $this->config->setAutoGenerateProxyClasses($params['autoGenerateProxy']);
        
        // set entity manager
        if (isset($params['event-manager'])) {
            $this->em = EntityManager::create($params['db'], $this->config, $params['event-manager']);
        } else {
            $this->em = EntityManager::create($params['db'], $this->config, new EventManager());
        }
    }

    protected function buildCache($target, $params)
    {
        $class = self::CACHE_NAMESPACE . $target;
        switch ($target) {
            case 'ArrayCache' :
            case 'ApcCache' :
            case 'WinCacheCache' :
            case 'XcacheCache' :
            case 'ZendDataCache' :
                $cache = new $class;
                break;
            case 'PhpFileCache' :
            case 'FilesystemCache' :
                $cache = new $class($params['dir'], $params['ext']);
                break;
            case 'MongoDBCache' :
                // NOTE: expects an instance of MongoCollection
                $collection = $params['collection']();
                $cache = new $class($collection);
                break;
            case 'PredisCache' :
                // NOTE: expects and instance of Predis\Client
                $cache = new $class($params['client']);
                break;
            case 'RiakCache' :
                // NOTE: expects and instance of \Riak\Bucket
                $cache = new $class($params['bucket']);
                break;
            case 'SQLite3Cache' :
                // NOTE: expects and instance of \SQLite3
                $cache = new $class($params['sqlite'], $params['table']);
                break;
            case 'Memcache' :
                $driver = self::CACHE_NAMESPACE . $params['driver'];
                $temp   = new $class;
                $temp->connect($params['host'], $params['port']);
                $cache = new $driver;
                $cache->setMemcache($driver);                    
                break;
            case 'Memcached' :
                $driver = self::CACHE_NAMESPACE . $params['driver'];
                $temp   = new $class;
                $temp->addServer($params['host'], $params['port']);
                $cache = new $driver;
                $cache->setMemcached($driver);                    
                break;
            case 'RedisCache' :
                $driver = self::CACHE_NAMESPACE . $params['driver'];
                $temp   = new $class;
                $temp->connect($params['host'], $params['port']);
                $cache = new $driver;
                $cache->setRedis($driver);                    
                break;
            default :
                $cache = new $class;
        }
        return $cache;
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    public function getEm()
    {
        return $this->em;
    }

    public function setEm($em)
    {
        $this->em = $em;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    public function getEventManager()
    {
        if (!$this->eventManager) {
            $this->eventManager = new EventManager();
        }
        return $this->eventManager;
    }

}
