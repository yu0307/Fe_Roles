@include('fe_roles::rolemanctr')
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
            padding: 2px;
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
        .dataTables_wrapper .dataTables_processing{
            background: none !important;
            top: auto !important;
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
    <script type="text/javascript" src="{{asset('/feiron/fe_roles/js/roleManagementControl.js')}}"></script>
    <script type="text/javascript" src="{{asset('/feiron/fe_roles/js/roleManagementWin.js')}}"></script>
</head>

<body class=" p-5" data-page="roleManagement" >
    <div id="pr_management">
        <div class="row">
            <div class="col-md-3 d-sm-none d-md-block">
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            @yield('pr_cntr_header')
                        </div>
                    </div>
                    <div class="card-body">
                        @yield('pr_cntr_content')
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-sm-none d-md-block">
            </div>
        </div>
        <div id="Role_Management_CRUD">
            <div class="modal fade" tabindex="-1" role="dialog" id="Role_CRUD">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @yield('pr_edit_ctrl')
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
        </div>
    </div>
</body>

</html>