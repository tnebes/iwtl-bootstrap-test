<?php

declare(strict_types=1);

define('APP_NAME', 'IWTL-B');
define('APP_AUTHOR', 'tnebes');

define('URL_ROOT', 'http://bootstrap.com');
define('APP_ROOT', dirname(dirname(__DIR__)));

define('DB_HOST', 'localhost');
define('DB_NAME', 'iwtl');
define('DB_USER', 'edunova');
define('DB_PASS', 'edunova');

// Constants for the database
define('PUBLIC_SQL_DATA', 'id, username, registrationDate');
define('PRIVATE_SQL_DATA', 'id, username, email, registrationDate, role, lastLogin, banned, dateBanned');

define('ADMIN_ROLE', 1);
