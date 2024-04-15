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

function is_null_or_empty($data)
{
    // Test does not observe complex objects.
    if (is_array($data)) {
        foreach ($data as $value) {
            if (is_null($value) || empty($value)) {
                return true;
            }
        }
        return false;
    }

    return (is_null($data) || empty($data));
}

function list_all_itens($hostname, $dbname, $user, $password, $table)
{
    $result = null;

    // Check entries
    if (is_null_or_empty([$hostname, $dbname, $user, $password, $table])) {
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
    if (is_null_or_empty([$hostname, $dbname, $user, $password, $table, $id])) {
        return false;
    }

    // Connect
    $pdo = connect($hostname, $dbname, $user, $password);

    // Find
    $sql = "SELECT `id` FROM `" . $table . "` WHERE `id` = '" . $id . "';";
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

function find_by_id($pdo, $table, $id)
{
    $result = null;

    // Check entries
    if (is_null($pdo)) {
        return null;
    }

    if (is_null_or_empty([$table, $id])) {
        return null;
    }

    $sql = "SELECT * FROM `" . $table . "` WHERE `id` = '" . $id . "';";
    $result = command($pdo, $sql);
    if ($result) {
        $count = $result->rowCount();
        if ($count != 1) {
            // echo "Found in " . $table . ", " . $count . " entries for " . $id . "!" . PHP_EOL;
            return null;
        }
    }

    return $result;
}

// db_functions.php