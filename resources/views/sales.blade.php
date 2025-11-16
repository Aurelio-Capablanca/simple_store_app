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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
            New Sale
        </button>
    </div>
    <script src="{{asset('../logic/products.js')}}"></script>
@endsection