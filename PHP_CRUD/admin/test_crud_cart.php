<?php

require_once "../config/config.php";
require_once "crud_cart.php";

$result = create_cart($database, '2', '1000', '1');
echo "Create cart ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = create_cart($database, '2', '3', '1');
echo "Create cart ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = create_cart($database, '50', '3', '1');
echo "Create cart ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = create_cart($database, '1000', '3', '1');
echo "Create cart ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = read_cart_by_id($database, '3');
echo "Found " . ($result->rowCount()) . " entries!" . PHP_EOL;

$result = delete_cart_by_id($database, '10');
echo "Delete id ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = list_all_carts($database);
echo "Found " . ($result->rowCount()) . " entries!" . PHP_EOL;

// test_crud_user.php