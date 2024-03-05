<?php

$response = "Nothing to report!";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $response = $_POST['username'] . " : " . $_POST['password'];
    }
}

echo "<h1>" . $response . "</h1>";
