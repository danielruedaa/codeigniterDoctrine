<?php
use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\DBAL\Logging\EchoSQLLogger;

class Doctrine {

    public $em = null;

    public function __construct()
    {
        //cargamos la configuración de base de datos de codeigniter
        require APPPATH . "config/database.php";


        //utilizamos el namespace Entities para mapear el directorio models
        $entitiesClassLoader = new ClassLoader('Entities', rtrim(APPPATH . "models" ));
        $entitiesClassLoader->register();

        // para repositrios
        $repositoriesClassLoader = new ClassLoader('Repositories', rtrim(APPPATH . "models" ));
        $repositoriesClassLoader->register();


        //utilizamos el namespace Proxies para mapear el directorio models/proxies
        $proxiesClassLoader = new ClassLoader('Proxies', APPPATH.'models/proxies');
        $proxiesClassLoader->register();

        // Configuración y chaché
        $config = new Configuration;
        $cache = new ArrayCache;
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(array(APPPATH.'models/entities'));
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);

        $config->setQueryCacheImpl($cache);

        // Configuración Proxy
        $config->setProxyDir(APPPATH.'/models/proxies');
        $config->setProxyNamespace('Proxies');

        // Habilitar el logger para obtener información de cada proceso
        $logger = new EchoSQLLogger;
        //$config->setSQLLogger($logger);

        $config->setAutoGenerateProxyClasses( TRUE );

        //configuramos la conexión con la base de datos utilizando las credenciales de nuestra app
        $connectionOptions = array(
            'driver' => 'pdo_mysql',
            'user' =>     $db["default"]["username"],
            'password' => $db["default"]["password"],
            'host' =>     $db["default"]["hostname"],
            'dbname' =>   $db["default"]["database"]
        );

        // Creamos el EntityManager
        $this->em = EntityManager::create($connectionOptions, $config);

    }
}
