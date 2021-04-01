window.usrRoleManager = require('./roleManagementControl').default;

window.ready(()=>{
    window.usrRoleManager.InitUsrRoleDtable('pr_dt_table');
    window.usrRoleManager.InitUsrAbilityList(document.getElementById('role_abilities'));
    document.getElementById('control_CRUD').addEventListener('hidden.bs.modal',function(){
        document.querySelectorAll('#control_CRUD .modal-body,#control_CRUD .modal-content').forEach((elm)=>{
            elm.classList.remove('overflow-visible');
        })
    });

    document.querySelector('#pr_management .ra_addNew').addEventListener('click',()=>{
        window.usrRoleManager.abilityList.removeActiveItems();
        document.querySelector('#Role_Management_CRUD select[name="ra_type"]').value=(document.querySelector('#pr_management input[type="radio"][name="ListType"]:checked').value||'Ability');
        document.querySelector('#Role_Management_CRUD input[type="radio"][value="false"]').checked=true;
        showModal();
    });

    document.getElementById('ra_type').addEventListener('change',(e)=>{
        document.querySelectorAll('#Role_Management_CRUD .roleCtrl').forEach((r)=>{
            if((e.target.value||'Ability')=='Role'){
                r.classList.remove('d-none');
            }else{
                r.classList.add('d-none');
            }
        });
    });

    document.querySelectorAll('#pr_management input[type="radio"][name="ListType"]').forEach((elm)=>{
        elm.addEventListener('change',()=>{
            window.usrRoleManager.UsrRoleTable.setData();
        });
        elm.addEventListener('click',()=>{
            document.querySelectorAll('#Role_Management_CRUD .roleCtrl').forEach((r)=>{
                if(elm.value == 'Ability'){
                    r.classList.add('d-none');
                }else{
                    r.classList.remove('d-none');
                }
            });
        });
    });

    document.getElementById('Role_Management').addEventListener('click',(e)=>{
        if (e.target.classList.contains('btn-edit')) {
            showModal();
            document.querySelector('#control_CRUD .loading').classList.add('show');
            window.usrRoleManager.pr_load(e.target.getAttribute('data-source'),(document.querySelector('#pr_management input[type="radio"][name="ListType"]:checked').value||'Ability'), function(data){
                document.querySelector('#Role_Management_CRUD input[name="RID"]').value=data.id;
                document.querySelector('#Role_Management_CRUD input[name="name"]').value=data.name;
                document.querySelector('#Role_Management_CRUD textarea[name="description"]').value=data.description;
                document.querySelector('#Role_Management_CRUD select[name="ra_type"]').value=data.type;
                document.querySelector('#Role_Management_CRUD input[name="disabled"][value="' + (data.disabled ? 'true' : 'false') + '"]').checked=true;
                if (data.type == 'Role') {
                    document.querySelectorAll('#Role_Management_CRUD .roleCtrl').forEach((r)=>{
                        if(data.type=='Role'){
                            r.classList.remove('d-none');
                        }else{
                            r.classList.add('d-none');
                        }
                    });
                    document.querySelector('#Role_Management_CRUD input[name="rank"]').value=data.rank;
                }                
                document.querySelector('#control_CRUD .loading').classList.remove('show');
            });
        }else if (e.target.classList.contains('btn-remove')) {
            window.usrRoleManager.pr_remove(e.target.getAttribute('data-source'),(document.querySelector('#pr_management input[type="radio"][name="ListType"]:checked').value||'Ability'), function(data){
                if (data) {
                    if(window.frameUtil) window.frameUtil.Notify(data);
                    if (data.status == 'success') {
                        window.usrRoleManager.UsrRoleTable.setData();
                    }
                }
            });
        }
    });
    document.getElementById('control_CRUD').addEventListener('click',function(e){
        if (e.target.classList.contains('ra_SaveChange')) {
            let data = {};
            let type =(document.querySelector('#pr_management input[type="radio"][name="ListType"]:checked').value||'Ability');
            document.querySelectorAll('#Role_Management_CRUD .form-control:not([type="radio"]):not(.role-control)').forEach((elm)=>{
                data[elm['name']] = elm['value'];
            });
            data['disabled']=(document.querySelector('#Role_Management_CRUD input[type="radio"]:checked').value=='true');
            if(type=='Role'){
                data['rank'] = document.querySelector('#Role_Management_CRUD input[name="rank"]').value;
                data['Abilities']=window.usrRoleManager.abilityList.getValue(true);
            }
            window.usrRoleManager.pr_saveChange(type, data, function(data){
                if(window.frameUtil) window.frameUtil.Notify(data);
                if(data.status=='success'){
                    window.controlUtil.hideCRUD(function(){
                        window.usrRoleManager.UsrRoleTable.setData();
                    });
                }
            });
        }
    });
});

function showModal(){
    document.querySelector('#control_CRUD .buttonSlot').innerHTML='<button class="btn btn-success ra_SaveChange" id="ra_SaveChange">Save Changes</button>';
    document.querySelectorAll('#control_CRUD .modal-body,#control_CRUD .modal-content').forEach((elm)=>{
        elm.classList.add('overflow-visible');
    })
    window.controlUtil.showCRUD('Role_Management');
}