$(document).ready(function () {
    function fetchTableData(table, columns) {
        console.log("load First");
        $.ajax({
            url: "process/switch_process.php",
            type: "GET",
            data: {table: table, columns: columns},
            success: function (response) {
                $('#switchcard-deck').html(response);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", status, error);
                console.error("Response:", xhr.responseText);
            }
        });
    }
    fetchTableData('product', 'product_id, product_name ,product_cost, category_id ,product_sd,product_quantity' );
});