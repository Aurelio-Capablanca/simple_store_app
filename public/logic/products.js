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


function UI_handler(series_id, ui_object) {
    return {
        "series_id": series_id,
        "ui_object": ui_object
    }
}


function guard_empty_value(data, isnumeric, isdouble) {
    if (isnumeric) {
        return parseInt(data || 0);
    }
    if (isdouble) {
        return parseFloat(data || 0.0);
    }
    return data === "" ? null : data
}

/********************************* */
document.addEventListener('DOMContentLoaded', () => {
    fillSelect(categories, `id_category`, null);
});


var listCreatedProduct = new Array();
var counterProducts = 0;



function add_product_element(handler) {
    return `<div id="product-create-${handler.series_id}">
    <div class="mb-3">
        <label for="product_name-${handler.series_id}" class="form-label">product name</label>
        <input type="text" name="product_name-${handler.series_id}" id="product_name-${handler.series_id}"
            class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="product_description-${handler.series_id}" class="form-label">product description</label>
        <input type="text" name="product_description-${handler.series_id}" id="product_description-${handler.series_id}"
            class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="product_price" class="form-label">product price</label>
        <input type="number" inputmode="decimal" step="0.50" min="0" name="product_price-${handler.series_id}" id="product_price-${handler.series_id}"
            class="form-control" required>
    </div>
     <div class="mb-3">
        <label for="product_stock_number" class="form-label">product Quantity</label>
        <input type="number" step="1" name="product_stock_number-${handler.series_id}" id="product_stock_number-${handler.series_id}"
            class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="buying_price" class="form-label">buying price</label>
        <input type="number" inputmode="decimal" step="0.50" min="0" name="buying_price-${handler.series_id}" id="buying_price-${handler.series_id}"
            class="form-control" required>
    </div>
    <div class="mb-3 form-check form-switch">
        <input style="display:none" class="form-check-input" for="has_discount-${handler.series_id}" type="checkbox"
            id="flexSwitchCheckDefault">
        <label class="form-check-label" name="has_discount-${handler.series_id}" id="has_discount-${handler.series_id}"
            for="flexSwitchCheckDefault" style="display:none">has
            discount</label>
    </div>
    <div class="mb-3 form-check form-switch">
        <input style="display:none" class="form-check-input" for="has_stock-${handler.series_id}" type="checkbox"
            id="flexSwitchCheckDefault">
        <label class="form-check-label" name="has_stock-${handler.series_id}" id="has_stock-${handler.series_id}"
            for="flexSwitchCheckDefault" style="display:none">has
            stock</label>
    </div>
    <div class="mb-3 form-check form-switch">
        <input style="display:none" class="form-check-input" for="is_available-${handler.series_id}" type="checkbox"
            id="flexSwitchCheckDefault">
        <label class="form-check-label" name="is_available-${handler.series_id}" id="is_available-${handler.series_id}"
            for="flexSwitchCheckDefault" style="display:none">is
            available</label>
    </div>
    <div class="mb-3">
        <label for="expiring_date-${handler.series_id}">expiring date</label>
        <input type="date" class="form-check-label" id="expiring_date-${handler.series_id}"
            name="expiring_date-${handler.series_id}">
    </div>
    <div class="mb-3">
        <label for="id_category-${handler.series_id}" class="form-label">Category</label>
        <select name="id_category-${handler.series_id}" id="id_category-${handler.series_id}" class="form-select">
            <option value="">Select Category...</option>
        </select>
    </div>
    <button class="btn btn-sm btn-danger" type="button" id="eraseProducts-${handler.series_id}" onclick="">
        <span aria-hidden="true">×</span>
    </button>   
</div>`;
}




var id_product_general = 0;
function openUpdateModal(url) {
    //event.preventDefault();
    console.log(url);
    fetch(url, {
        method: 'get'
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status) {
                    console.log(response);
                    dataset = response.dataset;
                    id_product_general = dataset.id_product;
                    document.getElementById(`product_name`).value = dataset.product_name;
                    document.getElementById(`product_description`).value = dataset.product_description;
                    document.getElementById(`product_price`).value = dataset.product_price;
                    document.getElementById(`product_stock_number`).value = dataset.product_stock_number;
                    document.getElementById(`has_discount`).checked = false,
                        document.getElementById(`has_stock`).checked = false,
                        document.getElementById(`is_available`).checked = false,
                        fillSelect(categories, `id_category`, dataset.id_category);
                } else {

                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    }).catch(function (error) {
        console.log(error);
    });
}


document.getElementById('add_product').addEventListener('click', function (event) {
    counterProducts++;
    const container = document.getElementById("container-products");
    const handler = UI_handler(counterProducts, null);
    listCreatedProduct.push(handler.series_id);
    container.insertAdjacentHTML("beforeend", add_product_element(handler));
    console.log(listCreatedProduct);
    //Set Listener outside String HMTL
    fillSelect(categories, `id_category-${handler.series_id}`, null)
    document.getElementById(`eraseProducts-${handler.series_id}`)
        .addEventListener("click", () => {
            document.getElementById(`product-create-${handler.series_id}`).remove();
            //listCreatedProduct.remove(handler.series_id);
            const index_element = listCreatedProduct.indexOf(handler.series_id);
            if (index_element <= -1) return;
            listCreatedProduct.splice(index_element)
            console.log(listCreatedProduct);
        });
});

document.getElementById('save_products').addEventListener('click', function (event) {
    console.log(save_products_url);
    event.preventDefault();
    let load_product = {
        retailer_bill: process_bill(),
        list_product: process_form_product()
    }
    console.log(load_product);
    sendPayload(save_products_url, load_product);
    window.location.reload();
});

function process_form_product() {
    let object_list = new Array();
    listCreatedProduct.forEach(data => {
        console.log(data);
        object_list.push({
            "product_name": document.getElementById(`product_name-${data}`).value,
            "product_description": document.getElementById(`product_description-${data}`).value,
            "product_price": guard_empty_value(document.getElementById(`product_price-${data}`).value, false, true),
            "product_stock_number": guard_empty_value(document.getElementById(`product_stock_number-${data}`).value, true, false),
            "buying_price": guard_empty_value(document.getElementById(`buying_price-${data}`).value, false, true),
            "has_discount": document.getElementById(`has_discount-${data}`).checked,
            "has_stock": document.getElementById(`has_stock-${data}`).checked,
            "is_available": document.getElementById(`is_available-${data}`).checked,
            "expiring_date": guard_empty_value(document.getElementById(`expiring_date-${data}`).value, false, false),
            "id_category": guard_empty_value(document.getElementById(`id_category-${data}`).value, true, false),
        })
    });
    return object_list;
}

function process_bill() {
    return {
        "id_store": guard_empty_value(document.getElementById('id_store').value, true, false),
        "id_retailer": guard_empty_value(document.getElementById('id_retailer').value, true, false),
        "timestamp_bill_retailer": guard_empty_value(document.getElementById('timestap_bill_retailer').value, false, false),
    }
}

document.getElementById('update-product').addEventListener('click', function (event) {
    event.preventDefault();
    let products = {
        "id_product": id_product_general,
        "product_name": document.getElementById(`product_name`).value,
        "product_description": document.getElementById(`product_description`).value,
        "product_price": guard_empty_value(document.getElementById(`product_price`).value, false, true),
        "product_stock_number": guard_empty_value(document.getElementById(`product_stock_number`).value, true, false),
        "has_discount": document.getElementById(`has_discount`).checked,
        "has_stock": document.getElementById(`has_stock`).checked,
        "is_available": document.getElementById(`is_available`).checked,
        "expiring_date": guard_empty_value(document.getElementById(`expiring_date`).value, false, false),
        "id_category": guard_empty_value(document.getElementById(`id_category`).value, true, false),
    }
    console.log(products);
    sendPayload(update_products_url, products);
    window.location.reload();
});

