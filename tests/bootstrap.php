<?php

echo "
 ____  _   _ ____  _   _ _   _ ___ _____       _               _                   _____         _   ____        _ _       
|  _ \| | | |  _ \| | | | \ | |_ _|_   _|     | | ___  ___  __| | ___  _ __ ___   |_   _|__  ___| |_/ ___| _   _(_) |_ ___ 
| |_) | |_| | |_) | | | |  \| || |  | |    _  | |/ _ \/ _ \/ _` |/ _ \| '_ ` _ \    | |/ _ \/ __| __\___ \| | | | | __/ _ \
|  __/|  _  |  __/| |_| | |\  || |  | |   | |_| |  __/  __/ (_| | (_) | | | | | |   | |  __/\__ \ |_ ___) | |_| | | ||  __/
|_|   |_| |_|_|    \___/|_| \_|___| |_|    \___/ \___|\___|\__,_|\___/|_| |_| |_|   |_|\___||___/\__|____/ \__,_|_|\__\___|
                                                                                                                           
";

// create configuration file
file_put_contents('core/config/common.config.php', 
"
/* * ********************* Debug **************** */
define('DEBUG', 1);

/* * *********************** MySQL & Memcached ******************* */
global \$CONFIG;
\$CONFIG = array(
	'db' => array(
		// 'unix_socket' => '/run/mysqld/mysqld.sock',
		'host' => 'db',
		'port' => '3306',
		'dbname' => 'jeedom',
		'username' => 'jeedom',
		'password' => 'jeedom',
	),
);
");

echo "Include Jeedom Core & autoloader...";
require_once __DIR__ . "/../core/php/core.inc.php";
