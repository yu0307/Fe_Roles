@include('fe_roles::rolemanctr')

<div id="pr_management">
    <div class="panel">
        <div class="panel-content p-2 p-t-0">
            @yield('pr_cntr_header')
            <hr class="m-t-5 m-b-5">
            @yield('pr_cntr_content')
        </div>
    </div>
</div>

@section('Role_Management_CRUD')
    <div class="p-10 form-horizontal">
        @yield('pr_edit_ctrl')    
    </div>
@endsection