@extends('layouts.main')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">View Role Details</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('dashboard')}}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">User Management</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Roles</li>
                    </ul>
                </div>
            </div>
        </div>
     
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="d-flex flex-column flex-lg-row">
                    <div class="flex-column flex-lg-row-auto w-100 w-lg-200px w-xl-300px mb-10">
                        <div class="card card-flush">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2 class="mb-0 text-capitalize">{{$role['role']['name']}}</h2>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="d-flex flex-column text-gray-600">
                                  
                                    @foreach($role['role']['modules'] as $module)
                                    @foreach($module['permissions'] as $perm)
                                    @if($perm['is_active'] == true)
                                    <div class="d-flex align-items-center py-2 text-capitalize">
                                    <span class="bullet bg-primary me-3 text-capitalize"></span>{{str_replace(['.','_'],[' ',' '], $perm['name']) }}</div>
                                              @endif                         
                                    @endforeach
                                    @endforeach
                                   
                                </div>
                            </div>
                            <div class="card-footer pt-0">
                                <button type="button" class="btn btn-light btn-active-primary edit_role"  data-name="{{ $role['role']['name'] }}"  data-id="{{$role_id }}" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Edit Role</button>
                            </div>
                        </div>

                       
                    </div>
                    <div class="flex-lg-row-fluid ms-lg-10">
                        <div class="card card-flush mb-6 mb-xl-9">
                            <div class="card-header pt-5">
                                <div class="card-title">
                                    <h2 class="d-flex align-items-center">Users Assigned
                                    <span class="text-gray-600 fs-6 ms-1">({{$count->user_count}})</span></h2>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex align-items-center position-relative my-1" data-kt-view-roles-table-toolbar="base">
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <input type="text"  id="search_table" data-kt-roles-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Users" />
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-view-roles-table-toolbar="selected">
                                        <div class="fw-bold me-5">
                                        <span class="me-2" data-kt-view-roles-table-select="selected_count"></span>Selected</div>
                                        <button type="button" class="btn btn-danger" data-kt-view-roles-table-select="delete_selected">Delete Selected</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_roles_view_table">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                           
                                            <th class="min-w-50px">User</th>
                                            <th class="min-w-150px">Status</th>
                                            <th class="min-w-125px">Created At</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                  
                                    
                                </table>
                             
                            </div>
                          
                        </div>
                       
                    </div>

                    <div class="modal fade" id="kt_modal_update_role" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-750px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="fw-bold">Update Role</h2>
                                    <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                        data-kt-roles-modal-action="close" data-bs-dismiss="modal">
                                        <span class="svg-icon svg-icon-1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                    height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                                    fill="currentColor" />
                                                <rect x="7.41422" y="6" width="16" height="2"
                                                    rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <div class="modal-body scroll-y mx-5 my-7">
                                    <form id="kt_modal_update_role_form" class="form role_permissionForm" action="#">
                                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_update_role_scroll"
                                            data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_update_role_header"
                                            data-kt-scroll-wrappers="#kt_modal_update_role_scroll"
                                            data-kt-scroll-offset="300px">
                                            <div class="fv-row mb-10">
                                                <label class="fs-5 fw-bold form-label mb-2">
                                                    <span class="required">Role name</span>
                                                </label>
                                                <input class="form-control form-control-solid"
                                                    placeholder="Enter a role name" name="role_name" />
                                                <input type="hidden" name="role_id">
                                            </div>
                                            <div class="fv-row">
                                                <label class="fs-5 fw-bold form-label mb-2">Role Permissions</label>
                                                <div class="table-responsive">
                                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                        <tbody class="text-gray-600 fw-semibold role_permission">
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center pt-15">
                                            <button type="button" class="btn btn-light me-3 close"data-bs-dismiss="modal"
                                                data-kt-roles-modal-action="cancel">Discard</button>
                                            <button type="submit" class="btn btn-primary"
                                                data-kt-roles-modal-action="submit">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    @section('page_script')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/users/list/table.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/user-management/users/list/export-users.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/custom/apps/user-management/users/list/add.js') }}"></script> --}}
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
@endsection

<script>
    $(document).ready(function(e){
        let table = $('#kt_roles_view_table').DataTable({
            responsive: true,
            // processing: true,
            // serverSide: true,
            pageLength: 10,
            lengthChange: true,
            ajax: {
                url: "{{ route('user.role.list') }}",
                data: function(d) {
                            d.role_id ='{{$role_id}}'
                        }
            },
            columns: [{
                    data: 'user'
                },
                {
                    data: 'status'
                },
               
                {
                    data: 'createdAt'
                },
                {
                    data: 'actions'
                },
            ],
        });
        $('#search_table').on('keyup', function() {
            table.search($(this).val()).draw();
        });
         
        $('body').on('click', '.delete_record', function() {
                let id = $(this).attr('data-id');
                showloader('block')
                Swal.fire({
                    html: `Are you sure you want to Remove this user`,
                    icon: "info",
                    buttonsStyling: false,
                    showCancelButton: true,
                    confirmButtonText: "Ok, got it!",
                    cancelButtonText: 'Nope, cancel it',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: 'btn btn-danger'
                    }
                }).then(function(data) {
                    if(data.isConfirmed==true){
                        $.ajax({
                            url: '{{ route('user.role.remove','') }}/' + id,
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(d) {
                                if (d.success == true) {
                                    toastr.success(d.msg);
                                    table.ajax.reload()
                                }
                            }
                        })
                       
                    }
                    showloader('none')
                });
            });

            $('body').on('click', '.edit_role', function(e) {
                showloader('block')
            $('#kt_modal_update_role_form').find('input[name="role_name"]').val($(this).data('name'));
            $('#kt_modal_update_role_form').find('input[name="role_id"]').val($(this).data('id'));
            $('.role_permission').empty();
            $.get('{{ route('get.permission.role') }}/' + $(this).data('id'), function(d) {
                               
                $.each(d.role.modules,function(i,v){
                    var html = '<tr> <td class="text-gray-800">'+v.name+'</td> <td> <div class="d-flex">';                     
                        $.each(v.permissions,function(ip,vp){
                            const myArray = vp.name.split(".");                        
                            var checked = false;
                            if(vp.is_active == true){
                                checked = 'checked';
                            }
                            html +=  '<label class="form-check form-check-sm form-check-custom form-check-solid me-5">'+
                                    '<input class="form-check-input" type="checkbox" value="'+vp.id+'" name="permission_id[]"   '+checked+' />'+
                                    '<span class="form-check-label text-capitalize">'+ myArray[1].replace("_", " ")+'</span></label>';
                            checked = false;
                         
                         })
                         html += '</div></td></tr>';
                        $('.role_permission').append(html);
                })  
                showloader('none')          
            }, 'json')
        });

        $('body').on('submit','.role_permissionForm',function(e){
            e.preventDefault();
            showloader('block')
            var elem = $(this).serialize();
            $.post('{{route("storePermission")}}',elem,function(d){
                $('#kt_modal_update_role').modal('hide')
                toastr.success(d.msg);
                setTimeout(() => {
                    location.reload();
                }, 1000);
                showloader('none')
            },'json')
        })
    })
</script>