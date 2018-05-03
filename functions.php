<?php
function connect_db() {
    $db = new PDO('mysql:host=localhost;dbname=global', 'amaximov', 'neto1730');
    $db->exec("SET NAMES UTF8");
    return $db;
}
?>
