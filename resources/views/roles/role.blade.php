@extends('layouts.main')

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Roles
                            List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
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
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">
                        @if (!empty($roles))
                            @foreach ($roles as $role)
                                <div class="col-md-4">
                                    <div class="card card-flush h-md-100">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2 class="text-capitalize">{{ $role['role_name'] }}</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-1">
                                            <div class="fw-bold text-gray-600 mb-5">Total users with this role:
                                                {{ $role['count_user_count'] }}</div>
                                            <div class="d-flex flex-column text-gray-600">
                                                @if ($role['role_permission']->count() > 0)
                                                    @foreach ($role['role_permission'] as $k => $rolePerm)
                                                        @if ($k < 4)
                                                            <div class="d-flex align-items-center py-2">
                                                                <span class="bullet bg-primary me-3"></span>
                                                                <span class="text-capitalize">
                                                                    {{ str_replace(['.', '_'], [' ', ' '], $rolePerm['rolepermission']['permission_name']) }}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if ($role['role_permission']->count() > 4)
                                                    <div class='d-flex align-items-center py-2'>
                                                        <span class='bullet bg-primary me-3'></span>
                                                        <em>and more...</em>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer flex-wrap pt-0">
                                            {{-- @if (Helper::permission('Roles.view')) --}}
                                                <a href="{{ route('user.role.view', $role->id) }}"
                                                    class="btn btn-light btn-active-primary my-1 me-1" target="_blank">View
                                                    Role</a>
                                            {{-- @endif --}}
                                            {{-- @if (Helper::permission('Roles.update')) --}}
                                                <button type="button"
                                                    class="btn btn-light btn-active-light-primary my-1 edit_role"
                                                    data-id="{{ $role['id'] }}" data-name="{{ $role['role_name'] }}"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Edit
                                                    Role</button>
                                            {{-- @endif --}}

                                            {{-- @if (Helper::permission('Roles.delete')) --}}
                                                <button type="button"
                                                    class="btn btn-light-danger btn-active-light-danger my-1 delete_role me-1"
                                                    data-id="{{ $role['id'] }}"
                                                    data-name="{{ $role['role_name'] }}">Delete
                                                    Role</button>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{-- @if (Helper::permission('Roles.create')) --}}
                            <div class="ol-md-4">
                                <div class="card h-md-100">
                                    <div class="card-body d-flex flex-center">
                                        <button type="button" class="btn btn-clear d-flex flex-column flex-center add_role"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                                            <img src="assets/media/illustrations/sketchy-1/4.png" alt=""
                                                class="mw-100 mh-150px mb-7" />
                                            <div class="fw-bold fs-3 text-gray-600 text-hover-primary">Add New Role</div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        {{-- @endif --}}
                    </div>

                    {{-- kt_modal_add_role --}}

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
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                        <tbody class="text-gray-600 fw-semibold role_permission">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center pt-15">
                                            <button type="button"
                                                class="btn btn-light me-3 close"data-bs-dismiss="modal"
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
    $(document).ready(function(e) {
        $('body').on('click', '.edit_role', function(e) {
            showloader('block')
            $('#kt_modal_update_role_form').find('input[name="role_name"]').val($(this).data('name'));
            $('#kt_modal_update_role_form').find('input[name="role_id"]').val($(this).data('id'));
            $('.role_permission').empty();
            $.get('{{ route('get.permission.role') }}/' + $(this).data('id'), function(d) {

                $.each(d.role.modules, function(i, v) {
                    var html = '<tr> <td class="text-gray-800">' + v.name +
                        '</td> <td> <div class="d-flex">';
                    $.each(v.permissions, function(ip, vp) {
                        const myArray = vp.name.split(".");
                        var checked = false;
                        if (vp.is_active == true) {
                            checked = 'checked';
                        }
                        html +=
                            '<label class="form-check form-check-sm form-check-custom form-check-solid me-5">' +
                            '<input class="form-check-input" type="checkbox" value="' +
                            vp.id + '" name="permission_id[]"   ' + checked +
                            ' />' +
                            '<span class="form-check-label text-capitalize">' +
                            myArray[1].replace("_", " ") + '</span></label>';
                        checked = false;

                    })
                    html += '</div></td></tr>';
                    $('.role_permission').append(html);
                })
                showloader('none')
            }, 'json')
        })

        $('body').on('submit', '.role_permissionForm', function(e) {
            e.preventDefault();
            showloader('block')
            var elem = $(this).serialize();
            $.post('{{ route('storePermission') }}', elem, function(d) {
                $('#kt_modal_update_role').modal('hide')
                toastr.success(d.msg);
                setTimeout(() => {
                    location.reload();
                }, 1000);
                showloader('none')
            }, 'json')
        })

        $('.add_role').click(function(e) {
            showloader('block')
            $('input[name="role_name"]').val('')
            $('.role_permission').empty()
            $.get('{{ route('get.permission.role', '0') }}', function(d) {

                $.each(d.modules, function(i, v) {
                    var html = '<tr> <td class="text-gray-800">' + v.name +
                        '</td> <td> <div class="d-flex">';
                    $.each(v.permissions, function(ip, vp) {
                        const myArray = vp.name.split(".");
                        html +=
                            '<label class="form-check form-check-sm form-check-custom form-check-solid me-5">' +
                            '<input class="form-check-input" type="checkbox" value="' +
                            vp.id + '" name="permission_id[]"  />' +
                            '<span class="form-check-label text-capitalize">' +
                            myArray[1].replace("_", " ") + '</span></label>';
                    })
                    html += '</div></td></tr>';
                    $('.role_permission').append(html);
                })
                showloader('none')
            })
        })


        $('body').on('click', '.delete_role', function() {
            let id = $(this).attr('data-id');

            Swal.fire({
                html: `Are you sure you want to delete this user`,
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

                if (data.isConfirmed == true) {
                    showloader('block')
                    $.ajax({
                        url: '{{ route('role.destory', '') }}/' + id,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(d) {
                            if (d.success == true) {
                                toastr.success(d.msg);
                                setTimeout(() => {
                                    location.reload()
                                }, 500);
                            }
                        }
                    })
                    showloader('none')

                }

            });
        });


    })
</script>
