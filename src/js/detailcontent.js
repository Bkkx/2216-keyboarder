$(document).ready(function () {
    
    function fetchTableDataProduct(table, columns) {
        console.log("load First");
        // Get the query string from the URL
        var queryString = window.location.search;

        // Parse the query string to get the value of the "id" parameter
        var urlParams = new URLSearchParams(queryString);
        var productid = urlParams.get('id');

        $.ajax({
            url: "process/details_content_process.php",
            type: "GET",
            data: {table: table, columns: columns, productid: productid},
            success: function (response) {
                $('#details-page').html(response);
            }
        });
    }
    fetchTableDataProduct('product', 'product_id, product_name, product_cost, product_sd, product_ld, product_quantity, category_name');
});

function increaseCount(event, element) {
    var input = element.previousElementSibling;
    var max = parseInt(input.getAttribute('max'), 10);
    var value = parseInt(input.value, 10);
    value = isNaN(value) ? 1 : value;
    if (value < max) {
        input.value = value + 1;
    }
}

function decreaseCount(event, element) {
    var input = element.nextElementSibling;
    var value = parseInt(input.value, 10);
    if (value > 1) {
        input.value = value - 1;
    }
}
