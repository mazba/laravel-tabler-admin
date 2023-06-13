@extends('layouts.admin')
@section('content')
        <div class="container-fuild">
            <!-- Page title -->
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            {{$module_name}}
                        </div>
                        <h2 class="page-title">
                            {{$task_name}}
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="#" class="btn btn-cyan w-100 d-none d-sm-inline-block create-button">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                                Create User
                            </a>
                            <a href="#" class="btn btn-cyan w-100 d-sm-none btn-icon create-button" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-fuild">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{$task_name}} List</h3>
                            </div>
                            <div class="table-responsive">
                                <table id="index-table" class="table card-table table-vcenter text-nowrap datatable table-striped" style="width: 100%!important;">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>User Type</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal modal-blur fade" id="modal-index" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
    <script src="{{asset('js/jquery.tagsinput-revisited.js')}}"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .ui-front{
            z-index: 99999999;
        }
    </style>
    <script>
        $(function () {
            $('#index-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX:        true,
                scrollCollapse: true,
                ajax: "{{ route("$current_uri.index") }}",
                columns: [
                    {data: 'name', name: 'Name',width:'20%'},
                    {data: 'email', name: 'Email',width:'20%'},
                    {data: 'user_type', name: 'User Type',orderable:false,searchable:false,width:'10%'},
                    {data: 'status', name: 'Status',orderable:false,searchable:false,width:'10%'},
                    {data: 'created_at', name: 'Created At',orderable:false,searchable:false,width:'20%',className:'text-muted'},
                    {data: 'action', name: 'action', orderable: false, searchable: false,width:'10%',className:'text-center'},
                ]
            });
        });
        $( document ).ready(function() {
            $('.create-button').click(function(){
                var loading_div = '<div class="d-flex justify-content-center">'+
                                    '<div class="spinner-border text-info" role="status">'+
                                            '<span class="visually-hidden">Loading...</span>'+
                                    '</div>'+
                                   '</div>';
                $('#modal-index').find('.modal-body').html(loading_div);
                $('#modal-index').find('.modal-title').html('{{__('Add new').' '.strtolower($module_name)}}');
                var modal = new bootstrap.Modal(document.getElementById('modal-index'));
                modal.show();
                $.ajax({
                    url: '{{route($current_uri.'.create')}}',
                    type: 'GET',
                    success: function(response){
                        $('.modal-body').html(response);
                    }
                });
            });
            $(document).on('click','#submit-button',function(){
                enableSubmitLoading();
                $.ajax({
                    url: '{{route($current_uri.'.store')}}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-Token': '{{csrf_token()}}'
                    },
                    'data':{
                        'name':$('#modal-index').find('[name="name"]').val(),
                        'email':$('#modal-index').find('[name="email"]').val(),
                        'password':$('#modal-index').find('[name="password"]').val(),
                        'password_confirmation':$('#modal-index').find('[name="password_confirmation"]').val(),
                        'price':$('#modal-index').find('[name="price"]').val(),
                        'user_type':$('#modal-index').find('[name="user_type"]').val(),
                        'currency':$('#modal-index').find('[name="currency"]').val(),
                        'website_ids':$('#modal-index').find('[name="website_ids"]').val(),
                    },
                    success: function(response){
                        $('.table').DataTable().ajax.reload();
                        $('#cancel-button').trigger('click');
                        $('#success-toast').find('.toast-body').html(response.message);
                        $("#success-toast").toast("show");
                    },
                    error: function (response){
                        $('#error-toast').find('.toast-body').html("");
                        try {
                            if(response.responseJSON['errors'] != undefined){
                                $.each(response.responseJSON['errors'],function(i,v){
                                    if(v[0]!=undefined)
                                        $('#error-toast').find('.toast-body').append("* "+v[0]+"</br>");
                                    else
                                        throw 'error';
                                });
                            }
                            else
                                throw 'error';
                        } catch (error) {
                            $('#error-toast').find('.toast-body').append("Invalid Request");
                        }
                        $("#error-toast").toast("show");
                        revertSubmitLoading();
                    }
                });
            });
            $(document).on('click','.edit-button',function(){
                var loading_div = '<div class="d-flex justify-content-center">'+
                    '<div class="spinner-border text-info" role="status">'+
                    '<span class="visually-hidden">Loading...</span>'+
                    '</div>'+
                    '</div>';
                var id = $(this).attr('data-id');
                $('#modal-index').find('.modal-body').html(loading_div);
                $('#modal-index').find('.modal-title').html('{{__('Update').' '.strtolower($module_name)}}');
                var modal = new bootstrap.Modal(document.getElementById('modal-index'));
                modal.show();
                $.ajax({
                    url: '{{route($current_uri.'.index')}}/'+id+'/edit',
                    type: 'GET',
                    success: function(response){
                        $('.modal-body').html(response);
                    }
                });
            });
            $(document).on('click','#update-button',function(){
                enableSubmitLoading();
                $.ajax({
                    url: '{{route($current_uri.'.index')}}/'+$('#edit-id').val(),
                    type: 'PUT',
                    headers: {
                        'X-CSRF-Token': '{{csrf_token()}}'
                    },
                    'data':{
                        'name':$('#modal-index').find('[name="name"]').val(),
                        'email':$('#modal-index').find('[name="email"]').val(),
                        'price':$('#modal-index').find('[name="price"]').val(),
                        'user_type':$('#modal-index').find('[name="user_type"]').val(),
                        'website_ids':$('#modal-index').find('[name="website_ids"]').val(),
                        'currency':$('#modal-index').find('[name="currency"]').val(),
                        'password':$('#modal-index').find('[name="password"]').val(),
                        'status':$('#modal-index').find('[name="status"]').is(':checked')?1:0,
                    },
                    success: function(response){
                        $('.table').DataTable().ajax.reload();
                        $('#cancel-button').trigger('click');
                        $('#success-toast').find('.toast-body').html(response.message);
                        $("#success-toast").toast("show");
                    },
                    error: function (response){
                        $('#error-toast').find('.toast-body').html("");
                        try {
                            if(response.responseJSON['errors'] != undefined){
                                $.each(response.responseJSON['errors'],function(i,v){
                                    if(v[0]!=undefined)
                                        $('#error-toast').find('.toast-body').append("* "+v[0]+"</br>");
                                    else
                                        throw 'error';
                                });
                            }
                            else
                                throw 'error';
                        } catch (error) {
                            $('#error-toast').find('.toast-body').append("Invalid Request");
                        }
                        $("#error-toast").toast("show");
                        revertSubmitLoading();
                    }
                });
            });
        });
        function enableSubmitLoading(){
            var loading_button = ' <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Submitting...';
            $('#submit-button').attr('disabled','disabled');
            $('#submit-button').html(loading_button);
        }
        function revertSubmitLoading(){
            $('#submit-button').removeAttr('disabled');
            $('#submit-button').html('Submit');
        }
    </script>
@endsection
