<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
require_once "config.php";
require_once "Shop.php";

$categoryName = empty($_GET['categoryName']) ? "TV" : $_GET['categoryName'];
$currentPage = empty($_GET['page']) ? 1 : $_GET['page'];


$shop = new Shop();
$categoriesList = $shop->getCategories();
$productsList = $shop->getProductsFromCategory($categoryName, $currentPage);
$pagesNumber = round($shop->getProductsNumberFromCategory($categoryName) / 9);
$topItems = $shop->getTopRatings();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - Start Bootstrap Template</title>
    <script src="/js/jquery.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <script src="/js/bootstrap.js"></script>

    <!-- Custom styles for this template -->
    <link href="/css/shop-homepage.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="/js/shop.js"></script>
</head>
<style>
    .card-img-top {
        height: 300px;
    }

    .sliderImg {
        max-height: 300px;
        max-width: 400px;
        padding-left: 8em;
    }

/*    .carousel-control-prev {
        background-color: #005cbf;
    }

    .carousel-control-next {
        background-color: #005cbf;
    }*/

    .ratingStars {
        color: deepskyblue;
        font-size: 2em;
    }

    .fa-cart-plus {
        color: #ff6a00;
        padding-left: 1em;
        font-size: 2em;
        cursor: pointer;
    }

    /*    .cartButton{
            background-color: #343a40!important;
        }*/
</style>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Shop name</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
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

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-lg-3 my-4">
            <div class="list-group">
                <?php
                foreach ($categoriesList as $category) {
                    echo "<a href=\"index.php?categoryName=" . $category['name'] . "\" class=\"list-group-item " . ($categoryName == $category['name'] ? 'active' : '') . " \">" . $category['name'] . "</a>";
                }
                ?>
            </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <?php
                    foreach ($topItems as $index => $item) {
                        switch ($index) {
                            case 0:
                                $alt = "First";
                                break;
                            case 1:
                                $alt = "Second";
                                break;
                            case 2:
                                $alt = "Third";
                                break;
                            case 3:
                                $alt = "Fourth";
                                break;
                            case 4:
                                $alt = "Fifth";
                                break;
                        }
                        if ($index == 0) {
                            echo " <div class=\"carousel-item active align-content-center\">
                                <div><div style='display: inline-block;float: left'><img class=\"sliderImg d-block img-fluid\" src=\"" . $item['image_url'] . "\" alt=\"$alt\"></div><div style='display: inline-block;max-width: 15em;padding-left: 3em'><h4 class=\"card-title\"><a href='product.php?categoryName=$categoryName&page=$currentPage&productUID=". $item['uid'] ."'>" . $item['name'] . "</a></h4><br>$" . $item['price'] . "</div></div>                                 
                            </div>";
                        } else {
                            echo " <div class=\"carousel-item center\">
                                <div><div style='display: inline-block;float: left'><img class=\"sliderImg d-block img-fluid\" src=\"" . $item['image_url'] . "\" alt=\"$alt\"></div><div style='display: inline-block;max-width: 15em;padding-left: 3em'><h4 class=\"card-title\"><a href='product.php?categoryName=$categoryName&page=$currentPage&productUID=". $item['uid'] ."'>" . $item['name'] . "</a></h4><br>$" . $item['price'] . "</div></div>
                            </div>";
                        }

                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

            <div class="row">
                <?php
                foreach ($productsList as $product) {
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <a href="product.php?categoryName=<?php echo $categoryName ?>&page=<?php echo $currentPage ?>&productUID=<?php echo $product['uid'] ?>"><img
                                        class="card-img-top" src="<?php echo $product['image_url'] ?>" alt=""></a>
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="product.php?categoryName=<?php echo $categoryName ?>&page=<?php echo $currentPage ?>&productUID=<?php echo $product['uid'] ?>"><?php echo $product['name'] ?></a>
                                </h4>
                                <h5>$<?php echo $product['price'] ?></h5>
                                <p class="card-text"><?php echo $product['description'] ?></p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><span class="ratingStars">
                                        <?php
                                        for ($i = 0; $i < 5; $i++) {
                                            if ($i < $product['rating']) {
                                                echo " &#9733;";
                                            } else {
                                                echo " &#9734;";
                                            }
                                        }
                                        ?>
                                    </span></small>
                                <i class="fa fa-cart-plus" onclick="addToCart('<?= $product['uid'] ?>')"></i>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <!-- /.row -->
            <?php
            echo "<div id='paginare' style='width: 95%; text-align: right;'>";
            if ($currentPage != 1) {
                echo "&nbsp;<a href='index.php?categoryName=$categoryName&page=1' class='cale' title='First page'><<</a>";
                $prevPage = $currentPage - 1;
                echo "&nbsp;<a href='index.php?categoryName=$categoryName&page=$prevPage' class='cale' title='Previous page'><</a>";
            }
            for ($i = ($currentPage - 2); $i <= ($currentPage + 2); $i++) {
                if ($i >= 1 && $i <= $pagesNumber) {
                    $max = $i * 15;
                    $min = $max - 15 + 1;
                    echo "&nbsp;<a href='index.php?categoryName=$categoryName&page=$i' class='cale' style='" . ($currentPage == $i ? 'color: red;' : '') . "'>" . $i . "</a>";
                }
            }
            if ($currentPage != $pagesNumber) {
                $nextPage = $currentPage + 1;
                echo "&nbsp;<a href='index.php?categoryName=$categoryName&page=$nextPage' class='cale' title='Next page' >></a>";
                echo "&nbsp;<a href='index.php?categoryName=$categoryName&page=$pagesNumber' class='cale' title='Last page' >>></a>";
            }
            echo "</div>";
            ?>
        </div>
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<script>
    $(document).ready(function() {
        var cartItems = localStorage.getItem("cartItems");
        $("#cartItems").text(cartItems);
    });
</script>