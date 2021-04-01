<div id="usrRoleAssignment" class="container-fluid d-none" data_target="{{route('Fe_RoleCRUD')}}">
    <div class="row">
        <div class="col-md-6 col-sm-12 h-100" id="RA_AbilityList">
            <h6 class="alert alert-dark p-2">Abilities currently assigned to the user</h6>
            <div class="card h-100">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center flex-column position-absolute w-100 start-0 pt-4 loading">
                        <i class="fas fa-circle-notch fa-spin fa-3x fa-fw"></i>
                        <h5>Loading...</h5>
                    </div>
                    <ul class="list-group list-group-flush h-100 d-none usr-prev-lists" style="max-height: 180px;overflow-y: auto;">
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 p-15 bg-light-dark">
            <div class="alert alert-dark p-2" role="alert">
                <h6 class="m-0">Modify Role/Abilities from below.</h6>
            </div>
            <div class="pt-2 p-t-5 icheck-inline t-center text-center">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ListTypes" id="usrAssign_ByRole" value="roles" checked>
                    <label class="form-check-label" for="usrAssign_ByRole">By Roles</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ListTypes" id="usrAssign_ByAbility" value="abilities" >
                    <label class="form-check-label" for="usrAssign_ByAbility">By Abilities</label>
                </div>
            </div>
            <select name="Sel_usrAssign" id="Sel_usrAssign" multiple style="width:100%" class="prev-list">

            </select>
            <hr class="m-2 p-0"/>
            <button class="btn btn-primary float-end" id="assignUsrPri">Update Privilege</button>
        </div>
    </div>
</div>