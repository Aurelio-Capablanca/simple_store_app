@extends('layouts.app')
@section('title', 'Locations - Simple Store')
@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container my-4">

            <h1>Locations</h1>

            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
                Nueva Ubicación
            </button>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lugar</th>
                        <th>País</th>
                        <th>Estado</th>
                        <th>Ciudad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($locations as $loc)
                        <tr>
                            <td>{{ $loc->id_location }}</td>
                            <td>{{ $loc->location_place }}</td>
                            <td>{{ $loc->country_location }}</td>
                            <td>{{ $loc->state_location }}</td>
                            <td>{{ $loc->city_location }}</td>

                            <td>
                                <!-- EDIT BUTTON -->
                                <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    data-id="{{ $loc->id_location }}"
                                    data-place="{{ $loc->location_place }}"
                                    data-country="{{ $loc->country_location }}"
                                    data-state="{{ $loc->state_location }}"
                                    data-city="{{ $loc->city_location }}">
                                    Editar
                                </button>

                                <!-- DELETE -->
                                <form action="{{ route('location.destroy', $loc->id_location) }}"
                                    method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Eliminar ubicación?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </main>



    <!-- 🟦 MODAL CREAR -->
    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('location.store') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Nueva Ubicación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <label>Lugar:</label>
                        <input type="text" name="location_place" class="form-control" required>

                        <label>País:</label>
                        <input type="text" name="country_location" class="form-control" required>

                        <label>Estado:</label>
                        <input type="text" name="state_location" class="form-control" required>

                        <label>Ciudad:</label>
                        <input type="text" name="city_location" class="form-control" required>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary">Guardar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>



    <!-- 🟧 MODAL EDITAR -->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Ubicación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <label>Lugar:</label>
                        <input type="text" id="edit_place" name="location_place" class="form-control" required>

                        <label>País:</label>
                        <input type="text" id="edit_country" name="country_location" class="form-control" required>

                        <label>Estado:</label>
                        <input type="text" id="edit_state" name="state_location" class="form-control" required>

                        <label>Ciudad:</label>
                        <input type="text" id="edit_city" name="city_location" class="form-control" required>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary">Actualizar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // ⭐ JS para llenar modal EDITAR
    document.getElementById('modalEdit').addEventListener('show.bs.modal', function (event) {

        let btn = event.relatedTarget;

        let id = btn.getAttribute('data-id');
        let place = btn.getAttribute('data-place');
        let country = btn.getAttribute('data-country');
        let state = btn.getAttribute('data-state');
        let city = btn.getAttribute('data-city');

        document.getElementById('edit_place').value = place;
        document.getElementById('edit_country').value = country;
        document.getElementById('edit_state').value = state;
        document.getElementById('edit_city').value = city;

        document.getElementById('formEdit').action = "/location/" + id;
    });
    </script>
    
@endsection



