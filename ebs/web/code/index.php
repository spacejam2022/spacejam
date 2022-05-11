<?php

require_once 'init.php';

if (!@$_SESSION['logged_in']) {
    header('Location: /api/auth');
    exit;
}

$messages = iterator_to_array($pdo->query('SELECT id, `date` FROM messages ORDER BY `date` DESC', PDO::FETCH_OBJ));

?><!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html lang="en"><head>
    <title>EBS - index</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500i,800i&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/style.css" type="text/css" />
    <link rel="shortcut icon" href="/assets/favicon.png" />
    <script language="JavaScript">
        function message_part(cls, content) {
            let element = document.createElement('div');
            element.className = cls;
            element.appendChild(document.createTextNode(content));
            return element;
        }
        function format_date(dateStr) {
            const date = new Date(dateStr.replace(/-/g, '/'));
            return date.toLocaleDateString('nl-NL').replace(/[/]/g, '-') + '  |  ' + date.toLocaleTimeString('nl-NL');
        }
        function load_message(id) {
            let httpRequest = new XMLHttpRequest();
            httpRequest.onreadystatechange = function(){
                if (httpRequest.readyState === XMLHttpRequest.DONE) {
                    if (httpRequest.status === 200) {
                        let briefing = JSON.parse(httpRequest.responseText);
                        let element = document.getElementById('briefing-content');
                        while (element.firstChild) {
                            element.removeChild(element.firstChild);
                        }
                        element.appendChild(message_part('content-header', format_date(briefing.date)));
                        element.appendChild(message_part('content-header', 'From: ' + briefing.from));
                        element.appendChild(message_part('content-message', briefing.message));
                    }
                }
            };
            httpRequest.open('GET', 'api/message?id=' + id, true);
            httpRequest.send();
        }
        let selectedElement = null;
        function load_messages() {
            let httpRequest = new XMLHttpRequest();
            httpRequest.onreadystatechange = function(){
                if (httpRequest.readyState === XMLHttpRequest.DONE) {
                    if (httpRequest.status === 200) {
                        let briefings = JSON.parse(httpRequest.responseText);
                        let element = document.getElementById('briefing-list');
                        while (element.firstChild) {
                            element.removeChild(element.firstChild);
                        }
                        briefings.forEach(briefing => {
                            let li = document.createElement('li');
                            let div = document.createElement('div');
                            let a = document.createElement('a');
                            a.style.cursor = 'pointer';
                            a.appendChild(document.createTextNode(format_date(briefing.date)));
                            a.onclick = () => {
                                if (selectedElement !== null) {
                                    selectedElement.className = '';
                                }
                                selectedElement = li;
                                li.className = 'selected';
                                load_message(briefing.id);
                            };
                            div.appendChild(a);
                            li.appendChild(div);
                            element.appendChild(li);
                        });
                    }
                }
            };
            httpRequest.open('GET', 'api/messages', true);
            httpRequest.send();
        }
        load_messages();
        window.onload = () => {
            if (navigator.userAgent.indexOf("Chrome") !== -1) {
                document.body.className = "chrome";
            }
        };
    </script>
</head><body>
<div id="header">
    <div class="row-top">EMERGENCY BROADCAST SYSTEM</div>
    <div class="row-bottom">CONTINENTAL SECURITY</div>
    <div class="logout-button row-middle">
        <a href="logout.php">
            <img src="/assets/pointer.png" alt="triangle" srcset="/assets/pointer.svg" />
            LOG OUT
            <img src="/assets/pointer.png" class="flip" alt="triangle" srcset="/assets/pointer.svg" />
        </a>
    </div>
</div>
<div class="separator"></div>
<div id="main">
    <div id="index-box">
        <div id="briefings" class="with-border no-padding">
            <div class="red-background">
                <h2>BRIEFINGS:</h2>
                <ul id="briefing-list">
                </ul>
            </div>
        </div>
        <div id="selected-briefing" class="with-border">
            <h2>SELECTED BRIEFING:</h2>
            <div id="briefing-content">
                <div class="content-message">
                    No briefing selected
                </div>
            </div>
        </div>
    </div>
</div>
</body></html>
