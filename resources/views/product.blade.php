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
                            <input type="date" class="form-check-label" id="timestap_bill_retailer" name="timestap_bill_retailer">
                        </div>
                         <div class="mb-3">
                            <label for="id_store" class="form-label">Store</label>
                            <select name="id_store" id="id_store" class="form-select">
                                <option value="">Select store...</option>
                            </select>
                        </div>
                         <div class="mb-3">
                            <label for="id_retailer" class="form-label">Retailer</label>
                            <select name="id_retailer" id="id_retailer" class="form-select">
                                <option value="">Select Retailer...</option>
                            </select>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="name" class="form-label">Insert Code</label>
                            <input type="text" name="unique_code" id="unique_code" class="form-control" required>
                        </div>
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
                            <input type="text" name="product_price" id="product_price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="buying_price" class="form-label">buying price</label>
                            <input type="text" name="buying_price" id="buying_price" class="form-control" required>
                        </div>
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" for="has_discount" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" name="has_discount" id="has_discount"
                                for="flexSwitchCheckDefault">has discount</label>
                        </div>
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" for="has_stock" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" name="has_stock" id="has_stock" for="flexSwitchCheckDefault">has
                                stock</label>
                        </div>
                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" for="is_available" type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" name="is_available" id="is_available"
                                for="flexSwitchCheckDefault">is available</label>
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
                        <button type="submit" class="btn btn-primary">Save</button>
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


    </script>
@endsection