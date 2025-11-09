@extends('layouts.app')
@section('title', 'Store - Simple Store')
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#storeModal">
            New Store
        </button>
        <!-- table -->
        <div class="card-body">
            <div class="col s12 m12 12">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Store Number</th>
                            <th>Store Location</th>
                            <th>Total Capital</th>
                            <th>Store Name</th>
                            <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-rows">
                        @foreach($stores as $store)
                            <tr>
                                <td>{{$store->store_number}}</td>
                                <td>{{$store->location_place}}</td>
                                <td>{{$store->total_capital}}</td>
                                <td>{{$store->store_name}}</td>
                                <td>
                                    <a href="{{route('edit-store.modal', $store->id_store)}}" class="btn btn-sm btn-info"
                                        data-bs-toggle="modal" id="editStore" data-bs-target="#editstoreModal"
                                        onclick="event.preventDefault();">
                                        Edit
                                    </a>
                                    {{-- <button class="btn btn-sm btn-danger">Delete</button> --}}
                                    <form action="{{ route('delete-store', $store->id_store) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this store ?')">
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
    <div class="modal fade" id="storeModal" tabindex="-1" aria-labelledby="storeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="storeModalLabel">Create Store</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('create-store') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="store_number" class="form-label">Store Number</label>
                            <input type="number" name="store_number" id="store_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="store_name" class="form-label">Store Name</label>
                            <input type="text" name="store_name" id="store_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="total_capital" class="form-label">Store Capital</label>
                            <input type="number" inputmode="decimal" step="0.50" min="0"  name="total_capital" id="total_capital" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="store_location" class="form-label">Store</label>
                            <select name="store_location" id="store_location" class="form-select">
                                <option value="">Select store...</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id_location }}">{{ $location->location_place }}</option>
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
    <!-- Edit Store Modal -->
    <div class="modal fade" id="editstoreModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('editstoreModal');

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