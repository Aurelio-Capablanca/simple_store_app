<div class="modal-content">
    <div class="modal-header bg-gradient-primary text-white">
        <h5 class="modal-title" id="retailerModalLabel">Update Retrailer</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>    
    <form method="POST" action="{{ route('update-retailer', $retailer->id_retailer) }}">
        <div class="modal-body">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="retailer_name" class="form-label">Retailer Name</label>
                <input type="text" name="retailer_name" id="retailer_name" class="form-control"
                    value="{{ $retailer->retailer_name }}" required>
                @error('retailer_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="retailer_company" class="form-label">Retailer Company</label>
                <input type="text" name="retailer_company" id="retailer_company" class="form-control"
                    value="{{ $retailer->retailer_company }}" required>
                @error('retailer_company')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="retailer_phone" class="form-label">Retailer Phone</label>
                <input type="text" name="retailer_phone" id="retailer_phone" value="{{$retailer->retailer_phone}}"
                    class="form-control">
                @error('retailer_phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="retailer_email" class="form-label">Retailer Email</label>
                <input type="email" name="retailer_email" id="retailer_email" value="{{ $retailer->retailer_email }}"
                    class="form-control">
                @error('retailer_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>