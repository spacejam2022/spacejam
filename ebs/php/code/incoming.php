<?php

require_once 'init.php';

$result = ['success' => false, 'error' => ''];

if (count(array_intersect(array_keys($_POST), ['briefing', 'signature'])) == 2) {
    $raw_briefing = $_POST['briefing'];
    $briefing = json_decode($raw_briefing);
    if ($briefing) {
        if (isset($briefing->from) && isset($briefing->message)) {
            $signature = $_POST['signature'];
            $secrets = json_decode(file_get_contents('/data/passwords.json'));
            $hash = hash_hmac('sha256', $raw_briefing, $secrets->signature_secret);
            if (strtolower($hash) == strtolower($signature)) {
                $pdo->query("INSERT INTO messages (`from`, message) VALUES ('{$briefing->from}', '{$briefing->message}')");
                $result['success'] = true;
                $result['id'] = intval($pdo->lastInsertId());
            } else {
                $result['error'] = "Invalid signature";
            }
        } else {
            $result['error'] = "Missing from and/or message fields in briefing";
        }
    } else {
        $result['error'] = "Cannot parse briefing JSON data";
    }
} else {
    $result['error'] = "Missing briefing and/or signature parameter(s)";
}
header('Content-type: application/json');
if (!$result['success']) {
    header('HTTP/1.0 400 Bad request');
}
echo json_encode($result);
