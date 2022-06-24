<?php

define('URL', 'http://localhost/StudentAttendanceSystem/');
define('LIBS', 'libs/');
define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/StudentAttendanceSystem/public/uploads/');
define('PUBLIC_DIR', $_SERVER['DOCUMENT_ROOT'] . '/StudentAttendanceSystem/public/');
define('BACKUP_DIR', $_SERVER['DOCUMENT_ROOT'] . '/StudentAttendanceSystem/backups/');
define('ESTABLISHMENT', 'IoT Attendance System');
define('DESCRIPTION', 'IoT Attendance System');
define('PRINT_ORIENTATION', 'P');
define('PRINT_PAPER_SIZE', 'LEGAL');
define('MYSQL_EXE', realpath('../../mysql/bin/mysql.exe'));
define('MYSQL_DUMP_EXE', realpath('../../mysql/bin/mysqldump.exe'));
define('MYSQL_EXE_CUSTOM', 'C:\xampp\mysql\bin\mysql.exe');
define('MYSQL_DUMP_EXE_CUSTOM', 'C:\xampp\mysql\bin\mysqldump.exe');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_StudentAttendanceSystem');
define('DB_USER', 'root');
define('DB_PASS', '');

define('HASH_GENERAL_KEY', '|StudentAttendanceSystem|');
define('HASH_PASSWORD_KEY', 'SuenosReachYourDreams');
