<div class="modal-content">
    <div class="modal-header bg-gradient-primary text-white">
        <h5 class="modal-title" id="storeModalLabel">Create Store</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form method="POST" action="{{ route('update-store', $store->id_store) }}">
        <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="store_number" class="form-label">Store Number</label>
                <input type="number" name="store_number" id="store_number" class="form-control"
                    value="{{ $store->store_number }}" required>
                @error('store_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="store_name" class="form-label">Store Name</label>
                <input type="text" name="store_name" id="store_name" class="form-control"
                    value="{{ $store->store_name }}" required>
                @error('store_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="total_capital" class="form-label">Store Capital</label>
                <input type="number" inputmode="decimal" step="0.50" min="0" name="total_capital" id="total_capital"
                    class="form-control" value="{{ $store->total_capital }}" required>
                @error('total_capital')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror    
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