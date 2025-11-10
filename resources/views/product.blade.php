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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
            New Product
        </button>
        <a href="{{route('token-get')}}" class="btn btn-sm btn-info" id="gettoken" onclick="call_service();">
            Get Token
        </a>
        <script>
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
    </div>
    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="userModalLabel">Create User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
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
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('editUserModal');

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
    </script>
@endsection