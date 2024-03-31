<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </div>
                <div class="modal-body">


                    {{ $slot }}

                </div>
                <div class="content-errors d-none">
                    <div class="message_errors col-11 mx-auto"></div><br>
                    <div class=" alert alert-danger col-11 mx-auto">
                        <ul class="validate_errors">

                        </ul>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary btn-save" disabled>Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
