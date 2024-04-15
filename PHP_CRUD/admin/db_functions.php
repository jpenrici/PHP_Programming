<?php
// FUNCTIONS FOR DATABASE.
// Reference: https://www.php.net/docs.php

function connect($hostname, $dbname, $user, $password)
{
    try {
        $pdo = new PDO(/* dsn - Data Source Name */"mysql:host=" . $hostname . ";dbname=" . $dbname, $user, $password);
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

function list_all_itens($hostname, $dbname, $user, $password, $table)
{
    $result = null;

    // Check entries
    if (is_null($hostname) || is_null($dbname) || is_null($user) || is_null($password) || is_null($table)) {
        return null;
    }

    if (empty($table)) {
        return null;
    }

    // Connect
    $pdo = connect($hostname, $dbname, $user, $password);

    // Find All
    $sql = "SELECT * FROM `" . $table . "`;";
    $result = command($pdo, $sql);

    // Exit
    $pdo = null;

    return $result;
}

function delete_by_id($hostname, $dbname, $user, $password, $table, $id)
{
    $result = null;

    // Check entries
    if (is_null($hostname) || is_null($dbname) || is_null($user) || is_null($password) || is_null($table) || is_null($id)) {
        return null;
    }

    if (empty($table)) {
        return null;
    }
    
    if (empty($id)) {
        return false;
    }

    // Connect
    $pdo = connect($hostname, $dbname, $user, $password);

    // Find
    $sql = "SELECT * FROM `" . $table . "` WHERE `id` = '" . $id . "';";
    $result = command($pdo, $sql);
    if ($result) {
        $count = $result->rowCount();
        if ($count != 1) {
            // echo "Found " . $count . " entries for " . $id . "!" . PHP_EOL;
            return false;
        }

        // Delete
        $sql = "DELETE FROM `" . $table . "` WHERE `" . $table . "`.`id` = '" . $id . "';";
        $result = command($pdo, $sql);
    }

    // Exit
    $pdo = null;

    return !is_null($result);    
}

// db_functions.php