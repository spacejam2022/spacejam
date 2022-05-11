<?php

require_once 'init.php';

if (count(array_intersect(array_keys($_POST), ['user', 'pass'])) == 2) {

    $username = $_POST['user'];
    $password = $_POST['pass'];

    $stmt = $pdo->query("SELECT id FROM users WHERE username = '{$username}' AND password = '{$password}'");
    if (!$stmt) {
        header('Location: ?message=Login+failed');
        exit;
    }

    foreach ($stmt as $row) {
        $_SESSION['logged_in'] = 1;
        header('Location: /index.php');
        exit;
    }

    header('Location: ?message=Invalid+username+and%2for+password');
    exit;
}

?><!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html lang="en"><head>
    <title>EBS - login</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500i,800i&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/style.css" type="text/css" />
    <link rel="shortcut icon" href="/assets/favicon.png" />
</head><body>
<div id="header">
    <div>EMERGENCY BROADCAST SYSTEM</div>
    <div>CONTINENTAL SECURITY</div>
</div>
<div class="separator"></div>
<div id="main">
    <div class="login-box">
        <form action="/api/auth" method="post">
            <div class="with-border">
                <h1>EBS login</h1>
                <div class="center transparent">
                    Some text will go here.
                    It will not be more than a couple of lines of text.
                    I think a maximum of 1 or two parapgraphs.
                    It will say something about the system and prompt the user to login.
                </div>
                <div class="input-field">
                    <label for="inputUsername">username</label><br/>
                    <input id="inputUsername" type="text" name="user"/>
                </div>
                <div class="input-field">
                    <label for="inputPassword">password</label><br/>
                    <input id="inputPassword" type="password" name="pass"/>
                </div>
            </div>
            <?php if (array_key_exists('message', $_GET)) { ?>
                <div class="center bold red margin">
                    <?=htmlspecialchars($_GET['message'])?>
                </div>
            <?php } ?>
            <div class="login-button">
                <button type="submit">
                    <img src="/assets/pointer.png" alt="triangle" srcset="/assets/pointer.svg" />
                    LOG IN
                    <img src="/assets/pointer.png" class="flip" alt="triangle" srcset="/assets/pointer.svg" />
                </button>
            </div>
        </form>
    </div>
</div>
<div id="footer">EMERGENCY BROADCAST SYSTEM // CONTINENTAL SECURITY // EMERGENCY BROADCAST SYSTEM // CONTINENTAL SECURITY // EMERGENCY BROADCAST SYSTEM // CONTINENTAL SECURITY // EMERGENCY BROADCAST SYSTEM // CONTINENTAL SECURITY // EMERGENCY BROADCAST SYSTEM // CONTINENTAL SECURITY // EMERGENCY BROADCAST SYSTEM // CONTINENTAL SECURITY // EMERGENCY BROADCAST SYSTEM // CONTINENTAL SECURITY // EMERGENCY BROADCAST SYSTEM</div>
</body></html>
