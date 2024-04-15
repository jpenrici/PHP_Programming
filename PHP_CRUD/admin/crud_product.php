<?php

require_once 'db_functions.php';

function create_product($database, $name, $description, $price, $discount, $quantity, $image, $category_id)
{
    $result = null;

    // Check entries
    if (is_null($database)) {
        return false;
    }

    if (is_null($name)) {
        return false;
    }

    if (empty($name)) {
        return false;
    }

    $description = is_null($description) ? "No description" : $description;
    $price = (is_null($price) || !is_numeric($price)) ? "0" : ((int)$price < 0 ? "0" : $price);
    $discount = (is_null($discount) || !is_numeric($discount)) ? "0" : ((int)$discount < 0 ? "0" : $discount);
    $quantity = (is_null($quantity) || !is_numeric($quantity)) ? "0" : ((int)$quantity < 0 ? "0" : $quantity);
    $image = is_null($image) ? "No image" : $image;
    $category_id = (is_null($category_id) || !is_numeric($category_id)) ? "0" : ((int)$category_id < 0 ? "0" : $category_id);

    // Connect
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Find
    $sql = "SELECT * FROM `product` WHERE BINARY `name` = '" . $name . "';";
    $result = command($pdo, $sql);
    if ($result) {
        $count = $result->rowCount();
        if ($count > 0) {
            // echo "Found " . $count . " entries for " . $name . "! New user has not been created!" . PHP_EOL;
            return false;
        }
    }

    // Create
    $sql = "INSERT INTO `product` (`id`, `name`, `description`, `price`, `discount`, `quantity`, `image`, `createdAt`, `updatedAt`, `category_id`) ";
    $sql .= "VALUES (NULL, '" . $name . "', '" . $description . "', '" . $price . "', '" . $discount . "', '" . $quantity . "', '" . $image;
    $sql .= "', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '" . $category_id . "');";
    $result = command($pdo, $sql);

    // Exit
    $pdo = null;

    return !is_null($result);
}

function read_product_by_name($database, $name)
{
    $result = null;

    // Check entries
    if (is_null($database)) {
        return null;
    }

    if (is_null($name)) {
        return null;
    }

    if (empty($name)) {
        return null;
    }

    // Connect
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Find
    $sql = "SELECT * FROM `product` WHERE `name` = '" . $name . "';";
    $result = command($pdo, $sql);
    // if ($result) {
    //     $count = $result->rowCount();
    //     echo "Found " . $count . " entries for " . $name . "!" . PHP_EOL;
    // }

    // Exit
    $pdo = null;

    return $result;
}

function update_product_by_id($database, $id, $name, $description, $price, $discount, $quantity, $image, $category_id)
{
    $result = null;

    // Check entries
    if (is_null($database)) {
        return false;
    }

    if (is_null($id)) {
        return false;
    }

    if (empty($id)) {
        return false;
    }

    $price = (is_null($price) || !is_numeric($price)) ? "" : ((int)$price < 0 ? "" : $price);
    $discount = (is_null($discount) || !is_numeric($discount)) ? "" : ((int)$discount < 0 ? "" : $discount);
    $quantity = (is_null($quantity) || !is_numeric($quantity)) ? "" : ((int)$quantity < 0 ? "" : $quantity);
    $image;
    $category_id = (is_null($category_id) || !is_numeric($category_id)) ? "" : ((int)$category_id < 0 ? "" : $category_id);

    // Connect
    $pdo = connect($database['hostname'], $database['dbname'], $database['user'], $database['password']);

    // Find
    $sql = "SELECT * FROM `product` WHERE `id` = '" . $id . "';";
    $result = command($pdo, $sql);
    if ($result) {
        $count = $result->rowCount();
        if ($count != 1) {
            // echo "Found " . $count . " entries for " . $id . "!" . PHP_EOL;
            return false;
        }

        // Update
        $data = $result->fetch(PDO::FETCH_ASSOC);
        $new_name = (empty($name) || is_null($name)) ? $data['username'] : $name;
        $new_description = (empty($description) || is_null($description)) ? $data['description'] : $description;
        $new_price = (empty($price) || is_null($price)) ? $data['price'] : $price;
        $new_discount = (empty($discount) || is_null($discount)) ? $data['discount'] : $discount;
        $new_quantity = (empty($quantity) || is_null($quantity)) ? $data['quantity'] : $quantity;
        $new_image = (empty($image) || is_null($image)) ? $data['image'] : $image;
        $new_category_id = (empty($category_id) || is_null($category_id)) ? $data['category_id'] : $category_id;
        $updateAt = date("Y-m-d H:i:s");
        // echo "Values: " . $id . ", " . $new_name . ", " . $new_description . ", " . $new_price . ", " . $new_discount . ", " . $new_quantity;
        // echo ", " . $new_image . ", " . $new_category_id . ", " . $updateAt . PHP_EOL;

        $sql = "UPDATE `product` SET `name` = '" . $new_name . "', `description` = '" . $new_description . "', `price` = '" . $new_price;
        $sql .= "', `discount` = '" . $new_discount . "', `quantity` = '" . $new_quantity . "', `image` = '" . $new_image;
        $sql .= "', `updatedAt`  = '" . $updateAt . "', `category_id` = '" . $new_category_id . "' WHERE `product`.`id` = '" . $id . "';";
        $result = command($pdo, $sql);
    }

    // Exit
    $pdo = null;

    return !is_null($result);
}

function delete_product_by_id($database, $id)
{
    return delete_by_id($database['hostname'], $database['dbname'], $database['user'], $database['password'], 'product', $id);
}

function list_all_products($database)
{
    return list_all_itens($database['hostname'], $database['dbname'], $database['user'], $database['password'], 'product');
}

// crud_user.php