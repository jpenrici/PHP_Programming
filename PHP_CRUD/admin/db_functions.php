<?php
// FUNCTIONS FOR DATABASE.
// Reference: https://www.php.net/docs.php

function connect($hostname, $dbname, $user, $password)
{
    try {
        $pdo = new PDO(/* dsn - Data Source Name */ "mysql:host=" . $hostname . ";dbname=" . $dbname, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    return null;
}

function command($pdo, $sql)
{
    // Check entries
    if (empty($sql)) {
        return null;
    }

    if (is_null($pdo) || is_null($sql)) {
        return null;
    }

    try {
        // echo $sql . PHP_EOL;
        return $pdo->query($sql);
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    return null;
}

// db_functions.php