<div class="modal-content">
    <div class="modal-header bg-gradient-primary text-white">
        <h5 class="modal-title" id="retailerModalLabel">Update Product</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form>
        <div class="modal-body">
            <div class="mb-3">
                <label for="product_name" class="form-label">product name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="product_description" class="form-label">product description</label>
                <input type="text" name="product_description" id="product_description" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">product price</label>
                <input type="text" name="product_price" id="product_price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="product_stock_number" class="form-label">product Quantity</label>
                <input type="text" name="product_stock_number" id="product_stock_number" class="form-control" required>
            </div>
            <div class="mb-3 form-check form-switch">
                <input class="form-check-input" for="has_discount" type="checkbox" id="flexSwitchCheckDefault">
                <label class="form-check-label" name="has_discount" id="has_discount" for="flexSwitchCheckDefault">has
                    discount</label>
            </div>
            <div class="mb-3 form-check form-switch">
                <input class="form-check-input" for="has_stock" type="checkbox" id="flexSwitchCheckDefault">
                <label class="form-check-label" name="has_stock" id="has_stock" for="flexSwitchCheckDefault">has
                    stock</label>
            </div>
            <div class="mb-3 form-check form-switch">
                <input class="form-check-input" for="is_available" type="checkbox" id="flexSwitchCheckDefault">
                <label class="form-check-label" name="is_available" id="is_available" for="flexSwitchCheckDefault">is
                    available</label>
            </div>
            <div class="mb-3">
                <label for="expiring_date">expiring date</label>
                <input type="date" class="form-check-label" id="expiring_date" name="expiring_date">
            </div>
            <div class="mb-3">
                <label for="id_category" class="form-label">Category</label>
                <select name="id_category" id="id_category" class="form-select">
                    <option value="">Select Category...</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button id="update-product" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
<script>
    window.addEventListener("beforeunload", (e) => {
        e.preventDefault();
        console.log(categories)
        fillSelect(categories, `id_category`, null)
    });
    //fillSelect(categories, `id_category`, null)

    document.getElementById('update').addEventListener('click', function (event) {
        let products = {
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
        sendPayload(save_products_url, products);
    });
</script>