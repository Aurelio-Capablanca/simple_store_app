function getHeaders() {
    return {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }
}


function saveRow(api, data) {
    fetch(api, {
        method: 'POST',
        headers: getHeaders(),
        body: JSON.stringify(data)
    }).then(function (request) {
        if (request.ok) {
            request.json().then(function (response) {
                if (response.status != 0) {
                    alert('Success!');
                }
            });
        } else {
            console.log(request.status + ' ' + request.text);
        }
    }).catch(function (error) {
        console.log(error);
    });
}



/********************************* */
var listCreatedProduct = new Array();
var counterProducts = 0;

function UI_handler(series_id, ui_object) {
    return {
        "series_id": series_id,
        "ui_object": ui_object
    }
}

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
        <input type="text" name="product_price-${handler.series_id}" id="product_price-${handler.series_id}"
            class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="buying_price" class="form-label">buying price</label>
        <input type="text" name="buying_price-${handler.series_id}" id="buying_price-${handler.series_id}"
            class="form-control" required>
    </div>
    <div class="mb-3 form-check form-switch">
        <input class="form-check-input" for="has_discount-${handler.series_id}" type="checkbox"
            id="flexSwitchCheckDefault">
        <label class="form-check-label" name="has_discount-${handler.series_id}" id="has_discount-${handler.series_id}"
            for="flexSwitchCheckDefault">has
            discount</label>
    </div>
    <div class="mb-3 form-check form-switch">
        <input class="form-check-input" for="has_stock-${handler.series_id}" type="checkbox"
            id="flexSwitchCheckDefault">
        <label class="form-check-label" name="has_stock-${handler.series_id}" id="has_stock-${handler.series_id}"
            for="flexSwitchCheckDefault">has
            stock</label>
    </div>
    <div class="mb-3 form-check form-switch">
        <input class="form-check-input" for="is_available-${handler.series_id}" type="checkbox"
            id="flexSwitchCheckDefault">
        <label class="form-check-label" name="is_available-${handler.series_id}" id="is_available-${handler.series_id}"
            for="flexSwitchCheckDefault">is
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

document.getElementById('add_product').addEventListener('click', function (event) {
    counterProducts++;
    const container = document.getElementById("container-products");
    const handler = UI_handler(counterProducts, null);
    listCreatedProduct.push(handler.series_id);
    container.insertAdjacentHTML("beforeend", add_product_element(handler));
    console.log(listCreatedProduct);
    //Set Listener outside String HMTL
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
    event.preventDefault();
    let load_product = {
        retailer_bill: process_form_product(),
        list_product: process_bill()
    }
    console.log(load_product);
    //isaveRow('',load_product);
});

function process_form_product() {
    let object_list = new Array();
    listCreatedProduct.forEach(data => {
        console.log(data);
        object_list.push({
            "name": document.getElementById(`product_name-${data}`).value,
            "description": document.getElementById(`product_description-${data}`).value,
            "price": document.getElementById(`product_price-${data}`).value,
            "buying_price": document.getElementById(`buying_price-${data}`).value,
            "has_discount": document.getElementById(`has_discount-${data}`).checked,
            "has_stock": document.getElementById(`has_stock-${data}`).checked,
            "is_available": document.getElementById(`is_available-${data}`).checked,
            "expiring_date": document.getElementById(`expiring_date-${data}`).value,
            "id_category": document.getElementById(`id_category-${data}`).value,
        })
    });
    return object_list;
}

function process_bill() {
    return {
        "id_store": document.getElementById('id_store').value,
        "id_retailer": document.getElementById('id_retailer').value,
        "timestamp_bill_retailer": document.getElementById('timestap_bill_retailer').value,
    }
}


/*------------------------------------------------------------------------------------------------------------------------------------ */

document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editproductModal');

    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const url = button.getAttribute('href');

        fetch(url)
            .then(response => response.text())
            .then(html => {
                editModal.querySelector('.modal-dialog').innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading modal:', error);
            });
    });
});



//Function for tester 
function call_service() {
    event.preventDefault();
    fetch("{{ route('token-get') }}")
        .then(response => response.json())
        .then(data => {
            console.log("JWT:", data.token);
            // You can store it in localStorage or use it directly
            localStorage.setItem('jwt_token', data.token);
        })
        .catch(error => console.error("Error fetching token:", error));
    // fetch("localhost:9091/api/test-access", {
    //     headers: {
    //         Authorization: `Bearer ${localStorage.getItem('jwt_token')}`
    //     }
    // }).catch(error => console.error("Error fetching at Service:", error));
}

