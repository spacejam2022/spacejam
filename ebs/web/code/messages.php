<?php

require_once 'init.php';

if (!@$_SESSION['logged_in']) {
    header('Location: /auth.php');
    exit;
}

$messages = iterator_to_array($pdo->query("SELECT id, `date` FROM messages WHERE `date` > NOW() - INTERVAL 20 MINUTE ORDER BY `date` DESC", PDO::FETCH_OBJ));
array_walk($messages, function (&$item) {
    $item->id = intval($item->id);
});

header('Content-type: application/json');
echo json_encode($messages);
