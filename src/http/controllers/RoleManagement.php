<?php

namespace feiron\fe_roles\http\controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use feiron\fe_roles\models\fe_roles;
use feiron\fe_roles\models\fe_abilities;

class RoleManagement extends Controller
{
    public function show(){
        return view('fe_roles::rolemanagementwin');
    }

    public function list(Request $request){
        $datainfo = [];
        if($request->input('ByType')=='Role'){
            $QueryBuilder=fe_roles::query();
        }else{
            $QueryBuilder=fe_abilities::query();
        }
        $columnIndex = $request->input('order')[0]['column']; // Column index
        $columnName = $request->input('columns')[$columnIndex]['data']; // Column name
        $columnSortOrder = $request->input('order')[0]['dir']; // asc or desc

        $datainfo['recordsTotal'] = $QueryBuilder->count();
        $datainfo['draw'] = $request->input('draw');
        $datainfo['page'] = $request->input('page');
        $datainfo['rowperpage'] = $request->input('length');
        // Building column specific search--------------------------
        $QueryBuilder->where(
            function ($query) use ($request) {
                foreach ($request->input('columns') as $column) {
                    if (isset($column['search']['value'])) {
                        $query->where($column['data'],'like', ('%'.$column['search']['value'].'%'));
                    }
                }
            }
        );
        

        $datainfo['recordsFiltered'] = $QueryBuilder->count();
        $datainfo['data'] = $QueryBuilder->orderBy($columnName, $columnSortOrder)->paginate($datainfo['rowperpage'])->flatten()->toArray();

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
            return response()->json(array_merge(fe_roles::find($ID)->load('RoleAbilities')->toArray(),['type'=>$request->input('ByType')]));
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

}
