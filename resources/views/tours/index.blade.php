@extends('layouts.main')

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    Tours List</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Tour Details</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Tours</li>
            </div>
        </div>
    </div>


    <div id="kt_app_content" class="app-content flex-column-fluid">
        {{-- <div id="kt_app_content_container" class="app-container container-xxl"> --}}
        <div id="kt_app_content_container" class="app-container">
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
                                class="form-control form-control-solid w-250px ps-14" placeholder="Search Tours"
                                id="search_table" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">

                            {{-- @if (Helper::permission('Users.create')) --}}
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
                                </span>Add Tours
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
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2"
                                                        rx="1" transform="rotate(-45 6 17.3137)"
                                                        fill="currentColor" />
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
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
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="tours_table">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th>Title</th>
                                <th>Price</th>
                                <th>Descriptions</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Age</th>
                                <th>Capacity</th>
                                <th>Reviews</th>
                                <th>What's Include</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_drawer_example_basic" class="bg-white" data-kt-drawer="true" data-kt-drawer-activate="true"
        data-kt-drawer-toggle=".create_new_off_canvas_modal" data-kt-drawer-close="#kt_drawer_example_basic_close"
        data-kt-drawer-width="500px">
        <div class="col-12">
            <div id="subdiv_kt_drawer_example_basic">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title drawertitle"></h3>
                    </div>
                    <div class="card-body py-5">

                        <form class="ToursForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-10">
                                        <label for="title" class="form-label">Title</label>
                                        <input class="form-control removeclass" placeholder="Title" name="title"
                                            type="text" id="title" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="user_id" class="form-label">Users</label>
                                        <select class="form-select select2-example"
                                            aria-label="Floating label select example" name="user_id">
                                            <option selected disabled>Users</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->user_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="loc" class="form-label">Location</label>
                                        <input class="form-control removeclass" placeholder="Location" name="loc"
                                            type="text" id="loc" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="age" class="form-label">Age</label>
                                        <input class="form-control removeclass" placeholder="Age" name="age"
                                            type="number" id="age" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="capacity" class="form-label">Capacity</label>
                                        <input class="form-control removeclass" placeholder="Capacity" name="capacity"
                                            type="text" id="capacity" value="">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="price" class="form-label">Price</label>
                                        <input class="form-control removeclass" placeholder="Price" name="price"
                                            type="text" id="price" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="price_type" class="form-label">Price Type</label>
                                        <input class="form-control removeclass" placeholder="Price Type"
                                            name="price_type" type="text" id="price_type" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="reviews" class="form-label">Reviews</label>
                                        <input class="form-control removeclass" placeholder="Reviews" name="reviews"
                                            type="text" id="reviews" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10 ">
                                        <label for="recommended" class="form-label">Recommended</label>
                                        <select name="recommended" id="recommended" class="form-control">
                                            <option value="0" selected>Not Recommended</option>
                                            <option value="1">Recommended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input class="form-control removeclass" placeholder="Start Date"
                                            name="start_date" type="text" id="start_date" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input class="form-control removeclass" placeholder="End Date" name="end_date"
                                            type="text" id="end_date" value="">
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="start_time" class="form-label clockpicker">Start Time</label>
                                        <input class="form-control removeclass" placeholder="Start Time"
                                            name="start_time" type="text" id="start_time" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="end_time" class="form-label">End Time</label>
                                        <input class="form-control removeclass" placeholder="End Time" name="end_time"
                                            type="text" id="end_time" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-10">
                                        <label for="cancel_days" class="form-label">Descriptions</label>
                                        <textarea class="form-control removeclass" name="desc" id="desc" cols="30" rows="10">Descriptions</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-10">
                                        <label for="whats_include" class="form-label">Whats Include</label>
                                        <textarea class="form-control removeclass" name="whats_include" id="whats_include" cols="30" rows="10">Whats Include</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                    <div class="mb-10">
                                        <label for="description" class="form-label">Clients</label>
                                        <select class="form-select select2-example"
                                            aria-label="Floating label select example" name="client_id">
                                            <option selected disabled>Clients</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $clients[0]->id }}">{{ $clients[0]->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

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
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('path/to/clockpicker.css') }}">
    <script src="{{ asset('path/to/clockpicker.js') }}"></script>
@endsection

<script>
    $(document).ready(function() {
        $("#start_date").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format("YYYY"), 12)
        }, function(start, end, label) {
            var years = moment().diff(start, "years");
            // alert("You are " + years + " years old!");
        });

        $("#end_date").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format("YYYY"), 12)
        }, function(start, end, label) {
            var years = moment().diff(start, "years");
            // alert("You are " + years + " years old!");
        });
        $('#timePicker').clockpicker({
            autoclose: true
        });

        $('.clockpicker').clockpicker();

        let table = $('#tours_table').DataTable({
            responsive: true,
            // processing: true,
            // serverSide: true,
            pageLength: 10,
            lengthChange: true,
            ajax: {
                url: "{{ route('tours.list') }}",
            },
            columns: [{
                    data: 'title'
                },
                {
                    data: 'price'
                },
                {
                    data: 'desc'
                },
                {
                    data: 'loc'
                },
                {
                    data: 'date'
                },
                {
                    data: 'time'
                },
                {
                    data: 'age'
                },
                {
                    data: 'capacity'
                },
                {
                    data: 'reviews'
                },
                {
                    data: 'whats_include'
                },
                {
                    data: 'actions'
                }
            ],
        });

        $('body').on('click', '.edit_blog', function() {
            $('.passwordDiv').hide();
            let id = $(this).attr('data-id');
            $('.drawertitle').html('Edit Tours')
            showloader('block')
            $.get('{{ route('tours.show', '') }}/' + id, {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(d) {
                $('#kt_drawer_example_basic').find('input[name="id"]').val(d.data.id)
                $('#kt_drawer_example_basic').find('select[name="user_id"]').val(d.data.user_id)
                $('#kt_drawer_example_basic').find('select[name="category_id"]').val(d.data
                    .category_id)
                $('#kt_drawer_example_basic').find('select[name="rental_addons_id"]').val(d.data
                    .rental_addons_id)
                $('#kt_drawer_example_basic').find('input[name="title"]').val(d.data.title)
                $('#kt_drawer_example_basic').find('input[name="price"]').val(d.data.price)
                $('#kt_drawer_example_basic').find('input[name="price_type"]').val(d.data
                    .price_type)
                $('#kt_drawer_example_basic').find('input[name="loc"]').val(d.data.loc)
                $('#kt_drawer_example_basic').find('input[name="desc"]').val(d.data.desc)
                $('#kt_drawer_example_basic').find('input[name="capacity"]').val(d.data
                    .capacity)
                $('#kt_drawer_example_basic').find('input[name="skills"]').val(d.data.skills)
                $('#kt_drawer_example_basic').find('input[name="cancel_days"]').val(d.data
                    .cancel_days)
                $('#kt_drawer_example_basic').find('input[name="cancel_percent"]').val(d.data
                    .cancel_percent)
                $('#kt_drawer_example_basic').find('input[name="skills"]').val(d.data.skills)
                var image = "{{ asset('assets/media/svg/files/blank-image-dark.svg') }}";
                if (d.data.icon != 'http://127.0.0.1:8000/storage') {
                    image = d.data.icon
                }
                $('#kt_drawer_example_basic').find('.dispalyImage').css('background-image',
                    'url(' + image + ')')
                showloader('none')
            }, 'json')

        });

        $('#search_table').on('keyup', function() {
            table.search($(this).val()).draw();
        });


        $('body').on('submit', '.ToursForm', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            showloader('block')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('tours.store', '') }}",
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
                error: function(data) {}
            });
        });

        $('body').on('click', '.delete_record', function() {
            let id = $(this).attr('data-id');

            Swal.fire({
                html: `Are you sure you want to delete this Tours`,
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
                        url: '{{ route('tours.destroy', '') }}/' + id,
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
