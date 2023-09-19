@extends('layouts.main')

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Modules List</h1>
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
                    <li class="breadcrumb-item text-muted">Modules</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <input type="text" data-kt-user-table-filter="search"
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search user"
                                id="search_table" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            {{-- <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_export_users">

                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2"
                                            rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
                                        <path
                                            d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                            fill="currentColor" />
                                        <path opacity="0.3"
                                            d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>Export
                            </button> --}}
                            {{-- @if (Helper::permission('Modules.create')) --}}
                                <button type="button" class="btn btn-primary create_new_off_canvas_modal create_user"
                                    data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">

                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                                rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                                fill="currentColor" />
                                        </svg>
                                    </span>Add Module
                                </button>
                            {{-- @endif --}}
                        </div>
                        <div class="d-flex justify-content-end align-items-center d-none"
                            data-kt-user-table-toolbar="selected">
                            <div class="fw-bold me-5">
                                <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete
                                Selected</button>
                        </div>
                        <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="fw-bold">Export Users</h2>
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                            data-kt-users-modal-action="close">
                                            <span class="svg-icon svg-icon-1">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                        height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                                        fill="currentColor" />
                                                    <rect x="7.41422" y="6" width="16" height="2"
                                                        rx="1" transform="rotate(45 7.41422 6)"
                                                        fill="currentColor" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                        <form id="kt_modal_export_users_form" class="form" action="#">
                                            <div class="fv-row mb-10">
                                                <label class="fs-6 fw-semibold form-label mb-2">Select
                                                    Roles:</label>
                                                <select name="role" data-control="select2"
                                                    data-placeholder="Select a role" data-hide-search="true"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option></option>
                                                    <option value="Administrator">Administrator
                                                    </option>
                                                    <option value="Analyst">Analyst</option>
                                                    <option value="Developer">Developer</option>
                                                    <option value="Support">Support</option>
                                                    <option value="Trial">Trial</option>
                                                </select>
                                            </div>
                                            <div class="fv-row mb-10">
                                                <label class="required fs-6 fw-semibold form-label mb-2">Select
                                                    Export Format:</label>
                                                <select name="format" data-control="select2"
                                                    data-placeholder="Select a format" data-hide-search="true"
                                                    class="form-select form-select-solid fw-bold">
                                                    <option></option>
                                                    <option value="excel">Excel</option>
                                                    <option value="pdf">PDF</option>
                                                    <option value="cvs">CVS</option>
                                                    <option value="zip">ZIP</option>
                                                </select>
                                            </div>
                                            <div class="text-center">
                                                <button type="reset" class="btn btn-light me-3"
                                                    data-kt-users-modal-action="cancel">Discard</button>
                                                <button type="submit" class="btn btn-primary"
                                                    data-kt-users-modal-action="submit">
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
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="module_table">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">

                                <th>Modules</th>
                                <th>permossion</th>
                                <th>Created At</th>
                                {{-- @if (Helper::permission('Modules.update') || Helper::permission('Modules.delete')) --}}
                                    <th>Actions</th>
                                {{-- @endif --}}
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_drawer_example_basic" class="" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle=".create_new_off_canvas_modal" data-kt-drawer-close="#kt_drawer_example_basic_close"
        data-kt-drawer-width="500px">
        <div class="col-12 ">
            <div id="subdiv_kt_drawer_example_basic">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title drawertitle"></h3>
                    </div>
                    <div class="card-body py-5">
                        <form id="moduleFrom" class="moduleFrom" role="form">
                            @csrf
                            <div class="mb-10">
                                <label for="first_name" class="form-label">Module Name</label>
                                <input class="form-control removeclass" placeholder="Module Name" name="name"
                                    type="text" id="name" value="">
                                <input class="form-control removeclass" placeholder="" name="id" type="hidden"
                                    id="id" value="">
                            </div>

                            <div class="d-flex mb-10">
                                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                    <input class="form-check-input" type="checkbox" value="1" name="view_all" />
                                    <span class="form-check-label">View All</span>
                                </label>
                                <label class="form-check form-check-custom form-check-solid me-5 me-lg-20">
                                    <input class="form-check-input" type="checkbox" value="1" name="view" />
                                    <span class="form-check-label">View</span>
                                </label>
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" name="create" />
                                    <span class="form-check-label">Create</span>
                                </label>

                            </div>
                            <div class="d-flex mb-10">
                                <label class="form-check form-check-custom form-check-solid  me-5 me-lg-20">
                                    <input class="form-check-input" type="checkbox" value="1" name="update" />
                                    <span class="form-check-label">Update</span>
                                </label>
                                <label class="form-check form-check-custom form-check-solid  me-5 me-lg-20">
                                    <input class="form-check-input" type="checkbox" value="1" name="delete" />
                                    <span class="form-check-label">Delete</span>
                                </label>
                            </div>

                            <div class="error-area"></div>
                            <div class="box-footer mt20">
                                <button type="submit" class="btn btn-primary me-10" id="crud-form-submit-button">
                                    <span class="indicator-label">
                                        Submit
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>

                        </form>
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
    $(document).ready(function() {

        let table = $('#module_table').DataTable({
            responsive: true,
            pageLength: 10,
            lengthChange: true,
            ajax: {
                url: "{{ route('module.list') }}",
            },
            columns: [{
                    data: 'module'
                },
                {
                    data: 'permission'
                },

                {
                    data: 'createdAt'
                },
                @if (Helper::permission('Modules.update') || Helper::permission('Modules.delete'))
                    {
                        data: 'actions'
                    },
                @endif
            ],
        });

        $('body').on('click', '.edit_module', function() {
            showloader('block')
            let id = $(this).attr('data-id');
            $('.drawertitle').html('Edit module')
            $.get('{{ route('module.show', '') }}/' + id, {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(d) {
                $('#kt_drawer_example_basic').find('input[name="id"]').val(d.data.id)
                $('#kt_drawer_example_basic').find('input[name="name"]').val(d.data.name)
                if (d.data.permission.length > 0) {
                    $.each(d.data.permission, function(i, v) {
                        const myArray = v.permission_name.split(".");
                        if (myArray[1] == 'view_all') {
                            $('#kt_drawer_example_basic').find('input[name="view_all"]')
                                .attr('checked', true)
                        }
                        if (myArray[1] == 'view') {
                            $('#kt_drawer_example_basic').find('input[name="view"]')
                                .attr('checked', true)
                        }
                        if (myArray[1] == 'create') {
                            $('#kt_drawer_example_basic').find('input[name="create"]')
                                .attr('checked', true)
                        }
                        if (myArray[1] == 'update') {
                            $('#kt_drawer_example_basic').find('input[name="update"]')
                                .attr('checked', true)
                        }
                        if (myArray[1] == 'delete') {
                            $('#kt_drawer_example_basic').find('input[name="delete"]')
                                .attr('checked', true)
                        }
                    })
                }
                showloader('none')

            }, 'json')

        });

        $('#search_table').on('keyup', function() {
            table.search($(this).val()).draw();
        });

        $('body').on('click', '.create_user', function(e) {
            $('.drawertitle').html('Add Moduile');
            $('#kt_drawer_example_basic').find('input[type="checkbox"]').attr('checked', false);
            $('#kt_drawer_example_basic').find('input').val();
        })

        $('body').on('submit', '.moduleFrom', function(e) {
            e.preventDefault();
            showloader('block')
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('module.store', '') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (d) => {
                    if (d.success == false) {
                        $.each(d.error, function(i, v) {
                            toastr.error(v);
                        })
                    }
                    if (d.success == true) {
                        toastr.success(d.msg);
                        table.ajax.reload()
                        KTDrawer.hideAll();

                    }
                    showloader('none')
                },
                error: function(data) {

                }

            });
        })


        $('body').on('click', '.delete_record', function() {
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
                        url: '{{ route('module.destroy', '') }}/' + id,
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
                    showloader('none')

                }

            });
        });

    })
</script>
