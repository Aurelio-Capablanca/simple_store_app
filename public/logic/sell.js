function getHeaders() {
    return {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
}


function sendPayload(api, data) {
    fetch(api, {
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify(data),
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                alert('Success!');
            });
        } else {
            console.log(request.status + ' ' + request.text);
        }
    }).catch(function (error) {
        console.log(error);
    });
}


function fillSelect(submitted_object, select, selected) {
    let content = '';
    if (!selected) {
        content += '<option value="0" disabled selected>Select an Option</option>';
    }
    submitted_object.map(function (row) {
        value = Object.values(row)[0];
        text = Object.values(row)[1];
        if (value != selected) {
            content += `<option value="${value}">${text}</option>`;
        } else {
            content += `<option value="${value}" selected>${text}</option>`;
        }
    });
    if (submitted_object.length == 0) {
        content += '<option>No available options</option>';
    }
    document.getElementById(select).innerHTML = content;
}

function UI_handler(series_id, ui_object) {
    return {
        "series_id": series_id,
        "ui_object": ui_object
    }
}

function appendSafe(selector, content) {
    const querySelection = document.querySelector(selector);
    if (typeof content === 'string') {
        querySelection.insertAdjacentHTML('beforeend', content);
    } else if (content instanceof Node) {
        querySelection.appendChild(content);
    } else {
        console.warn('Unsupported type for appendSafe');
    }
}

/*******************************************************************************/
document.addEventListener('DOMContentLoaded', () => {

});

var listCreatedProduct = new Array();
var counterProducts = 0;

function add_product_element(handler) {
    return `
    <div id="product-create-${handler.series_id}">
    <div class="mb-3">
        <label for="id_product-${handler.series_id}" class="form-label">Product</label>
        <select name="id_product-${handler.series_id}" id="id_product-${handler.series_id}" class="form-select">
            <option value="">Select Product...</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="product_price" class="form-label">Product Price</label>
        <input type="number" inputmode="decimal" step="0.50" min="0" name="product_price-${handler.series_id}" id="product_price-${handler.series_id}"
            class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="product_stock_number" class="form-label">Product Quantity</label>
        <input type="number" step="1" name="product_stock_number-${handler.series_id}" id="product_stock_number-${handler.series_id}"
            class="form-control" required>
    </div>
    <button class="btn btn-sm btn-danger" type="button" id="eraseProducts-${handler.series_id}" onclick="">
        <span aria-hidden="true">×</span>
    </button>
    </div>
    `
}


document.getElementById('add_product').addEventListener('click', function (event) {
    counterProducts++;
    const container = document.getElementById("container-products");
    const handler = UI_handler(counterProducts, null);
    listCreatedProduct.push(handler.series_id);
    container.insertAdjacentHTML("beforeend", add_product_element(handler));
    console.log(listCreatedProduct);
    //Set Listener outside String HMTL
    fillSelect(products, `id_product-${handler.series_id}`, null)
    document.getElementById(`eraseProducts-${handler.series_id}`)
        .addEventListener("click", () => {
            document.getElementById(`product-create-${handler.series_id}`).remove();
            //listCreatedProduct.remove(handler.series_id);
            const index_element = listCreatedProduct.indexOf(handler.series_id);
            if (index_element <= -1) return;
            listCreatedProduct.splice(index_element)
            console.log(listCreatedProduct);
        });
    document.getElementById(`id_product-${handler.series_id}`)
        .addEventListener("change", () => {
            console.log("testing")
            id_product = document.getElementById(`id_product-${handler.series_id}`).value;
            console.log(id_product)
            fetch('http://127.0.0.1:8000/get-product-price/'+id_product, {
                method: 'get'
            }).then(function (request) {
                if (request.ok) {
                    request.json().then(function (response) {
                        if (response.status) {
                            console.log(response);
                            dataset = response.dataset;
                            console.log(dataset);
                            document.getElementById(`product_price-${handler.series_id}`).value = dataset.price;
                        } else {

                        }
                    });
                } else {
                    console.log(request.status + ' ' + request.statusText);
                }
            }).catch(function (error) {
                console.log(error);
            });

        })
});