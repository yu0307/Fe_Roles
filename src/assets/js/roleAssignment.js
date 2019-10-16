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
});

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
}