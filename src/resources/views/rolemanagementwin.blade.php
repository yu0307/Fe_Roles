<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','User Role Manager')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="" name="Lucas.F.Lu" />
    <style>
        body {
            height: 100%;
            background: #F5F5F5;
            color: #5B5B5B;
            font-family: 'Lato', 'Open Sans', Helvetica, sans-serif !important;
            line-height: 1.42857143;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            font-size: 12px;
        }
        #dt_table td{
            font-size:14px;
        }
        #dt_table th{
            font-size:14px;
        }
        #dt_table td .btn{
            width:100%;
        }
        .dataTables_paginate  a{
            margin:0px 5px;
            cursor:pointer;
        }
        .roleCtrl{
            display:none;
        }
    </style>
    <link rel="stylesheet" href="{{asset('/feiron/fe_roles/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/feiron/fe_roles/bootstrap4/css/bootstrap.min.css')}}">
    <link href="{{asset('/feiron/fe_roles/select2/css/select2.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('/feiron/fe_roles/datatables/dataTables.min.css')}}">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    
    <script type="text/javascript" src="{{asset('/feiron/fe_roles/bootstrap4/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/feiron/fe_roles/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/feiron/fe_roles/select2/js/select2.full.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/feiron/fe_roles/js/roleManagementWin.js')}}"></script>
</head>

<body class=" p-5" data-page="roleManagement">
    <div class="row">
        <div class="col-md-3 d-sm-none d-md-block">
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <h4>Privilege Management</h4>
                        </div>
                        <div class="col-md-8 col-sm-12">
                            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#roleCRUD">Add New</button>
                            <div class="pull-right pt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ListType" id="ByRole" value="Role" >
                                    <label class="form-check-label" for="ByRole">By Roles</label>
                                    </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ListType" id="ByAbility" value="Ability" checked>
                                    <label class="form-check-label" for="ByAbility">By Abilities</label>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="dt_list">
                        <table id="dt_table" width="100%" data_target="{{route('Fe_RoleCRUD')}}" class="table table-striped table-hover  table-sm">
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
                </div>
            </div>
        </div>
        <div class="col-md-3 d-sm-none d-md-block">
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="roleCRUD">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" name="RID" id="RID" value="" type="hidden">
                    <div class="row">
                        <div class="col-sm-12 col-md 6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-align-justify"></i></span>
                                </div>
                                <input  name="name" id="ra_name" type="text" class="form-control" placeholder="name" value="">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <select name="ra_type" id="ra_type" class="pull-right form-control" style="width:50%">
                                <option value="Ability">Ability</option>
                                <option value="Role">Role</option>
                            </select>
                            <label for="ra_type" class="pull-right pr-2 pt-2">Privilege Type</label>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-check form-check-inline t-center text-center">
                                <input class="form-check-input form-control" style="width:auto"  type="radio" name="disabled" id="not_disabled" value="false" checked>
                                <label class="form-check-label" for="ByAbility">Activated</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input form-control" style="width:auto" type="radio" name="disabled" id="is_disabled" value="true" >
                                <label class="form-check-label" for="ByRole">Disabled</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 roleCtrl">
                            <input type="number" style="width:60%" value="0" id="rank" name="rank" class="form-control pull-right">
                            <label class="form-check-label  pull-right pt-2 mr-2" for="rank">Rank/Order</label>
                        </div>
                        <div class="col-md-12">
                            <h5>Description:</h5>
                            <textarea class="form-control" name="description" id="description" style="width:100%" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 roleCtrl">
                        <hr>
                        <label for="role_abilities " style="width:100%">
                            Role Associated Abilities
                        <select class="form-control" id="role_abilities" style="width:100%"></select>
                        </label>
                    </div>
                    <div class="resp_msg" id="resp_msg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="ra_SaveChange">Save Change</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>