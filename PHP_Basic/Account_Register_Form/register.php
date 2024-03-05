<?php

$response = "Nothing to report!";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])) {
        $email = $_POST['email'];
        $psw  = $_POST['password1'];
        if ($psw == $_POST['password2']) {
            $response = "Registration confirmed!";
            $data = [
                // inputs
                'email' => $email,
                'password' => $psw,
                // some tests
                'md5' => md5($psw),
                'sha1' => sha1($psw),
                'crypt' => crypt($psw, salt: 'something&somethingelse&anything'),
            ];

            // var_dump($data);
            foreach ($data as $key => $value) {
                echo "$key : $value <br>";
            }
        }
    }
}

echo "<h1>" . $response . "</h1>";
