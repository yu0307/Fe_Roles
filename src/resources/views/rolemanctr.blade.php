@section('pr_cntr_header')
    <div class="col-md-4 col-sm-12">
        <h4>Privilege Management</h4>
    </div>
    <div class="col-md-8 col-sm-12">
        <button class="btn btn-primary pull-right ra_addNew" data-toggle="modal" data-target="#Role_CRUD">Add New</button>
        <div class="pull-right pt-2 p-t-5 icheck-inline">
            <div class="form-check form-check-inline dis-inline-b d-inline-block m-r-10">
                <input class="form-check-input" data-radio="iradio_flat-blue" type="radio" name="ListType" id="ByRole" value="Role">
                <label class="form-check-label" for="ByRole">By Roles</label>
            </div>
            <div class="form-check form-check-inline dis-inline-b d-inline-block m-r-10">
                <input class="form-check-input" data-radio="iradio_flat-blue" type="radio" name="ListType" id="ByAbility" value="Ability" checked>
                <label class="form-check-label" for="ByAbility">By Abilities</label>
            </div>
        </div>
    
    </div>
@endsection

@section('pr_cntr_content')
    <div id="dt_list">
        <table id="pr_dt_table" width="100%" data_target="{{route('Fe_RoleCRUD')}}" class="table table-striped table-hover  table-sm dt_table">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Disabled</th>
                    <th>Rank</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

@section('pr_edit_ctrl')
    <input class="form-control" name="RID" id="RID" value="" type="hidden">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="input-group mb-3 form-group ">
                <label for="ra_name" class="col-sm-2 control-label mt-2">Name</label>
                <input name="name" id="ra_name" type="text" class="col-sm-10 form-control" placeholder="name" value="" style="width:80%">
            </div>
        </div>
    
        <div class="col-md-6 col-sm-12">
            <label for="ra_type" class="dis-inline-b d-inline-block pr-2 pt-2">Privilege Type</label>
            <select name="ra_type" id="ra_type" class="dis-inline-b d-inline-block form-control ra_type" style="width:50%">
                <option value="Ability">Ability</option>
                <option value="Role">Role</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 m-t-10">
            <div class="form-check dis-inline-b form-check-inline  t-center text-center">
                <input class="form-check-input form-control" data-radio="iradio_flat-blue" style="width:auto" type="radio" name="disabled" id="not_disabled" value="false" checked>
                <label class="form-check-label" for="ByAbility">Activated</label>
            </div>
            <div class="form-check dis-inline-b form-check-inline ">
                <input class="form-check-input form-control" data-radio="iradio_flat-blue" style="width:auto" type="radio" name="disabled" id="is_disabled" value="true">
                <label class="form-check-label" for="ByRole">Disabled</label>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 roleCtrl">
            <label class="form-check-label  dis-inline-b d-inline-block pt-2 mr-2 p-t-10 m-r-10" for="rank">Rank/Order</label>
            <input type="number" style="width:60%" value="0" id="rank" name="rank" class="form-control dis-inline-b d-inline-block">
        </div>
    </div>
    <div class="row m-0">
        <div class="col-md-12 m-0 p-0">
            <h5>Description:</h5>
            <textarea class="form-control" name="description" id="description" style="width:100%" rows="4"></textarea>
        </div>
    </div>
    <div class="col-sm-12 roleCtrl">
        <hr>
        <label for="role_abilities " style="width:100%">
            Role Associated Abilities
            <select class="form-control role_abilities" id="role_abilities" style="width:100%"></select>
        </label>
    </div>
@endsection