function addReview(productId) {
    var formData = new FormData();

    formData.append('product_id', productId);
    formData.append('username', $("#username").val());
    formData.append('review_text', $("#review_text").val());
    formData.append('rating', $("#starRatingNumber").val());

    $.ajax({
        url: 'ajax_shop.php?action=1',
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function (data, textStatus, jqXHR) {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = dd + '.' + mm + '.' + yyyy;

            $("#reviewsList").append("<p>" + $("#review_text").val() + "</p><small class=\"text-muted\">Posted by " + $("#username").val() + " on " + today + "</small><hr>");
            $("#username").val('');
            $("#review_text").val('');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(errorThrown)
        }
    });
}