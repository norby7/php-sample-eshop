function changeQuantity(productUID, input) {
    var formData = new FormData();

    formData.append('product_id', productUID);
    formData.append('value', input.value);

    $.ajax({
        url: 'ajax_shop.php?action=3',
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function (data, textStatus, jqXHR) {
            $("#price-" + productUID).text(Math.round($(input).attr("data-price") * input.value * 100) / 100)
            setTotal();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown)
        }
    });
}

function deleteItem(productUID) {
    var formData = new FormData();

    formData.append('product_id', productUID);

    $.ajax({
        url: 'ajax_shop.php?action=4',
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function (data, textStatus, jqXHR) {
            setTotal();
            var cartItems = localStorage.getItem("cartItems");
            cartItems--;
            localStorage.setItem("cartItems", cartItems);
            $("#cartItems").text(cartItems);
            $('table tr#' + productUID).remove();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown)
        }
    });
}

function setTotal() {
    var total = 0;
    $(".quantityInput").each(function () {
        total += $(this).val() * $(this).attr('data-price');
    })

    $("#sub-total").text(Math.round(total * 100) / 100);
    $("#total").text(Math.round((total + 6.90) * 100) / 100);
}

function checkout(){
    var items = localStorage.getItem("cartItems");
    if(items != 0){
        location.href = 'checkout.php';
    }
}