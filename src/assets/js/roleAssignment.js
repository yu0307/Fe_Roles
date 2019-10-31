$(document).ready(function () {
    setTimeout(function () {
        usrAssignInitSelect();
    }, 225);
    $('#usrRoleAssignment input[name="usrAssignType"]').change(function () {
        usrAssignInitSelect();
    });
    $('#usrRoleAssignment input[name="usrAssignType"]').on('ifChanged', function (event) {
        usrAssignInitSelect();
    });

    $(document).on('usrInfoLoaded', '#User_Management_CRUD,#usrManagementCtr', function (e, data) {
        refreshUsrAbilities(data.id);
    });

    $('#assignUsrPri').click(function () {
        assignUsrPri($('#usrBasic #usr_ID').val(), function (data) {
            Notify(data.message, (data.status !== undefined ? data.status : 'info'));
            refreshUsrAbilities($('#usrBasic #usr_ID').val());
        });
    });
});

function refreshUsrAbilities(UID) {
    $('#usrAssign_ByRole').iCheck('check');
    loadUsrAbilities(UID, function (data) {
        var list = '';
        if (!$.isEmptyObject(data.Abilities)) {
            list += '<li class="list-group-item list-group-item-action list-group-item-info"><h5 class="m-0">None-Role Abilities</h5></li>';
            $.each(data.Abilities, function (index, elm) {
                list += '<li class="list-group-item list_abilities m-b-10 p-10 alert-warning" role="alert" data="' + index + '">' + elm + '</li>';
            });
        }
        if (!$.isEmptyObject(data.Roles)) {
            list += '<li class="list-group-item list-group-item-action list-group-item-info"><h5 class="m-0">Role Abilities</h5></li><li id="usrRoleAbilityList" class="list-group-item panel-group panel-accordion dark-accordion">';
            $.each(data.Roles, function (index, elm) {
                list += '<div class="card panel panel-default">' +
                    '<div class="card-header panel-heading" id="RoleHeading_' + elm.id + '">' +
                    '<h5 class="m-0">' +
                    '<a class="collapsed bg-primary usrroles" data-toggle="collapse" data-target="#Role_' + elm.id + '" aria-expanded="false" aria-controls="Role_' + elm.id + '">' +
                    '<i class="fa fa-chevron-right hidden t-white text-white pull-left"></i>' +
                    '<i class="fa fa-chevron-down hidden pull-left"></i>' +
                    '<h6 class="m-0 list_Roles" data="' + elm.id + '">' + elm.name + '</h6>' +
                    '</a>' +
                    '</h5>' +
                    '</div>' +
                    '<div id="Role_' + elm.id + '" class="panel-collapse collapse" aria-labelledby="RoleHeading_' + elm.id + '" data-parent="#usrRoleAbilityList">' +
                    '<div class="card-body panel-body p-0">';
                $.each(elm.role_abilities, function (idx, ability) {
                    list += '<div class="list_abilities p-1 p-10 p-l-20 pl-3 alert-warning" role="alert" data="' + ability.id + '">' + ability.name + '</div>';
                });
                list += '</div>' +
                    '</div>' +
                    '</div>';
            });
            list += '</li>';
        }

        $('#RA_AbilityList ul.list-group:first').html(list);
        UsrpresetSelect();
    });
}

function loadUsrAbilities(UID, callback) {
    $('#RA_AbilityList ul.list-group:first').html('<li class="list-group-item"> <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i> <span class="text-2x">Loading...</span> </li>');
    $.ajax({
        type: 'POST',
        url: $('#usrRoleAssignment').attr('data_target') + '/GetUserAbilities/' + UID,
        dataType: 'json',
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            if (data !== undefined && !$.isEmptyObject(data)) {
                if (typeof (callback) === 'function') {
                    callback(data);
                }
            }
        }
    });
}

function assignUsrPri(UID, callback) {
    var dat = {
        type: $('#usrRoleAssignment input[name="usrAssignType"]:checked').val(),
        pr_list: []
    };
    $('#Sel_usrAssign').find(':selected').each(function (idx, elm) {
        dat.pr_list.push($(elm).val());
    })
    $.ajax({
        type: 'POST',
        url: $('#usrRoleAssignment').attr('data_target') + '/PriAssign/' + UID,
        dataType: 'json',
        data: dat,
        complete: function (jqXHR, status) {
            var data = jqXHR.responseJSON;
            if (data !== undefined && !$.isEmptyObject(data)) {
                if (typeof (callback) === 'function') {
                    callback(data);
                }
            }
        }
    });
}

function UsrpresetSelect() {
    $('#usrRoleAssignment #Sel_usrAssign').empty().trigger('change');
    var optionlist = [];
    $('#usrRoleAssignment ' + (($('#usrRoleAssignment input[name="usrAssignType"]:checked').val() == 'abilities') ? '.list_abilities' : '.list_Roles')).each(function (idx, elm) {
        if (($('#usrRoleAssignment #Sel_usrAssign').find('option[value="' + $(elm).attr('data') + '"]').length) <= 0) {
            $('#usrRoleAssignment #Sel_usrAssign').append(new Option($(elm).text(), $(elm).attr('data'), true, true)).trigger('change');
            optionlist.push({ 'id': $(elm).attr('data'), 'text': $(elm).text() });
        }
    });
    $('#usrRoleAssignment #Sel_usrAssign').trigger({
        type: 'select2:select',
        params: {
            data: optionlist
        }
    });
}

function usrAssignInitSelect() {
    $('#usrRoleAssignment #Sel_usrAssign').empty().trigger('change');
    $('#usrRoleAssignment #Sel_usrAssign').select2({
        placeholder: {
            id: '-1', // the value of the option
            text: 'Select abilities/Roles to assign to this role'
        },
        multiple: true,
        ajax: {
            url: $('#usrRoleAssignment').attr('data_target') + '/' + $('#usrRoleAssignment input[name="usrAssignType"]:checked').val(),
            dataType: 'json',
            type: 'POST'
        }
    });
    UsrpresetSelect();
}