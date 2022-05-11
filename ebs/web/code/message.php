<?php

require_once 'init.php';

if (!@$_SESSION['logged_in']) {
    header('Location: /auth.php');
    exit;
}

$msg = iterator_to_array($pdo->query('SELECT id, `date`, `from`, message FROM messages WHERE id = ' . $_GET['id'], PDO::FETCH_OBJ))[0];
$msg->id = intval($msg->id);

header('Content-type: application/json');
echo json_encode($msg);
