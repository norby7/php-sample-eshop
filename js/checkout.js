function submitOrder(){
    var formData = new FormData();

    formData.append('firstName', $("#firstName").val());
    formData.append('lastName', $("#lastName").val());
    formData.append('email', $("#email").val());
    formData.append('address', $("#address").val());
    formData.append('addressOpt', $("#address2").val());
    formData.append('country', $("#country").val());
    formData.append('state', $("#state").val());
    formData.append('zip', $("#zip").val());
    formData.append('paymentType', $("input[name=paymentMethod]:checked").attr('id'));
    formData.append('cardName', $("#cc-name").val());
    formData.append('cardNumber', $("#cc-number").val());
    formData.append('cardExpiration', $("#cc-expiration").val());
    formData.append('cardCVV', $("#cc-cvv").val());

    $.ajax({
        url: 'ajax_shop.php?action=5',
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function (data, textStatus, jqXHR) {console.log(data);
            localStorage.setItem("cartItems", 0);
            location.href = "index.php";
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown)
        }
    });
}