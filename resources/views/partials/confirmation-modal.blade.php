<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Actualización</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas actualizar esta persona con los siguientes datos?</p>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Nombre:</th>
                            <td id="modal-nombre"></td>
                            <td class="text-muted">Antiguo: <span id="old-nombre"></span></td>
                        </tr>
                        <tr>
                            <th>Primer Apellido:</th>
                            <td id="modal-papellido"></td>
                            <td class="text-muted">Antiguo: <span id="old-papellido"></span></td>
                        </tr>
                        <tr>
                            <th>Segundo Apellido:</th>
                            <td id="modal-sapellido"></td>
                            <td class="text-muted">Antiguo: <span id="old-sapellido"></span></td>
                        </tr>
                        <tr>
                            <th>Carnet:</th>
                            <td id="modal-carnet"></td>
                            <td class="text-muted">Antiguo: <span id="old-carnet"></span></td>
                        </tr>
                        <tr>
                            <th>Celular:</th>
                            <td id="modal-celular"></td>
                            <td class="text-muted">Antiguo: <span id="old-celular"></span></td>
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
