@extends('layouts.app')
@section('title', 'Users - Simple Store')
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
            New User
        </button>
        <!-- table -->
        <div class="card-body">
            <div class="col s12 m12 12">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Store Name</th>
                            <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-rows">
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if (!$user->store_name)
                                        {{ 'No Store Registered' }}
                                    @else
                                        {{$user->store_name}}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('edit-user.modal', $user->id)}}" class="btn btn-sm btn-info"
                                        data-bs-toggle="modal" id="editUsers" data-bs-target="#editUserModal"
                                        onclick="event.preventDefault();">
                                        Edit
                                    </a>
                                    {{-- <button class="btn btn-sm btn-danger">Delete</button> --}}
                                    <form action="{{ route('delete-user', $user->id) }}" method="POST" class="d-inline">
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
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="userModalLabel">Create User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('create-user') }}">
                    <div class="modal-body">
                        @csrf
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