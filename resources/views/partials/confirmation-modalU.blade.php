<style>
    @media (max-width: 700px) {
        .modal-dialog {
            max-width: 98%;
            margin: 1%;
        }
        .modal-content {
            border-radius: 0;
            height: 100%;
        }
        .modal-body {
            overflow-y: auto;
        }
        .modal-footer {
            flex-direction: column;
            align-items: stretch;
        }
        .modal-footer .btn {
            margin-top: 10px;
        }
    }
</style>


<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Actualización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas actualizar este usuario con los siguientes datos?</p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nuevo Valor</th>
                            <th>Antiguo Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Nick:</th>
                            <td id="modal-nick"></td>
                            <td class="text-muted" id="old-nick"></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td id="modal-email"></td>
                            <td class="text-muted" id="old-email"></td>
                        </tr>
                        <!-- Add more fields as necessary -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirm-update">Actualizar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('update-form');
        const confirmBtn = document.getElementById('confirm-update');
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));

        // Update modal content
        function updateModal() {
            document.getElementById('modal-nick').textContent = document.getElementById('nick').value;
            document.getElementById('modal-email').textContent = document.getElementById('email').value;

            document.getElementById('old-nick').textContent = "{{ $user->nick }}";
            document.getElementById('old-email').textContent = "{{ $user->email }}";
        }

        document.getElementById('update-btn').addEventListener('click', function() {
            updateModal();
            modal.show();
        });

        confirmBtn.addEventListener('click', function() {
            form.submit();
        });

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmModalEl = document.getElementById('confirmModal');
        const confirmModal = new bootstrap.Modal(confirmModalEl);

        document.getElementById('confirm-update').addEventListener('click', function() {
            // Hide the modal when the user clicks 'Actualizar'
            confirmModal.hide();
        });

        document.querySelectorAll('.btn-close, .btn-secondary').forEach(btn => {
            btn.addEventListener('click', function() {
                // Forcefully hide the modal on close/cancel buttons
                confirmModal.hide();
            });
        });

        confirmModalEl.addEventListener('hidden.bs.modal', function() {
            // Ensure no lingering backdrop
            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
        });
    });
</script>
