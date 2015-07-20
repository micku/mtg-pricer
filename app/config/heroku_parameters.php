<?php

/*
$db = parse_url($_ENV['CLEARDB_DATABASE_URL']);
$container->setParameter('database_driver', 'pdo_mysql');
$container->setParameter('database_host', $db['host']);
$container->setParameter('database_port', $db['port']);
$container->setParameter('database_name', trim($db['path'], '/'));
$container->setParameter('database_user', $db['user']);
$container->setParameter('database_password', $db['pass']);
 */

$container->setParameter('mongodb_server', $_ENV['MONGOLAB_URI']);
$container->setParameter('mongodb_default_database', $_ENV['MONGOLAB_DB']);
$container->setParameter('mkm_app_token', $_ENV['MKM_APP_TOKEN']);
$container->setParameter('mkm_app_secret', $_ENV['MKM_APP_SECRET']);
$container->setParameter('mkm_access_token', $_ENV['MKM_ACCESS_TOKEN']);
$container->setParameter('mkm_access_secret', $_ENV['MKM_ACCESS_SECRET']);
