<?php
require_once "Shop.php";


$shop = new Shop();
switch ($_GET['action']){
    case 1:
        echo $shop->insertReview();
        break;
}