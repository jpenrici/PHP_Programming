<?php

require_once "../config/config.php";
// var_dump($database);

require_once "crud_user.php";

$username = "user1";

$result = create_user($database, $username, "$username@provedor1.com", "123", "123");
echo "Create user ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = read_user_by_username($database, $username);
echo "Found " . ($result->rowCount()) . " entries for " . $username . "!" . PHP_EOL;

$result = update_user_by_id($database, '10', "", "newemail@provedor1.com", "");
echo "Update id ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = delete_user_by_id($database, '10');
echo "Delete id ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = list_all_users($database);
echo "Found " . ($result->rowCount()) . " entries!" . PHP_EOL;

// test_crud_user.php