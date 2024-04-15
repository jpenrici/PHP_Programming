<?php

require_once "../config/config.php";
require_once "crud_product.php";

$result = create_product($database, "car", "remote control car", "-20", "No number", "", "", "");
echo "Create product ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = read_product_by_name($database, "CAR");
echo "Found " . ($result->rowCount()) . " entries!" . PHP_EOL;

$result = update_product_by_id($database, "1", "car", "smartphone control car", "-20", "-20", "-20", "", "3");
echo "Update id ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = update_product_by_id($database, "1", "car", "smartphone control car", "20.5", "10", "1000", "", "3");
echo "Update id ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = delete_product_by_id($database, '10');
echo "Delete id ... " . ($result ? "ok" : "ignored") . PHP_EOL;

$result = list_all_products($database);
echo "Found " . ($result->rowCount()) . " entries!" . PHP_EOL;

// test_crud_product.php