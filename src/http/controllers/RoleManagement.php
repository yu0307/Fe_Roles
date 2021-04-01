<?php

namespace feiron\fe_roles\http\controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use feiron\fe_roles\models\fe_roles;
use feiron\fe_roles\models\fe_abilities;
use feiron\fe_roles\models\fe_User;

class RoleManagement extends Controller
{
    public function list(Request $request){
        $datainfo = [];
        if($request->input('ByType')=='Role'){
            $QueryBuilder= fe_roles::with('RoleAbilities');
        }else{
            $QueryBuilder=fe_abilities::query();
        }
        $columnName = $request->has('sorters')?$request->input('sorters')[0]['field']:'name'; // Column name
        $columnSortOrder = $request->has('sorters')?$request->input('sorters')[0]['dir']:'asc'; // asc or desc

        $datainfo['recordsTotal'] = $QueryBuilder->count();
        $datainfo['rowperpage'] = $request->input('size');
        $datainfo['last_page'] = ceil($QueryBuilder->count()/$datainfo['rowperpage']);
        $datainfo['page'] = $request->input('page');

        // Building column specific search--------------------------
        $QueryBuilder->where(
            function ($query) use ($request) {
                foreach ($request->input('filters')??[] as $column) {
                    if (isset($column['value'])) {
                        $query->where($column['field'],'like', ('%'.$column['value'].'%'));
                    }
                }
            }
        );
        

        $datainfo['recordsFiltered'] = $QueryBuilder->count();
        $datainfo['data'] = $QueryBuilder->orderBy($columnName, $columnSortOrder)->paginate($datainfo['rowperpage'])->makeVisible('RoleAbilities')->flatten()->toArray();

        return response()->json($datainfo);
    }

    public function save(Request $request){
        if($request->filled('ra_type')){
            $customMessages = [
                'name.required'    => 'Privilege name cannot be empty',
                'name.unique'      => 'Privilege name is already in the system',
                'rank.numeric'    =>'Rank must be numeric values'
            ];
            $updates = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'disabled' => ($request->input('disabled')=='true')
            ];
            if($request->input('ra_type')=='Ability'){
                $rules['name'] = 'required|max:255'.($request->filled('RID')?'':'|unique:fe_abilities,name');
                $model=fe_abilities::class;
            }else{
                $updates['rank']=$request->input('rank');
                $rules['name'] = 'required|max:255'.($request->filled('RID')?'':'|unique:fe_roles,name');
                $rules['rank'] = 'numeric';
                $model=fe_roles::class;
            }
            $request->validate($rules, $customMessages);
            $message = 'Privilege Created';
            if($request->filled('RID')){//updating
                $newrecord=$model::find($request->input('RID'));
                $newrecord->update($updates);
                $message = 'Privilege Updated';
            }else{//creating
                $newrecord=$model::create($updates);
            }
            if($request->input('ra_type')!=='Ability'){
                $newrecord->RoleAbilities()->sync($request->input('Abilities'));
            }
        }else{
            return response()->json(['status'=>'error','message'=>'Privilege type is required']);
        }
        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function delete(Request $request,$ID){
        if($request->input('ByType')=='Ability'){
            fe_abilities::destroy($ID);
        }else{
            fe_roles::destroy($ID);
        }
        return response()->json(['status'=>'success','message'=>'Privilege Removed.']);
    }

    public function load(Request $request,$ID){
        if($request->input('ByType')=='Ability'){
            return response()->json(array_merge(fe_abilities::find($ID)->toArray(),['type'=>$request->input('ByType')]));
        }else{
            return response()->json(array_merge(fe_roles::find($ID)->load('RoleAbilities')->makeVisible('RoleAbilities')->toArray(),['type'=>$request->input('ByType')]));
        }
    }

    public function ListAbilities(Request $request){
        $abilities=['results'=>[]];
        foreach(fe_abilities::all() as $ab){
            array_push($abilities['results'],['id'=>$ab->id,'text'=>$ab->name]);
        }
        return response()->json($abilities);
    }

    public function ListRoles(Request $request){
        $roles = ['results' => []];
        foreach (fe_roles::all() as $ab) {
            array_push($roles['results'], ['id' => $ab->id, 'text' => $ab->name]);
        }
        return response()->json($roles);
    }

    public function ListUsrAbilities(Request $request, $UID){
        return response()->json([
            'Roles'=> fe_User::find($UID)->AbilitiesByRoles(),
            'Abilities'=> fe_User::find($UID)->None_Role_Abilities()->diff(fe_User::find($UID)->RoleAbilities())->toArray()
        ]);
    }

    public function AssignUsr(Request $request, $UID){
        $message = ['status' => 'success', 'message' => 'Privilege updated.'];
        if ($request->filled('type')) {
            if ($request->input('type') === 'abilities') {
                fe_User::find($UID)->Ability()->sync($request->input('pr_list'));
            } else {
                fe_User::find($UID)->Roles()->sync($request->input('pr_list'));
            }
        }
        return response()->json($message);
    }

}
