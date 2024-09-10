<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Añadido 'modal-lg' para tamaños más grandes -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Actualización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas actualizar esta persona con los siguientes datos?</p>
                <table class="table table-striped"> <!-- Añadida 'table-striped' para sombreado intercalado -->
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nuevo Valor</th>
                            <th>Antiguo Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Nombre:</th>
                            <td id="modal-nombre"></td>
                            <td class="text-muted" id="old-nombre"></td>
                        </tr>
                        <tr>
                            <th>Primer Apellido:</th>
                            <td id="modal-papellido"></td>
                            <td class="text-muted" id="old-papellido"></td>
                        </tr>
                        <tr>
                            <th>Segundo Apellido:</th>
                            <td id="modal-sapellido"></td>
                            <td class="text-muted" id="old-sapellido"></td>
                        </tr>
                        <tr>
                            <th>Carnet:</th>
                            <td id="modal-carnet"></td>
                            <td class="text-muted" id="old-carnet"></td>
                        </tr>
                        <tr>
                            <th>Celular:</th>
                            <td id="modal-celular"></td>
                            <td class="text-muted" id="old-celular"></td>
                        </tr>
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

        // Actualiza los datos del modal
        function updateModal() {
            document.getElementById('modal-nombre').textContent = document.getElementById('nombre').value;
            document.getElementById('modal-papellido').textContent = document.getElementById('papellido').value;
            document.getElementById('modal-sapellido').textContent = document.getElementById('sapellido').value;
            document.getElementById('modal-carnet').textContent = document.getElementById('carnet').value;
            document.getElementById('modal-celular').textContent = document.getElementById('celular').value;

            document.getElementById('old-nombre').textContent = "{{ $persona->nombre }}";
            document.getElementById('old-papellido').textContent = "{{ $persona->papellido }}";
            document.getElementById('old-sapellido').textContent = "{{ $persona->sapellido }}";
            document.getElementById('old-carnet').textContent = "{{ $persona->carnet }}";
            document.getElementById('old-celular').textContent = "{{ $persona->celular }}";
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
