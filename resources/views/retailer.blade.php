@extends('layouts.app')
@section('title', 'Retailers - Simple Store')
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#retailerModal">
            New Retailer
        </button>
        <!-- table -->
        <div class="card-body">
            <div class="col s12 m12 12">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Retailer Name</th>
                            <th>Retailer Company</th>
                            <th>Retailer Phone</th>
                            <th>Retailer Email</th>
                            <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-rows">
                        @foreach($retailers as $retailer)
                            <tr>
                                <td>{{$retailer->retailer_name}}</td>
                                <td>{{$retailer->retailer_company}}</td>
                                <td>{{$retailer->retailer_phone}}</td>
                                <td>{{$retailer->retailer_email}}</td>
                                <td>
                                    <a href="{{route('edit-retailer.modal', $retailer->id_retailer)}}"
                                        class="btn btn-sm btn-info" data-bs-toggle="modal" id="editretailers"
                                        data-bs-target="#editretailerModal" onclick="event.preventDefault();">
                                        Edit
                                    </a>
                                    {{-- <button class="btn btn-sm btn-danger">Delete</button> --}}
                                    <form action="{{ route('delete-retailer', $retailer->id_retailer) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this retailer?')">
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
        <!-- Modal -->
        <div class="modal fade" id="retailerModal" tabindex="-1" aria-labelledby="retailerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title" id="retailerModalLabel">Create Retrailer</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('create-retailer') }}">
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <label for="retailer_name" class="form-label">Retailer Name</label>
                                <input type="text" name="retailer_name" id="retailer_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="retailer_company" class="form-label">Retailer Company</label>
                                <input type="text" name="retailer_company" id="retailer_company" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="retailer_phone" class="form-label">Retailer Phone</label>
                                <input type="text" name="retailer_phone" id="retailer_phone" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="retailer_email" class="form-label">Retailer Email</label>
                                <input type="email" name="retailer_email" id="retailer_email" class="form-control">
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
        <!-- Edit retailer Modal -->
        <div class="modal fade" id="editretailerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('editretailerModal');
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