@extends('layouts.app')
@section('title', 'Categories - Simple Store')
@section('content')

<h1>Categories</h1>
<!-- BOTÓN ABRIR MODAL CREAR -->
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCreate">
                        Nueva Categoría
            </button>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Categoría</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id_category }}</td>
                                    <td>{{ $category->category }}</td>

                                    <td>

                                        <!-- BOTÓN EDITAR (ABRE MODAL Y PASA LOS DATOS) -->
                                        <button class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit"
                                            data-id="{{ $category->id_category }}"
                                            data-category="{{ $category->category }}">
                                            Editar
                                        </button>

                                        <!-- DELETE -->
                                        <form action="{{ route('category.destroy', $category->id_category) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Eliminar categoría?')">
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
                        <form method="POST" action="{{ route('category.store') }}">
                            @csrf

                            <div class="modal-header">
                                <h5 class="modal-title">Nueva categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <label>Categoría:</label>
                                <input type="text" name="category" class="form-control" required>
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
                        <!-- Este form será llenado dinámicamente con JS -->
                        <form id="formEdit" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Editar categoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <label>Categoría:</label>
                                <input type="text" id="editCategory" name="category" class="form-control" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>



            <!-- Bootstrap y JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

            <script>
            // ⭐ Cargar datos en el modal EDITAR
            const modalEdit = document.getElementById('modalEdit');

            modalEdit.addEventListener('show.bs.modal', function (event) {
                let button = event.relatedTarget;

                let id = button.getAttribute('data-id');
                let category = button.getAttribute('data-category');

                // Rellenar input
                document.getElementById('editCategory').value = category;

                // Update acción del formulario
                let form = document.getElementById('formEdit');
                form.action = "/category/" + id; 
            });
            </script>
   
@endsection
