import axios from 'axios';
import Tabulator from 'tabulator-tables';
var UsrRoleTable;
var abilityList;
var ajaxTarget;

function InitUsrRoleDtable(target) {
    this.UsrRoleTable = new Tabulator('#'+target, {
        ajaxURL:document.getElementById(target).getAttribute('data_target'),
        autoColumns:true,
        autoColumnsDefinitions:[
            {title:"id", field:"id", visible:false}, 
            {title:"role_abilities", field:"role_abilities", visible:false}, 
            {title:"Name", field:"name", sorter:"string", width:200, headerFilter:"input"}, 
            {title:"Description", field:"description", sorter:"string",headerFilter:"input"},
            {title:"Rank", field:"rank", sorter:"number", width:100,headerFilter:"input"},
            {title:"Actions", field:"actions", width:180, cssClass:'options', headerSort:false, formatter:(cell, formatterParams, onRendered)=>{
                let id = cell.getRow().getCell("id").getValue();
                return '<div class="container-fluid"><div class="row m-l-0 m-r-0"><div class="col-md-6 col-sm-12 px-1"><button class="btn btn-sm btn-primary btn-edit" data-source=' + id + '>View/Edit</button></div><div class="col-md-6 col-sm-12 px-1"><button class="btn btn-sm btn-danger btn-remove" data-source=' + id + '>Remove</button></div></div></div>'
            }},
            {title:"Disabled", field:"disabled", sorter:"string", width:100,headerFilter:true,editor:"tickCross", editorParams:{
                tristate:true,
                indeterminateValue:"n/a",
                elementAttributes:{
                    maxlength:"10", //set the maximum character length of the input element to 10 characters
                }
            }}
        ],
        responsiveLayout:true,
        resizableColumns:false,
        layout:"fitColumns",
        ajaxFiltering:true,
        ajaxSorting:true,
        pagination:"remote",
        paginationSize:15,
        paginationSizeSelector:[30, 50, 100, true],
        ajaxRequesting:function(url, params){
            params.ByType=document.querySelector('#pr_management input[type="radio"][name="ListType"]:checked').value||'Role';
        },
        ajaxResponse:function(url, params, response){
            (response.data||[]).forEach((elm)=>{
                elm.actions='';
            });
            return response;
        },
        ajaxConfig:{
            method:"POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        ajaxError:function(error){
            window.frameUtil.Notify(error, 'error');
        }
    });
    this.ajaxTarget=this.UsrRoleTable.element.getAttribute('data_target');
}
function clearWorkingArea(target){
    target.querySelectorAll('input:not([type="radio"],[type="checkbox"]), textarea, select').forEach((elm)=>{
        elm.value="";
    });
    target.querySelectorAll('input[type="radio"],input[type="checkbox"]').forEach((elm)=>{
        elm.classList.remove('checked');
        elm.checked=false;
    });

    target.querySelectorAll('input[type="radio"].default,input[type="checkbox"].default').forEach((elm)=>{
        elm.checked=true;
    });

    target.querySelectorAll('select').forEach((elm)=>{
        elm.value=(elm.querySelector('option[default]')||{value:""}).value;
    });
}
function InitUsrAbilityList(target){
    this.abilityList=new Choices(target,{
        removeItemButton:true,
        duplicateItemsAllowed:false,
        paste:false,
        placeholderValue:'Available abilities...'
    });
    this.fetchAbilities();
}

function fetchAbilities(){
    axios.post(this.ajaxTarget + '/abilities')
    .then((resp)=>{
        if(resp.data){
            this.abilityList.clearStore().clearChoices().setChoices(
                (resp.data.results||[]),
                'id',
                'text',
                true,
              );
        }
    })
    .catch((error)=>{
        if(window.frameUtil) window.frameUtil.Notify(error);
        else console.log(error);
    });
}

function pr_remove(target,type, callback=null) {
    axios.post(this.ajaxTarget+'/delete/' + target,{ByType:type})
    .then((resp)=>{
        if (typeof (callback) == "function") callback(resp.data);
    }).catch((err)=>{
        if(window.frameUtil) window.frameUtil.Notify(err);
        else console.log(err);
    });
}

function pr_saveChange(type, data={}, callback=null) {
    axios.post(this.ajaxTarget+'/save',data)
    .then((resp)=>{
        if(type=='Ability') this.fetchAbilities();
        if (typeof (callback) == "function") callback(resp.data);
    }).catch((err)=>{
        if(window.frameUtil) window.frameUtil.Notify(err);
        else console.log(err);
    });
}

function pr_load(target,type, callback) {
    this.abilityList.removeActiveItems();
    axios.post(this.ajaxTarget+'/'+target,{ByType:type})
    .then((resp)=>{
        resp=resp.data;
        if(resp.type && resp.type == 'Role'){
            this.abilityList.setChoiceByValue((resp.role_abilities||[]).map((ab)=>{return ab.id}));
        }
        if (typeof (callback) == "function") {
            callback(resp);
        }
    }).catch((err)=>{
        if(window.frameUtil) window.frameUtil.Notify(err);
        else console.log(err);
    });
}

export default{
    InitUsrRoleDtable,
    InitUsrAbilityList,
    UsrRoleTable,
    abilityList,
    clearWorkingArea,
    fetchAbilities,
    pr_remove,
    pr_saveChange,
    pr_load
}