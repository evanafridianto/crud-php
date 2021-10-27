<?php
defined('env') or exit('Akses langsung ke Skrip ini diblokir');

$setDb['db_host'] = 'localhost';
$setDb['db_name'] = 'mahasiswa';
$setDb['db_user'] = 'root';
$setDb['db_password'] = '';

// folder templates
$template = 'templates/soft-ui-dashboard/';

//session
$setSession['prefix'] = 'crud-php';

//URI
$setUri['base'] = 'http://localhost/crud-php/';
$setUri['assets'] = 'assets/';
