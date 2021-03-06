<?php

declare(strict_types=1);

const APP_NAME = 'IWTL-B';
const APP_AUTHOR = 'tnebes';

const URL_ROOT = 'http://bootstrap.com';
define('APP_ROOT', dirname(__DIR__, 2));
define('UPLOAD_PATH', APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR);

const DB_HOST = 'localhost';
const DB_NAME = 'iwtl';
const DB_USER = 'edunova';
const DB_PASS = 'edunova';

// Constants for the database
const PUBLIC_SQL_DATA = 'id, username, registrationDate';
const PRIVATE_SQL_DATA = 'id, username, email, registrationDate, role, lastLogin, banned, dateBanned';
const ENTRIES_PER_PAGE = 10;
// it is best not to change this constant.
const PAGINATION_BUTTONS = 4;

const FILE_UPLOAD_SIZE = 3000000;

const ADMIN_ROLE = 1;
