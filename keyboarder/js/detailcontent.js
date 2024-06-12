$(document).ready(function () {
    var path = window.location.pathname;
    var pagename = path.split("/").pop();

    function fetchTableDataProduct(table, columns) {
        // Get the query string from the URL
        var queryString = window.location.search;

        // Parse the query string to get the value of the "id" parameter
        var urlParams = new URLSearchParams(queryString);
        var productid = urlParams.get('id');

        $.ajax({
            url: "fetch_process.php",
            type: "GET",
            data: {table: table, columns: columns, pagename: pagename, productid: productid},
            success: function (response) {
                $('#product-details').html(response);
            }
        });
    }
    fetchTableDataProduct('product', 'product_id, product_name, product_cost, product_sd, product_ld, product_quantity, category_name');
});