<?php
session_start();
require_once "Shop.php";

$shop = new Shop();
$items = $shop->getCartItems();
$total = 0;
?>
<link href="/css/bootstrap.min.css" rel="stylesheet">
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<script src="/js/cart.js"></script>
<style>
    .cartItemImage{
        width: 50px;
        height: 50px;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">PHP-Eshop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        <i class="fa fa-shopping-cart"></i> Cart
                        <span class="badge badge-light" id="cartItems">0</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mb-6" style="padding-top: 5em">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="productCol">Product</th>
                        <th scope="col">Available</th>
                        <th scope="col" class="text-center" style="width: 5%">Quantity</th>
                        <th scope="col" class="text-right" style="width: 10%">Price</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item) {
                        $total += $item['price'] * $_SESSION['cart'][$item['uid']];
                        echo " <tr id='".$item['uid']."'>
                            <td><img class=\"cartItemImage\" src=\"" . $item['image_url'] . "\" /> </td>
                            <td class='productCol'>" . $item['name'] . "</td>
                            <td>In stock</td>
                            <td><input class='form-control quantityInput' min='1' data-price='" . $item['price'] . "' onchange='changeQuantity(\"".$item['uid']."\", this)' class=\"form-control\" type=\"number\" value=\"" . $_SESSION['cart'][$item['uid']] . "\" /></td>
                            <td class=\"text-right\"><span id='price-".$item['uid']."'>" . $item['price'] * $_SESSION['cart'][$item['uid']]. "</span> €</td>
                            <td class=\"text-right\"><button onclick='deleteItem(\"".$item['uid']."\")' class=\"btn btn-sm btn-danger\"><i class=\"fa fa-trash\"></i> </button> </td>
                        </tr>";
                    } ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2">Sub-Total</td>
                        <td class="text-right" colspan="2"><span id="sub-total"><?= $total ?></span> €</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2">Shipping</td>
                        <td class="text-right" colspan="2">6,90 €</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td colspan="2"><strong>Total</strong></td>
                        <td class="text-right" colspan="2"><strong><span id="total"><?= $total + 6.90 ?></span> €</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col mb-2">
            <div class="row">
                <div class="col-sm-12  col-md-6">
                    <button class="btn btn-block btn-light" onclick="location.href = 'index.php';">Continue Shopping</button>
                </div>
                <div class="col-sm-12 col-md-6 text-right">
                    <button class="btn btn-lg btn-block btn-success text-uppercase" onclick="checkout()">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var cartItems = localStorage.getItem("cartItems");
        $("#cartItems").text(cartItems);
    });
</script>