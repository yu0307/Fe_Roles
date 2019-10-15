$(document).ready(function () {
    InitPrDtable($('#pr_dt_table'));

    $('#pr_management input[name="ListType"]').on('ifChanged', function (event) {
        table.ajax.reload();
    });

    $('#Role_Management_CRUD .roleCtrl').hide();

    $('#Role_Management .ra_addNew').click(function () {
        $('#control_CRUD .buttonSlot').html('<button class="btn btn-success ra_SaveChange" id="ra_SaveChange">Save Changes</button>');
        $('#Role_Management_CRUD a:first').tab('show')
        showCRUD('Role_Management');
    });

    $(document).on('click', '#Role_Management .btn-edit', function () {
        pr_load($(this).attr('data-source'), function (data) {
            $('#control_CRUD .buttonSlot').html('<button class="btn btn-success ra_SaveChange" id="ra_SaveChange">Save Changes</button>');
            showCRUD('Role_Management');
        });
    });

    $(document).on('click', '#ra_SaveChange', function () {
        pr_saveChange(function (data) {
            Notify(data.message, data.status);
            if (data.status == 'success') {
                $('#Role_Management_CRUD input[name="ListType"][value="' + $('#Role_Management_CRUD select[name="ra_type"]').val() + '"]').prop("checked", true);
                table.ajax.reload();
                hideCRUD(function () {
                    $('#control_CRUD .buttonSlot').html('');
                    clearPrWorkSpace();
                });
            }
        });
    });

    $(document).on('click', '#Role_Management .btn-remove', function () {
        pr_remove($(this).attr('data-source'), function (data) {
            if (data !== undefined && !$.isEmptyObject(data)) {
                Notify(data.message, data.status);
                if (data.status == 'success') {
                    table.ajax.reload();
                }
            }
        });
    });

    setTimeout(function () {
        $('#Role_Management_CRUD .role_abilities').select2({
            placeholder: {
                id: '-1', // the value of the option
                text: 'Select abilities to assign to this role'
            },
            multiple: true,
            ajax: {
                url: $('#pr_dt_table').attr('data_target') + '/abilities',
                dataType: 'json',
                type: 'POST'
            }
        });
    }, 220);

});