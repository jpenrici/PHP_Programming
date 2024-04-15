<?php

require_once 'db_functions.php';
require_once 'crud_product.php';

function create_cart($database, $quantity, $user_id, $product_id)
{
    $result = null;

    // Check entries
    if (is_null_or_empty($database)) {
        return false;
    }

    if (is_null_or_empty([$quantity, $user_id, $product_id])) {
        return false;
    }

    // Connect
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Find and Check
    if (is_null(find_by_id($pdo, 'user', $user_id))) {
        return false;
    }

    $free = current_quantity($pdo, $product_id, $quantity);
    if ($free < 1) {
        return false;
    }

    // Create
    $sql = "INSERT INTO `shopping_cart` (`id`, `quantity`, `createdAt`, `updatedAt`, `user_id`, `product_id`) ";
    $sql .= "VALUES (NULL, '" . $quantity . "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '" . $user_id . "', '" . $product_id . "');";
    $result = command($pdo, $sql);

    // Update
    update_product_quantity_by_id($database, $product_id, $free);   // just for testing.

    // Exit
    $pdo = null;

    return !is_null($result);
}

function read_cart_by_id($database, $id)
{
    // Check entries
    if (is_null_or_empty($database)) {
        return null;
    }

    if (is_null_or_empty($id)) {
        return null;
    }

    // Connect
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);
    
    return find_by_id($pdo, 'shopping_cart', $id);
}

function update_cart_by_id($database, $id, $quantity, $user_id, $product_id)
{
    return null;
}

function delete_cart_by_id($database, $id)
{
    return delete_by_id($database['hostname'], $database['dbname'], $database['user'], $database['password'], 'shopping_cart', $id);
}

function list_all_carts($database)
{
    return list_all_itens($database['hostname'], $database['dbname'], $database['user'], $database['password'], 'shopping_cart');
}

// crud_cart.php