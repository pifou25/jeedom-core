<?php

use Jeedom\Core\Arrays\ArrayAccess;

// un objet ArrayAccess tout seul n'a pas d'intérêt, la fonction __() est appelée dès l'initialisation
// avec un objet Trad ce n'est pas forcément le cas
function __(string $key, string $file = __FILE__, bool $backslash = false, string $prefix = '', string $suffix = '') {
    echo "\t$key\n";
    return $prefix. str_replace("\'", "'", $key) .$suffix;
}

include  __DIR__ . '/../../src/Arrays/ArrayAccess.php';
include  __DIR__ . '/../../core/config/jeedom.config.php';

echo "\n  fin d'initialisation\n";

print_r( $JEEDOM_INTERNAL_CONFIG['eqLogic']['category']['heating']['icon']);
foreach( $JEEDOM_INTERNAL_CONFIG['eqLogic']['category'] as $key => $value) {
    $icon = $value['icon'];
    $name = $value['name'];
    echo "\t$key === $name --- $icon\n";
}