@extends('layouts.main')

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">View
                            User Details</h1>
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
                            <li class="breadcrumb-item text-muted">Users</li>
                        </ul>
                    </div>

                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="d-flex flex-column flex-lg-row">
                        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                            <div class="card mb-5 mb-xl-8">
                                <div class="card-body">
                                    <div class="d-flex flex-center flex-column py-5">
                                        <div class="symbol symbol-100px symbol-circle mb-7">
                                            <img src="{!! $user->display_picture
                                                ? asset('storage/' . $user->display_picture)
                                                : asset('assets/media/svg/files/blank-image-dark.svg') !!}" alt="image" />
                                        </div>
                                        <a href="#"
                                            class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3 text-capitalize">{{ $user->first_name . ' ' . $user->last_name }}</a>

                                        <div class="mb-9">
                                            <div class="badge badge-lg badge-light-primary d-inline text-capitalize">
                                                {{ $user->user_type }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-stack fs-4 py-3">
                                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                            href="#kt_user_view_details" role="button" aria-expanded="false"
                                            aria-controls="kt_user_view_details">Details
                                            <span class="ms-2 rotate-180">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <div id="kt_user_view_details" class="collapse show">
                                        <div class="pb-5 fs-6">
                                            <div class="fw-bold mt-5">Username</div>
                                            <div class="text-gray-600 text-capitalize">{{ $user->user_name }}</div>
                                            <div class="fw-bold mt-5">Email</div>
                                            <div class="text-gray-600 text-capitalize">{{ $user->email }}</div>
                                            <div class="fw-bold mt-5">Gender</div>
                                            <div class="text-gray-600 text-capitalize">{{ $user->gender }}</div>
                                            {{-- <div class="fw-bold mt-5">Address</div>
                                            <div class="text-gray-600 text-capitalize">{{ $user->address }}</div> --}}
                                            <div class="fw-bold mt-5">Contact Number</div>
                                            <div class="text-gray-600 text-capitalize">{{ $user->phone }}</div>
                                            {{-- <div class="fw-bold mt-5">Country</div>
                                            <div class="text-gray-600">
                                                <a href="#"
                                                    class="text-gray-600 text-hover-primary">{{ $user->location_country }}</a>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="flex-lg-row-fluid ms-lg-15">
                            <ul
                                class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                        href="#kt_user_view_overview_tab">Update Detail</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                                    <div class="card card-flush mb-6 mb-xl-9">
                                        <div class="card-body p-9 pt-4">

                                            <form method="POST" id="profile_form" class="profile_form" role="form">
                                                @csrf
                                                @if ($user)
                                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                                @endif
                                                <div class="fv-row mb-7">
                                                    <label class="d-block fw-semibold fs-6 mb-5">Display Picture</label>
                                                    <style>
                                                        .image-input-placeholder {
                                                            background-image: url('assets/media/svg/files/blank-image.svg');
                                                        }

                                                        [data-theme="dark"] .image-input-placeholder {
                                                            background-image: url('assets/media/svg/files/blank-image-dark.svg');
                                                        }
                                                    </style>
                                                    <div class="image-input image-input-outline image-input-placeholder"
                                                        data-kt-image-input="true">
                                                        <div class="image-input-wrapper w-125px h-125px"
                                                            @if ($user->display_picture) style="background-image: url('{{ asset('storage/' . $user->display_picture) }}');"@else style="background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}')" @endif>
                                                        </div>
                                                        <label
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                            title="Change avatar">
                                                            <i class="bi bi-pencil-fill fs-7"></i>
                                                            <input type="file" id="imgInp" name="display_picture"
                                                                accept=".png, .jpg, .jpeg" />
                                                            <input type="hidden" name="display_picture"
                                                                id="display_picture" />
                                                        </label>
                                                        <span
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                            title="Cancel avatar">
                                                            <i class="bi bi-x fs-2"></i>
                                                        </span>
                                                        <span
                                                            class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow remove-avatar-button"
                                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                            title="Remove avatar">
                                                            <i class="bi bi-x fs-2"></i>
                                                        </span>
                                                    </div>
                                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                </div>

                                                <div class="mb-10">
                                                    <label for="first_name" class="form-label">User Name</label>
                                                    <input class="form-control" placeholder="First Name" name="user_name"
                                                        type="text" id="user_name" value="{{ @$user->user_name }}">
                                                </div>

                                                <div class="mb-10">
                                                    <label for="first_name" class="form-label">First Name</label>
                                                    <input class="form-control" placeholder="First Name"
                                                        name="first_name" type="text" id="first_name"
                                                        value="{{ @$user->first_name }}">
                                                </div>

                                                <div class="mb-10">
                                                    <label for="last_name" class="form-label">Last Name</label>
                                                    <input class="form-control" placeholder="Last Name" name="last_name"
                                                        type="text" id="last_name" value="{{ $user->last_name }}">
                                                </div>

                                                <div class="mb-10">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input class="form-control" placeholder="Email" name="email"
                                                        type="text" id="email" value="{{ $user->email }}">
                                                </div>

                                                {{-- <div class="mb-10">
                                                    <label for="email" class="form-label">Address</label>
                                                    <input class="form-control" placeholder="Address" name="address"
                                                        type="text" id="address" value="{{ $user->address }}">
                                                </div> --}}

                                                <div class="mb-10">
                                                    <label for="email" class="form-label">Gender</label>
                                                    <select class="form-control" name="gender" id="gender">
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                </div>

                                                <div class="mb-10">
                                                    <label for="phone" class="form-label">Contact Number</label>
                                                    <input class="form-control" placeholder="Contact Number"
                                                        name="phone" type="number" id="phone"
                                                        value="{{ $user->phone }}">
                                                </div>

                                                <div class="mb-10">
                                                    <label for="email" class="form-label">Active</label>
                                                    <select class="form-control" name="is_active" id="is_active">
                                                        <option value="1"
                                                            {{ $user->is_active == 'active' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="0"
                                                            {{ $user->is_active == 'disable' ? 'selected' : '' }}>Disabled
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="mb-10">
                                                    <label for="password" class="form-label">Current Password</label>
                                                    <input class="form-control" placeholder="password" name="c_password"
                                                        type="password" value="" id="password">
                                                </div>
                                                <div class="mb-10">
                                                    <label for="password" class="form-label">New Password</label>
                                                    <input class="form-control" placeholder="password" name="password"
                                                        type="password" value="" id="password">
                                                </div>

                                                <input type="hidden" name="is_active" value="1">

                                                <div class="error-area"></div>
                                                <div class="box-footer mt20">
                                                    <button type="submit" class="btn btn-primary me-10"
                                                        id="crud-form-submit-button">
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
                    </div>
                </div>
            </div>

        </div>
    @endsection

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(d) {
            $('body').on('submit', '.profile_form', function(e) {
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
                    url: "{{ route('user.store', '') }}",
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
                        if (d.success == false) {
                            toastr.error(d.msg);
                        }
                        if (d.success == true) {
                            toastr.success(d.msg);
                            setTimeout(() => {
                                location.reload()
                            }, 1000);

                        }


                    },

                });
            })
        })
    </script>
