$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.btn-remove', function () {
        pr_remove($(this).attr('data-source'), function (data) {
            if (data !== undefined && !$.isEmptyObject(data)) {
                if (data.status == 'success') {
                    table.ajax.reload();
                } else {
                    alert(data.message);
                }
            }
        });
    });
    $(document).on('click', '.btn-edit', function () {
        pr_load($(this).attr('data-source'), function (data) {
            $('#Role_CRUD').modal('show');
        });
    });

    $('#Role_CRUD').on('hidden.bs.modal', function (e) {
        clearPrWorkSpace();
    });

    $(document).on('click', '#ra_SaveChange', function () {
        pr_saveChange(function (data) {
            if (data.status == 'success') {
                $('input[name="ListType"][value="' + $('#Role_Management_CRUD select[name="ra_type"]').val() + '"]').prop("checked", true);
                table.ajax.reload();
                $('#Role_Management_CRUD').modal('hide');
            } else {
                $('#resp_msg').fadeOut(300, 'linear', function () {
                    $('#resp_msg').html('<div class="alert alert-danger" role="alert">' + data.message + '</div>');
                    $('#resp_msg').fadeIn(300, 'linear', function () {
                        setTimeout(function () {
                            $('#resp_msg').fadeOut(300);
                        }, 3000)
                    });
                })
            }
        });
    });
    InitPrDtable($('#pr_dt_table'));
});
