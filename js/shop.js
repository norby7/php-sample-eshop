function addToCart(productId) {
    var cartItems = localStorage.getItem("cartItems");
    var formData = new FormData();

    formData.append('product_id', productId);

    $.ajax({
        url: 'ajax_shop.php?action=2',
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function (data, textStatus, jqXHR) {
            if(data == 1){
                cartItems++;
                localStorage.setItem("cartItems", cartItems);
                $("#cartItems").text(cartItems);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown)
        }
    });
}