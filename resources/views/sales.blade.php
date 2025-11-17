@extends('layouts.app')
@section('title', 'Sales - Simple Store')
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sellModal">
            New Sale
        </button>
        <!-- table -->
        <div class="card-body">
            <div class="col s12 m12 12">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Products Sold</th>
                            <th>Total Sold</th>
                            <th>Person in Charge</th>
                            <th>Timestamp Sold</th>
                            <th class="actions-column">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-rows">
                        @foreach($sales as $sale)
                            <tr>
                                <td>{{$sale['products']}}</td>
                                <td>{{$sale['total_sold']}}</td>
                                <td>{{$sale['in_charge_name']}}</td>
                                <td>{{$sale['time_stamp']}}</td>
                                <td>                                   
                                    {{-- <button class="btn btn-sm btn-danger">Delete</button> --}}
                                    <form action="{{ route('disable-sell', $sale['id_sold']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this row?')">
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
    <div class="modal fade" id="sellModal" tabindex="-1" aria-labelledby="sellModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="sellModalLabel">Issue Sale</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_store" class="form-label">Store</label>
                            <select name="id_store" id="id_store" class="form-select">
                                <option value="">Select store...</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id_store }}">{{ $store->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div id="container-products"></div>
                        <button type="button" class="btn btn-primary" id="add_product">Add Product</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="save_sells" class="btn btn-primary ">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        var save_sells_url = "{{route('do-sales')}}";
         var products = [
            @foreach ($products as $product)
                                            {
                    id: "{{ $product->id_product }}",
                    name: "{{ $product->product_name }}"
                }{{ !$loop->last ? ',' : '' }}
            @endforeach
                    ];
    </script>
    <script src="{{asset('../logic/sell.js')}}"></script>
@endsection