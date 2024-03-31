<x-admin-layout>
    <x-slot name="menu">
        <x-menuConfiguracionGeneral></x-menuConfiguracionGeneral>
    </x-slot>
    <x-slot name="titulo">Usuarios</x-slot>
    <x-table>
        <th>id</th>
        <th>Nombre</th>
        <th>Username</th>
        <th>Rol</th>
        <th>Correo</th>
        <th>Estado</th>
        <th>Creado</th>
        <th>Acciones</th>
    </x-table>
        
    <x-modal>
        
        @csrf
       
        <input type="hidden" id="id" name="id">

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name"
                pattern="[a-zA-ZáéíóúüñÑ\s]{3,255}" title="El nombre solo debe contener letras"
                required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username"
                pattern="[a-zA-ZáéíóúüñÑ_]{3,255}"
                title="El UserName solo debe contener letras y guiones bajos" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <input type="text" class="form-control" id="role" name="role"
                pattern="[a-zA-ZáéíóúüñÑ]{3,30}" title="El Rol solo debe contener letras sin espacios" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-control" id="status" name="status" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>

            </select>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        
    </x-modal>    

    
</x-admin-layout>

<script>
    $(document).ready(function() {
        // Inicializamos las variables para el datatable y funciones
        let model = {
            nombre: 'usuario', // se muestra en vista
            route: '/user',
        };

        let csrf = $('input[name="_token"]').val();
        // Inicializamos las variables para tipo de envio por ajax en Store record
        let method = '';

        // Iniciamos el datatable
        let table = $('#table').DataTable({
            autoWidth: false,
            dom: 'Bfrtip',
            "deferRender": true,
            
            "buttons": [{
                    text: 'Crear ' + model.nombre,
                    className: 'text-white bg-primary',
                    action: function(e, dt, node, config) {
                        method = 'POST';
                        create_New_Record(model.route, model);
                    }
                },
                data_Table_Top_Button(model)
            ],
            "ajax": {
                "url": model.route,
                "dataSrc": "",
              
                

            },
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "username"
                },
                {
                    "data": "role"
                },
                {
                    "data": "email"
                },
                {
                    "data": "status",
                    "render": function(data, type, row) {
                        return (data == 1) ? 'Activo' : 'Inactivo';
                    }
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "id"
                },
            ],
            "columnDefs": [{
                    "targets": [0, -1],
                    'className': 'text-center',

                },
                {
                    "targets": [1],
                    "render": function(data, type, row) {
                        return `<a href="${model.route}/${row['id']}">${data}</a>`;
                    }
                },
                render_actions_Buttons({
                    "model": model,
                    "view": true, //default false
                    "edit": true,
                    "destroy": true,
                })
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            }
        });

        // Edit record
        $(document).on("click", ".btn-edit", function() {

            clean_validate_errors();

            let data = ($(this).parents('tr').hasClass('child')) ?
                table.row($(this).parents().prev('tr')).data() :
                table.row($(this).parents('tr')).data();

            load_Input_for_edit(data);

            $('#modal').modal('show');
            $('.modal-title').text('Editar ' + model.nombre + ' Id: ' + data['id']);

            accion = 'actualizar';
            method = 'PUT';
            url = model.route + '/' + data['id'];
            activate_button_on_input_change();
        });

        // Store record
        $(document).on('click', '.btn-save', function() {
            no_send_form('#form');

            let form = document.getElementById('form');
            if (!form.checkValidity()) {
                return;
            }
            showConfirmSwal({
                accion: accion,
                entidad: model.nombre,
                id: $('#id').val(),
                name: $('#name').val(),
            }).then(confirm => {
                if (confirm == null) {
                    return
                }
                let data = $('#form').serialize();
                $.ajax({
                    type: method,
                    url: url,
                    data: data,
                    success: function(data) {
                        swal_message_response(data) ? table.ajax.reload() : null
                    },
                    error: function(errors) {
                        show_validate_errors(errors);
                    }
                });
            })

        });

        // Destroy record
        $(document).on("click", ".btn-delete", function() {
            let id = $(this).attr('id');
            destroy_record(id,model,csrf,table);
        });

    });
</script>
