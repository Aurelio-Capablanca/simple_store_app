@extends('layouts.app')
@section('title', 'Product - Simple Store')
@section('content')
    <div class="container-fluid py-2">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- button -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
            New Product
        </button>
        <a class="btn btn-sm btn-info" id="gettoken" onclick="window.location.reload();">
            Get Token
        </a>
        <!-- table -->
        <div class="card-body">
            <div class="col s12 m12 12">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-rows">
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->product_price}}</td>
                                <td>{{$product->category}}</td>
                                <td>
                                    <input type="hidden" id="url-{{ $product->id_product }}"
                                        value="{{route('product-get-one', $product->id_product)}}" name="">                                    
                                    <a class="btn btn-sm btn-info" data-bs-toggle="modal" id="editProduct"
                                        data-bs-target="#editproductModal"
                                        onclick="openUpdateModal( document.getElementById('url-{{ $product->id_product }}').value)">
                                        Edit
                                    </a>
                                    {{-- <button class="btn btn-sm btn-danger">Delete</button> --}}
                                    <form action="{{ route('delete-product', $product->id_product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="productModalLabel">Issue Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="timestap_bill_retailer">date bill retailer</label>
                            <input type="date" class="form-check-label" id="timestap_bill_retailer"
                                name="timestap_bill_retailer">
                        </div>
                        <div class="mb-3">
                            <label for="id_store" class="form-label">Store</label>
                            <select name="id_store" id="id_store" class="form-select">
                                <option value="">Select store...</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id_store }}">{{ $store->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_retailer" class="form-label">Retailer</label>
                            <select name="id_retailer" id="id_retailer" class="form-select">
                                <option value="">Select Retailer...</option>
                                @foreach ($retailers as $retailer)
                                    <option value="{{ $retailer->id_retailer }}">{{ $retailer->retailer_company }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>                        
                        <div id="container-products"></div>
                        <button type="button" class="btn btn-primary" id="add_product">Add Product</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="save_products" class="btn btn-primary ">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit User Modal -->
    <div class="modal fade" id="editproductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="retailerModalLabel">Update Product</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">product name</label>
                            <input type="text" name="product_name" id="product_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_description" class="form-label">product description</label>
                            <input type="text" name="product_description" id="product_description" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label">product price</label>
                            <input type="number" inputmode="decimal" step="0.50" min="0" name="product_price"
                                id="product_price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_stock_number" class="form-label">product Quantity</label>
                            <input type="number" step="1" name="product_stock_number" id="product_stock_number"
                                class="form-control" required>
                        </div>
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" for="has_discount" type="checkbox" id="flexSwitchCheckDefault" style="display:none">
                            <label class="form-check-label" name="has_discount" id="has_discount"
                                for="flexSwitchCheckDefault" style="display:none">has
                                discount</label>
                        </div>
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" for="has_stock" type="checkbox" id="flexSwitchCheckDefault" style="display:none">
                            <label class="form-check-label" name="has_stock" id="has_stock" for="flexSwitchCheckDefault" style="display:none">has
                                stock</label>
                        </div>
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" for="is_available" type="checkbox" id="flexSwitchCheckDefault" style="display:none">
                            <label class="form-check-label" name="is_available" id="is_available"
                                for="flexSwitchCheckDefault" style="display:none">is
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
                        <button id="update-product" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script>
        var save_products_url = "{{route('load-product')}}";
        var update_products_url = "{{route('update-product')}}";

        var categories = [
            @foreach ($categories as $category)
                                            {
                    id: "{{ $category['id_category'] }}",
                    name: "{{ $category['category'] }}"
                }{{ !$loop->last ? ',' : '' }}
            @endforeach
                    ];

        console.log(categories);

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
        }

    </script>
    <script src="{{asset('../logic/products.js')}}"></script>
@endsection