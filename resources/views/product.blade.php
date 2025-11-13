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
        <a href="{{route('token-get')}}" class="btn btn-sm btn-info" id="gettoken" onclick="call_service();">
            Get Token
        </a>
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
                        <div class="mb-3">
                            <label for="name" class="form-label">Insert Code</label>
                            <input type="text" name="unique_code" id="unique_code" class="form-control" required>
                        </div>
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
        <div class="modal-dialog modal-dialog-centered"></div>
    </div>    
    <script>
        var save_products_url = "{{route('load-product')}}";

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