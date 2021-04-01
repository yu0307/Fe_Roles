import axios from 'axios';

var abilityCtrl=require('./abilityList').default;
var prevList;
window.ready(()=>{
    prevList=abilityCtrl.InitPrevList(document.getElementById('Sel_usrAssign'),document.getElementById('usrRoleAssignment').getAttribute('data_target'),'roles');
    document.querySelector('#usrRoleAssignment .prev-list').addEventListener('list-updated',(e)=>{
        if(e.detail && e.detail.prevType=='Ability'){
            if(document.querySelector('#usrRoleAssignment input[type="radio"]:checked').value=='abilities') abilityCtrl.fetchAbilities();
        }
    });
    document.getElementById('assignUsrPri').addEventListener('click',()=>{
        assignUsrPri(document.querySelector('#usrBasic #usr_ID').value, function (data) {
            if(window.frameUtil) window.frameUtil.Notify(data);
            refreshUsrAbilities(data.uid);
        });
    });

    document.querySelectorAll('#control_CRUD,#usrManagementCtr').forEach((elm)=>{
        elm.addEventListener('shown-User_Management',(e)=>{
            elm.querySelectorAll('.modal-body,.modal-content').forEach((elm)=>{
                elm.classList.add('overflow-visible');
            })
        });
        elm.querySelectorAll('input[type="radio"][name="ListTypes"]').forEach((lt)=>{
            lt.addEventListener('change',(e)=>{
                if(e.target.checked){
                    prevList.removeActiveItems();
                    if(lt.value=='abilities') abilityCtrl.fetchAbilities(document.getElementById('usrRoleAssignment').getAttribute('data_target'),()=>{reflectPrevs(false)});
                    else abilityCtrl.fetchRoles(document.getElementById('usrRoleAssignment').getAttribute('data_target'),()=>{reflectPrevs(true)});
                }
            });
        });
        elm.addEventListener('usrInfoLoaded',(e)=>{
            elm.querySelector('#usrRoleAssignment').classList.remove('d-none');
            refreshUsrAbilities(e.detail.usrData.id);
        });
        elm.addEventListener('hidden.bs.modal',function(){
            elm.querySelectorAll('.modal-body,.modal-content').forEach((elm)=>{
                elm.classList.remove('overflow-visible');
            });
            elm.querySelector('#usrRoleAssignment').classList.add('d-none');
        });
        
    })
});

function reflectPrevs(role=true){
    (document.querySelectorAll('#usrRoleAssignment .usr-prev-lists '+(role?'.list_Roles':'.list_abilities'))).forEach((elm)=>{
        prevList.setChoiceByValue(parseInt(elm.getAttribute('data')));
    });
}

function assignUsrPri(UID, callback) {

    axios.post(document.getElementById('usrRoleAssignment').getAttribute('data_target')+ '/PriAssign/' + UID,{
        type:(document.querySelector('input[type="radio"][name="ListTypes"]:checked').value||'roles'),
        pr_list: (prevList.getValue(true)||[])
    })
    .then((resp)=>{
        resp.data.uid=UID;
        if (typeof (callback) === 'function') {
            callback(resp.data);
        }
    })
    .catch((err)=>{
        if(window.frameUtil) window.frameUtil.Notify(err);
        else console.log(err);
    });
}

function refreshUsrAbilities(UID) {
    document.querySelector('#usrRoleAssignment .loading').classList.remove('d-none');
    prevList.removeActiveItems();

    if(document.querySelector('input[type="radio"][name="ListTypes"]:checked')==null || document.querySelector('input[type="radio"][name="ListTypes"]:checked').value!=='roles'){
        document.querySelector('input[type="radio"][name="ListTypes"][value="roles"]').checked=true;
        abilityCtrl.fetchRoles(document.getElementById('usrRoleAssignment').getAttribute('data_target'),()=>{
            fetchUsrAbilities(UID);
        });
    }else{
        fetchUsrAbilities(UID);
    }
}

function fetchUsrAbilities(UID){
    loadUsrAbilities(UID, function (data){
        let list = '';
        data.Abilities=(data.Abilities||[]);
        data.Roles=(data.Roles||[]);

        if (data.Roles.length>0) {
            list += `<li class="list-group-item list-group-item-action list-group-item-info">
                        <div class="m-0">Role Abilities</div>
                     </li>
                     <li class="p-0 list-group-item panel-group">
                        <div class="accordion accordion-flush bg-gray-light" id="usrRoleAbilityList">
                            `+(data.Roles).reduce((h,elm)=>{
                                prevList.setChoiceByValue(elm.id);
                                return h+=`
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="RoleHeading_${elm.id}">
                                    <button type="button" class="accordion-button collapsed p-2" data-bs-toggle="collapse" data-bs-target="#Role_${elm.id}" aria-expanded="false" aria-controls="Role_${elm.id}">
                                        <h6 class="m-0 list_Roles" data="${elm.id}">${elm.name}</h6>
                                    </button>
                                    </h2>
                                    <div id="Role_${elm.id}" class="accordion-collapse collapse border-0" aria-labelledby="RoleHeading_${elm.id}" data-bs-parent="#usrRoleAbilityList">
                                    <div class="accordion-body py-0 px-0">
                                        `+(elm.role_abilities||[]).reduce((ah,ability)=>{
                                            return ah+=`<div class="bg-blue-dark list_abilities px-3 border-bottom border-secondary" role="alert" data="${ability.id}">${ability.name}</div>`
                                        },'')+`
                                    </div>
                                    </div>
                                </div>
                                `;
                            },'')+`
                        </div>
                     </li>
                     `;
        }

        if (Object.keys(data.Abilities).length>0) {
            list+=`
            <li class="list-group-item list-group-item-action list-group-item-info p-0">
                <div class="accordion accordion-flush bg-success" id="usrExtraAbilityList">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="noneRoleHeading">
                        <button type="button" class="accordion-button collapsed p-2" data-bs-toggle="collapse" data-bs-target="#noneRole" aria-expanded="false" aria-controls="noneRole">
                            <div class="m-0">None-Role Abilities</div>
                        </button>
                        </h2>
                        <div id="noneRole" class="accordion-collapse collapse border-0" aria-labelledby="noneRoleHeading" data-bs-parent="#usrExtraAbilityList">
                        <div class="accordion-body py-0 px-0">
                            `+(Object.keys(data.Abilities)||[]).reduce((ah,key)=>{
                                return ah+=`<div class="bg-green list_abilities px-3 border-bottom border-green" role="alert" data="${key}">${data.Abilities[key]}</div>`
                            },'')+`
                        </div>
                        </div>
                    </div>
                </div>
            </li>
            `;
        }
        document.querySelector('#RA_AbilityList .usr-prev-lists').innerHTML=list;
        document.querySelector('#usrRoleAssignment .loading').classList.add('d-none');
    });
}

function loadUsrAbilities(UID, callback) {
    axios.post(document.getElementById('usrRoleAssignment').getAttribute('data_target')+ '/GetUserAbilities/' + UID)
    .then((resp)=>{
        if (typeof (callback) === 'function') {
            callback(resp.data);
        }
    })
    .catch((err)=>{
        if(window.frameUtil) window.frameUtil.Notify(err);
        else console.log(err);
    });
}