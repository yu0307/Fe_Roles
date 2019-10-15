var table;

$(document).ready(function () {
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

    $('#pr_management input[name="ListType"]').change(function () {
        table.ajax.reload();
    });

    $('#ra_type').change(function () {
        if ($(this).val() == 'Ability') {
            $('#Role_Management_CRUD .roleCtrl').hide();
        } else {
            $('#Role_Management_CRUD .roleCtrl').show();
        }
    });
});

function pr_remove(target, callback) {
    $.ajax({
        "type": 'POST',
        "url": $('#pr_dt_table').attr('data_target') + '/delete/' + target,
        "dataType": 'json',
        "data": {
            "ByType": $('#pr_management input[name="ListType"]:checked').val()
        },
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            if (typeof (callback) == "function") {
                callback(data);
            }
        }
    });
}

function pr_load(target, callback) {
    $.ajax({
        "type": 'POST',
        "url": $('#pr_dt_table').attr('data_target') + '/' + target,
        "dataType": 'json',
        "data": {
            "ByType": $('#pr_management input[name="ListType"]:checked').val()
        },
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            if (data !== undefined && !$.isEmptyObject(data)) {
                $('#Role_Management_CRUD input[name="RID"]').val(data.id);
                $('#Role_Management_CRUD input[name="name"]').val(data.name);
                $('#Role_Management_CRUD textarea[name="description"]').val(data.description);
                $('#Role_Management_CRUD select[name="ra_type"]').val(data.type).trigger('change');
                $('#Role_Management_CRUD input[name="disabled"][value="' + (data.disabled ? 'true' : 'false') + '"]').attr('checked', true);
                if (data.type == 'Role') {
                    $('#Role_Management_CRUD .roleCtrl').show();
                    $('#Role_Management_CRUD input[name="rank"]').val(data.rank);
                }

                if (data.role_abilities !== undefined && !$.isEmptyObject(data.role_abilities)) {
                    var abilities = [];
                    $(data.role_abilities).each(function (idx, elm) {
                        var option = new Option(elm.name, elm.id, true, true);
                        $('#role_abilities').append(option).trigger('change');
                        abilities.push({ 'id': elm.id, 'text': elm.name });
                    });
                    $('#role_abilities').trigger({
                        type: 'select2:select',
                        params: {
                            data: abilities
                        }
                    });
                }
                if (typeof (callback) == "function") {
                    callback(data);
                }
            }
        }
    });
}

function pr_saveChange(callback) {
    var data = {};
    $.each($('#Role_Management_CRUD .form-control:not(#role_abilities)').serializeArray(), function (idx, elm) {
        data[elm['name']] = elm['value'];
    });
    if ($('#ra_type').val() == 'Role') {
        data['Abilities'] = [];
        $('#role_abilities').find(':selected').each(function (idx, elm) {
            data['Abilities'].push($(elm).val());
        })
    }
    $.ajax({
        "type": 'POST',
        "url": $('#pr_dt_table').attr('data_target') + '/save',
        "dataType": 'json',
        "data": data,
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            if (data !== undefined && !$.isEmptyObject(data)) {
                message = '';
                message += jQuery.map(data.errors, function (n, i) {
                    return ('<div class="error c-red">' + i + ':' + n + '</div>');
                }).join("");
                if (message.length > 0) {
                    data.status = 'error';
                }
                data.message += message;
                if (typeof (callback) == "function") {
                    callback(data);
                }
            }
        }
    });
}

function clearPrWorkSpace(callback) {
    $('#Role_Management_CRUD .form-control:not([type="radio"])').val('').removeAttr('checked').trigger('change');;
    $('#Role_Management_CRUD select[name="ra_type"]').val('Ability');
    $('#Role_Management_CRUD input[name="disabled"][value="false"]').attr('checked', true);
    $('#role_abilities').val(null).html('').trigger('change');
    $('#pr_management #resp_msg').html('');
    $('#Role_Management_CRUD .roleCtrl').hide();
    if (typeof (callback) == 'function') {
        callback();
    }
}

function InitPrDtable(target) {
    table = $(target).DataTable({
        "processing": true,
        "searching": false,
        "serverSide": true,
        "autoWidth": false,
        "lengthMenu": [10, 30, 50, 100],
        columns: [
            { data: 'name' },
            { data: 'description' },
            { data: 'disabled', "width": "60px" },
            { data: 'rank', "width": "60px" },
            { data: 'options', "width": "160px" },
        ],
        "columnDefs": [
            { className: "options", "targets": -1 }
        ],
        "ajax": {
            "url": $(target).attr('data_target'),
            "type": "POST",
            "data": function (d) {
                d.ByType = $('#pr_management input[name="ListType"]:checked').val();
                d.page = $(target).DataTable().page.info().page + 1;
            },
            "dataSrc": function (json) {
                $(json.data).each(function (idx, elm) {
                    if ($('#pr_management input[name="ListType"]:checked').val() == 'Ability') {
                        elm.rank = 'N/A';
                    }
                    elm.disabled = elm.disabled ? 'Disabled' : 'Active';
                    elm.options = '<div class="row m-l-0 m-r-0"><div class="col-md-6 col-sm-12"><button class="btn btn-sm btn-primary btn-edit" data-source=' + elm.id + '>View/Edit</button></div><div class="col-md-6 col-sm-12"><button class="btn btn-sm btn-danger btn-remove" data-source=' + elm.id + '>Remove</button></div></div>';
                });

                return json.data;
            }
        },
    });
}