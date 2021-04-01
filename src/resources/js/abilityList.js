import Choices from 'choices.js';
function InitPrevList(target,url,initType='abilities'){
    this.abAjaxURL=url;
    this.list=new Choices(target,{
        removeItemButton:true,
        duplicateItemsAllowed:false,
        paste:false,
        placeholderValue:'Available abilities...',
        classNames: {containerInner:'choices__inner form-select'}
    });
    if(initType=='abilities') this.fetchAbilities();
    else this.fetchRoles();
    return this.list;
}

function fetchRoles(url=null,callback=null){
    axios.post((url||this.abAjaxURL)+'/roles')
    .then((resp)=>{
        if(resp.data){
            this.list.clearStore().clearChoices().setChoices(
                (resp.data.results||[]),
                'id',
                'text',
                true,
              );
            if (typeof (callback) == "function") callback();
        }
    })
    .catch((error)=>{
        if(window.frameUtil) window.frameUtil.Notify(error);
        else console.log(error);
    });
}

function fetchAbilities(url=null,callback=null){
    axios.post((url||this.abAjaxURL)+'/abilities')
    .then((resp)=>{
        if(resp.data){
            this.list.clearStore().clearChoices().setChoices(
                (resp.data.results||[]),
                'id',
                'text',
                true,
            );
            if (typeof (callback) == "function") callback();
        }
    })
    .catch((error)=>{
        if(window.frameUtil) window.frameUtil.Notify(error);
        else console.log(error);
    });
}

export default{
    InitPrevList,
    fetchAbilities,
    fetchRoles
}