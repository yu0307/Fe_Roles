var table;
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#role_abilities').select2({
        placeholder:{
            id: '-1', // the value of the option
            text: 'Select abilities to assign to this role'
        },
        multiple:true,
        ajax: {
            url: $('#dt_table').attr('data_target')+'/abilities',
            dataType: 'json',
            type: 'POST'
        }
    });

    $('input[name="ListType"]').change(function(){
        table.ajax.reload();
    });
    
    $('#ra_type').change(function(){
        if($(this).val()=='Ability'){
            $('.roleCtrl').hide();
        }else{
            $('.roleCtrl').show();
        }
    });

    $(document).on('click','.btn-remove',function(){
        $.ajax({
            "type": 'POST',
            "url": $('#dt_table').attr('data_target')+'/delete/'+$(this).attr('data-source'),
            "dataType": 'json',
            "data":{
                "ByType":$('input[name="ListType"]:checked').val()
            },
            complete: function (jqXHR, status) {
                var data = jqXHR.responseJSON;
                if (data !== undefined && !$.isEmptyObject(data)) {
                    if(data.status=='success'){
                        table.ajax.reload();
                    }else{
                        alert(data.message);
                    }
                }
            }
        });
    });
    $(document).on('click','.btn-edit',function(){
        $.ajax({
            "type": 'POST',
            "url": $('#dt_table').attr('data_target')+'/'+$(this).attr('data-source'),
            "dataType": 'json',
            "data":{
                "ByType":$('input[name="ListType"]:checked').val()
            },
            complete: function (jqXHR, status) {
                var data = jqXHR.responseJSON;
                if (data !== undefined && !$.isEmptyObject(data)) {
                    $('#roleCRUD input[name="RID"]').val(data.id);
                    $('#roleCRUD input[name="name"]').val(data.name);
                    $('#roleCRUD textarea[name="description"]').val(data.description);
                    $('#roleCRUD select[name="ra_type"]').val(data.type);
                    $('#roleCRUD input[name="disabled"][value="'+(data.disabled?'true':'false')+'"]').attr('checked',true);
                    if(data.type=='Role'){ 
                        $('.roleCtrl').show();
                        $('#roleCRUD input[name="rank"]').val(data.rank);
                    }
                    if(data.role_abilities!==undefined && !$.isEmptyObject(data.role_abilities)){
                        var abilities=[];
                        $(data.role_abilities).each(function(idx,elm){
                            var option = new Option(elm.name, elm.id, true, true);
                            $('#role_abilities').append(option).trigger('change');
                            abilities.push({'id':elm.id,'text':elm.name});
                        });
                        $('#role_abilities').trigger({
                            type: 'select2:select',
                            params: {
                                data: abilities
                            }
                        });
                    }
                    $('#roleCRUD').modal('show');
                }
            }
        });
    });
    
    $('#roleCRUD').on('hidden.bs.modal', function (e) {
        $('#roleCRUD .form-control:not([type="radio"])').val('').removeAttr('checked').trigger('change');;
        $('#roleCRUD select[name="ra_type"]').val('Ability');
        $('#roleCRUD input[name="disabled"][value="false"]').attr('checked',true);
        $('#resp_msg').html('');
        $('.roleCtrl').hide();
    });

    $(document).on('click','#ra_SaveChange',function(){
        var data = {};
        $.each($('#roleCRUD .form-control:not(#role_abilities)').serializeArray(), function (idx, elm) {
            data[elm['name']] = elm['value'];
        });
        if($('#ra_type').val()=='Role'){
            data['Abilities']=[];
            $('#role_abilities').find(':selected').each(function(idx,elm){
                data['Abilities'].push($(elm).val());
            })
        }
        $.ajax({
            "type": 'POST',
            "url": $('#dt_table').attr('data_target')+'/save',
            "dataType": 'json',
            "data":data,
            complete: function (jqXHR, status) {
                var data = jqXHR.responseJSON;
                if (data !== undefined && !$.isEmptyObject(data)) {
                    message = data.message;
                    message += jQuery.map(data.errors, function (n, i) {
                        return ('<div class="error c-red">' + i + ':' + n + '</div>');
                    }).join("");
                    if(data.status=='success'){
                        // $('input[name="ListType"]').removeAttr('checked');
                        $('input[name="ListType"][value="'+$('#roleCRUD select[name="ra_type"]').val()+'"]').prop("checked", true);
                        $('#roleCRUD').modal('hide');
                        table.ajax.reload();
                    }else{
                        $('#resp_msg').fadeOut(300,'linear',function(){
                            $('#resp_msg').html('<div class="alert alert-danger" role="alert">'+message+'</div>');
                            $('#resp_msg').fadeIn(300,'linear',function(){
                                setTimeout(function(){
                                    $('#resp_msg').fadeOut(300);
                                },3000)
                            });
                        })
                        
                    }
                }
            }
        });
    });

    table=$('#dt_table').DataTable( {
        "processing": true,
        "searching": false,
        "serverSide": true,
        "lengthMenu": [ 10, 30, 50,100 ],
        columns: [
            { data: 'name' },
            { data: 'description' },
            { data: 'disabled' },
            { data: 'rank' },
            { data: 'options' },
        ],
        "columnDefs": [
            { className: "options", "targets": -1,width: "160px" },
            { width: "60px", "targets": 2 },
            { width: "60px", "targets": 3 }
        ],
        "ajax":{
            "url": $('#dt_table').attr('data_target'),
            "type": "POST",
            "data": function ( d ) {
                d.ByType=$('input[name="ListType"]:checked').val();
                d.page = $('#dt_table').DataTable().page.info().page + 1;
            },
            "dataSrc": function ( json ) {
                $(json.data).each(function(idx,elm){
                    if($('input[name="ListType"]:checked').val()=='Ability'){
                        elm.rank='N/A';
                    }
                    elm.disabled=elm.disabled?'Disabled':'Active';
                    elm.options='<div class="row"><div class="col-md-6 col-sm-12"><button class="btn btn-sm btn-primary btn-edit" data-source='+elm.id+'>View/Edit</button></div><div class="col-md-6 col-sm-12"><button class="btn btn-sm btn-danger btn-remove" data-source='+elm.id+'>Remove</button></div></div>';
                });
                
                return json.data;
              }
          },
    } );
});