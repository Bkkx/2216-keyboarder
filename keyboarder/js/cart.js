function fetchCartTableData(table, columns) {
    console.log("fetched cart");
    $.ajax({
        url: "process/cart_process.php",
        type: "GET",
        data: {table: table, columns: columns},
        success: function (response) {
            $('#cart-list').html(response);
            console.log(response);
        }
    });
}

fetchCartTableData('product', 'product_id, product_name, product_cost, product_sd, product_quantity, category_name');