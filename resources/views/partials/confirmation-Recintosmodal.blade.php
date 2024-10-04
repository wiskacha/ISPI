<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Añadido 'modal-lg' para tamaños más grandes -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Actualización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas actualizar este recinto con los siguientes datos?</p>
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
                            <th>Nombre Recinto:</th>
                            <td id="modal-nombre"></td>
                            <td class="text-muted" id="old-nombre"></td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td id="modal-direccion"></td>
                            <td class="text-muted" id="old-direccion"></td>
                        </tr>
                        <tr>
                            <th>Tipo:</th>
                            <td id="modal-tipo"></td>
                            <td class="text-muted" id="old-tipo"></td>
                        </tr>
                        <tr>
                            <th>Teléfono:</th>
                            <td id="modal-telefono"></td>
                            <td class="text-muted" id="old-telefono"></td>
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
            document.getElementById('modal-direccion').textContent = document.getElementById('direccion').value;
            document.getElementById('modal-tipo').textContent = document.getElementById('tipo').value;
            document.getElementById('modal-telefono').textContent = document.getElementById('telefono').value;

            document.getElementById('old-nombre').textContent = "{{ $recinto->nombre }}";
            document.getElementById('old-direccion').textContent = "{{ $recinto->direccion }}";
            document.getElementById('old-tipo').textContent = "{{ $recinto->tipo }}";
            document.getElementById('old-telefono').textContent = "{{ $recinto->telefono }}";
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
