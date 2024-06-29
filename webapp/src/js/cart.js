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

function increaseCount(a, b) {
    var input = b.previousElementSibling;
    var value = parseInt(input.value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    input.value = value;
}
function decreaseCount(a, b) {
    var input = b.nextElementSibling;
    var value = parseInt(input.value, 10);
    if (value > 1) {
        value = isNaN(value) ? 0 : value;
        value--;
        input.value = value;
    }
}

function updateQuantity(product_id) {
    var newQuantity = document.getElementById('num_item').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'process/update_quantity.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle response if needed
            alert('Quantity updated successfully!');
        }
    };
    xhr.send('product_id=' + product_id + '&new_quantity=' + newQuantity);
}