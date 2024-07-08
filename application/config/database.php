<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	// Offline development
	'username' => 'root',
	'password' => '',

	// Online Production
	// 'username' => 'kina3126_absensi',
	// 'password' => 'kanpa2020',

	'database' => 'weddingku',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

// $capsule = new Capsule;
// $capsule->addConnection([
//     'driver'    => 'mysql',
//     'host'      => 'localhost',
//     'database'  => 'denah_project_db',
//     'username'  => 'root',
//     'password'  => 'root',
//     'charset'   => 'utf8',
//     'collation' => 'utf8_general_ci',
//     'prefix'    => '',
// ]);
// // Set the event dispatcher used by Eloquent models... (optional)
// $capsule->setEventDispatcher(new Dispatcher(new Container));
// // Make this Capsule instance available globally via static methods... (optional)
// $capsule->setAsGlobal();
// // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
// $capsule->bootEloquent();