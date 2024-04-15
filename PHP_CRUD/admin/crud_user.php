<?php

require_once 'db_functions.php';

function create_user($database, $username, $email, $password1, $password2)
{
    $result = null;

    // Check entries
    if (is_null_or_empty($database)) {
        return false;
    }

    if (is_null_or_empty([$username, $email, $password1, $password2])) {
        return false;
    }

    if ($password1 != $password2) {
        return false;
    }

    // Connect
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Find
    $sql = "SELECT * FROM `user` WHERE BINARY `username` = '" . $username . "';";
    $result = command($pdo, $sql);
    if ($result) {
        $count = $result->rowCount();
        if ($count > 0) {
            // echo "Found " . $count . " entries for " . $username . "! New user has not been created!" . PHP_EOL;
            return false;
        }
    }

    // Create
    $sql = "INSERT INTO `user` (`id`, `username`, `email`, `password`, `administrator`, `createdAt`, `updatedAt`) ";
    $sql .= "VALUES (NULL, '" . $username . "', '" . $email . "', '" . $password1 . "', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";
    $result = command($pdo, $sql);

    // Exit
    $pdo = null;

    return !is_null($result);
}

function read_user_by_username($database, $username)
{
    $result = null;

    // Check entries
    if (is_null_or_empty($database)) {
        return null;
    }

    if (is_null_or_empty($username)) {
        return null;
    }

    // Connect
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Find
    $sql = "SELECT * FROM `user` WHERE BINARY `username` = '" . $username . "';";
    $result = command($pdo, $sql);

    // Exit
    $pdo = null;

    return $result;
}

function update_user_by_id($database, $id, $username, $email, $password)
{
    $result = null;

    // Check entries
    if (is_null_or_empty($database)) {
        return false;
    }

    if (is_null_or_empty($id)) {
        return false;
    }

    // Connect
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Find
    $result = find_by_id($pdo, 'user', $id);
    if ($result) {
        // Update
        $data = $result->fetch(PDO::FETCH_ASSOC);
        $new_username = (empty($username) || is_null($username)) ? $data['username'] : $username;
        $new_email = (empty($email) || is_null($email)) ? $data['email'] : $email;
        $new_password = (empty($password) || is_null($password)) ? $data['password'] : $password;
        $updateAt = date("Y-m-d H:i:s");
        // echo "Values: " . $id . ", " . $new_username . ", " . $new_email . ", " . $new_password . ", " . $updateAt . PHP_EOL;

        $sql = "UPDATE `user` SET `username` = '" . $new_username . "', `email` = '" . $new_email . "', ";
        $sql .= "`password` = '" . $new_password . "', `updatedAt` = '" . $updateAt . "' WHERE `user`.`id` = " . $id . ";";
        $result = command($pdo, $sql);
    }

    // Exit
    $pdo = null;

    return !is_null($result);
}

function delete_user_by_id($database, $id)
{
    return delete_by_id($database['hostname'], $database['dbname'], $database['user'], $database['password'], 'user', $id);
}

function list_all_users($database)
{
    return list_all_itens($database['hostname'], $database['dbname'], $database['user'], $database['password'], 'user');
}

// crud_user.php