<div id="usrRoleAssignment" class="container-fluid" data_target="{{route('Fe_RoleCRUD')}}">
    <div class="row">
        <div class="col-md-6 col-sm-12" id="RA_AbilityList">
            
            <div class="card">
                <div class="card-header">
                    <h5>Here's a list of abilities currently assigned to the user</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush" style="max-height: 400px;    overflow-y: auto;">
                        <li class="list-group-item">
                            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
                            <span class="text-2x">Loading...</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="alert alert-info m-b-5 mb-2" role="alert">
                <h6 class="m-0">Assign new Role/Abilities from below.</h6>
            </div>
            <div class="pt-2 p-t-5 icheck-inline t-center text-center">
                <div class="form-check form-check-inline dis-inline-b d-inline-block m-r-10">
                    <input class="form-check-input" data-radio="iradio_flat-blue" type="radio" name="usrAssignType" id="usrAssign_ByRole" value="roles">
                    <label class="form-check-label" for="usrAssign_ByRole">Roles</label>
                </div>
                <div class="form-check form-check-inline dis-inline-b d-inline-block m-r-10">
                    <input class="form-check-input" data-radio="iradio_flat-blue" type="radio" name="usrAssignType" id="usrAssign_ByAbility" value="abilities" checked>
                    <label class="form-check-label" for="usrAssign_ByAbility">Abilities</label>
                </div>
            </div>
            <select name="Sel_usrAssign" id="Sel_usrAssign" style="width:100%">

            </select>
            <hr class="m-2 p-0"/>
            <button class="btn btn-primary pull-right float-md-right" id="assignUsrPri">Update Privilege</button>
        </div>
    </div>
</div>