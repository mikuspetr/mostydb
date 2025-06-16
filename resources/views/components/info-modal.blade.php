<div class="modal" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            {{ $message }}
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
    var myModal = new bootstrap.Modal(document.getElementById('{{ $modalId }}'));
    myModal.show();
</script>
@endpush
