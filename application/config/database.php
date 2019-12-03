<?php
defined('BASEPATH') or exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	// 'hostname' => 'db-hosting.ub.ac.id',
	// 'username' => 'tcrb',
	// 'password' => '',
	// 'database' => 'oemah_laundry',
	// 'hostname' => 'localhost',
	// 'username' => 'root',
	// 'password' => '',
	// 'database' => 'oemah_laundry',
	// 'port'     => '3306',
	'hostname' => 'remotemysql.com',
	'username' => 'qbuI60rMlv',
	'password' => 'ckvoXVAtOw',
	'database' => 'qbuI60rMlv',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => FALSE,
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
