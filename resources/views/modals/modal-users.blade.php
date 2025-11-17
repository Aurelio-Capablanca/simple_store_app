<!-- Modal -->
<div class="modal-content">
  <div class="modal-header bg-gradient-primary text-white">
    <h5 class="modal-title" id="userModalLabel">Update User</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <form action="{{ route('update-user', $user->id) }}" method="POST">
    @csrf
    @method('PUT')   
    <div class="modal-body">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
          value="{{ $user->name }}" required>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control">
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
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
      @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-primary">Save</button>
    </div>
  </form>
</div>