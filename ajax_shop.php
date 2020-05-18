<?php
session_start();
require_once "Shop.php";


$shop = new Shop();
switch ($_GET['action']){
    case 1:
        echo $shop->insertReview();
        break;
    case 2:
        echo addToCart();
        break;
    case 3:
        echo changeCartQuantity();
        break;
    case 4:
        echo deleteCartItem();
        break;
    case 5:
        echo $shop->submitOrder();
        break;
}

function addToCart(){
    if(empty($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }

    if(empty($_SESSION['cart'][$_POST['product_id']])){
        $_SESSION['cart'][$_POST['product_id']] = 0;
    }

    $_SESSION['cart'][$_POST['product_id']]+=1;
    return $_SESSION['cart'][$_POST['product_id']];
}

function changeCartQuantity(){
    $_SESSION['cart'][$_POST['product_id']] = $_POST['value'];
}

function deleteCartItem(){
    unset($_SESSION['cart'][$_POST['product_id']]);
}