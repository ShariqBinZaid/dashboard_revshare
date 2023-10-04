<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('dashboard') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" {{-- <img alt="Logo" src="{{ asset('assets/media/logos/default-dark.svg') }}" --}}
                class="h-55px app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" {{-- <img alt="Logo" src="{{ asset('assets/media/logos/default-small.svg') }}" --}}
                class="h-10px app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="currentColor" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('dashboard') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('dashboard') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg fill="#fff" width="800px" height="800px" viewBox="0 0 24 24" id="dashboard"
                                        data-name="Flat Color" xmlns="http://www.w3.org/2000/svg"
                                        class="icon flat-color">
                                        <path id="secondary"
                                            d="M22,4V7a2,2,0,0,1-2,2H15a2,2,0,0,1-2-2V4a2,2,0,0,1,2-2h5A2,2,0,0,1,22,4ZM9,15H4a2,2,0,0,0-2,2v3a2,2,0,0,0,2,2H9a2,2,0,0,0,2-2V17A2,2,0,0,0,9,15Z"
                                            style="fill: rgb(44, 169, 188);"></path>
                                        <path id="primary"
                                            d="M11,4v7a2,2,0,0,1-2,2H4a2,2,0,0,1-2-2V4A2,2,0,0,1,4,2H9A2,2,0,0,1,11,4Zm9,7H15a2,2,0,0,0-2,2v7a2,2,0,0,0,2,2h5a2,2,0,0,0,2-2V13A2,2,0,0,0,20,11Z"
                                            style="fill: rgb(255, 255, 255);"></path>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('user.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg fill="currentColor" width="800px" height="800px" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">User</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                            <i class="fa-solid fa-truck-moving fa-beat-fade"></i>
                        </span>

                        <span class="menu-title">Rentals Menu</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('rentals.index') }}">
                                <span class="menu-bullet">
                                    <i class="fa-solid fa-arrow-right fa-beat-fade"></i>
                                </span>
                                <span class="menu-title">Rental</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="{{ route('rentalimages.index') }}">
                                <span class="menu-bullet">
                                    <i class="fa-solid fa-arrow-right fa-beat-fade"></i>
                                </span>
                                <span class="menu-title">Rental Images</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <i class="fa-solid fa-arrow-right fa-beat-fade"></i>
                                </span>
                                <span class="menu-title">Rental Reviews</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <i class="fa-solid fa-arrow-right fa-beat-fade"></i>
                                </span>
                                <span class="menu-title">Rental Addons</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                            <i class="fa-solid fa-plane fa-beat-fade"></i>
                        </span>

                        <span class="menu-title">Tours Menu</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <i class="fa-solid fa-arrow-right fa-beat-fade"></i>
                                </span>
                                <span class="menu-title">Tours</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <i class="fa-solid fa-arrow-right fa-beat-fade"></i>
                                </span>
                                <span class="menu-title">Tours Images</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link" href="#">
                                <span class="menu-bullet">
                                    <i class="fa-solid fa-arrow-right fa-beat-fade"></i>
                                </span>
                                <span class="menu-title">Tours Reviews</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->

                    </div>
                    <!--end:Menu sub-->
                </div>
            </div>

            {{-- <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('rentals.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('parent') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg fill="currentColor" width="800px" height="800px" viewBox="0 0 50 50"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <path
                                            d="M18 0C13.570313 0 10 3.570313 10 8C10 12.429688 13.570313 16 18 16C20.964844 16 23.523438 14.386719 24.90625 12L37 12C37.265625 12.007813 37.527344 11.90625 37.71875 11.71875L39.71875 9.71875C39.90625 9.527344 40.007813 9.265625 40 9L40 7C40.007813 6.734375 39.90625 6.472656 39.71875 6.28125L37.71875 4.28125C37.527344 4.09375 37.265625 3.992188 37 4L35 4C34.734375 3.992188 34.472656 4.09375 34.28125 4.28125L33.5 5.0625L32.71875 4.28125C32.527344 4.09375 32.265625 3.992188 32 4L30 4C29.800781 3.996094 29.605469 4.050781 29.4375 4.15625L28.5 4.78125L27.5625 4.15625C27.394531 4.050781 27.199219 3.996094 27 4L24.90625 4C23.523438 1.613281 20.964844 0 18 0 Z M 18 2C21.371094 2 24 4.628906 24 8C24 11.371094 21.371094 14 18 14C14.628906 14 12 11.371094 12 8C12 4.628906 14.628906 2 18 2 Z M 16 6C14.894531 6 14 6.894531 14 8C14 9.105469 14.894531 10 16 10C17.105469 10 18 9.105469 18 8C18 6.894531 17.105469 6 16 6 Z M 25.75 6L26.6875 6L27.9375 6.84375C28.277344 7.074219 28.722656 7.074219 29.0625 6.84375L30.3125 6L31.5625 6L32.78125 7.21875C32.96875 7.414063 33.230469 7.523438 33.5 7.523438C33.769531 7.523438 34.03125 7.414063 34.21875 7.21875L35.4375 6L36.5625 6L38 7.4375L38 8.5625L36.5625 10L25.75 10C25.914063 9.359375 26 8.691406 26 8C26 7.308594 25.914063 6.640625 25.75 6 Z M 15.6875 18C13.6875 18 11.859375 19.226563 11.09375 21.09375C11.089844 21.109375 11.066406 21.109375 11.0625 21.125L8.125 28L7 28C5.355469 28 4 29.355469 4 31C4 32.644531 5.355469 34 7 34L7 47C7 48.644531 8.355469 50 10 50L13 50C14.644531 50 16 48.644531 16 47L16 46L34 46L34 47C34 48.644531 35.355469 50 37 50L40 50C41.644531 50 43 48.644531 43 47L43 34C44.644531 34 46 32.644531 46 31C46 29.355469 44.644531 28 43 28L41.875 28L38.9375 21.125C38.933594 21.109375 38.910156 21.109375 38.90625 21.09375C38.140625 19.226563 36.3125 18 34.3125 18 Z M 15.6875 20L34.3125 20C35.496094 20 36.617188 20.765625 37.0625 21.875L37.09375 21.90625L39.90625 28.5L38.9375 29.15625L38.9375 29.1875C38.109375 29.765625 37.222656 30 36.1875 30L13.8125 30C12.777344 30 11.890625 29.765625 11.0625 29.1875L11.0625 29.15625L10.09375 28.5L12.90625 21.90625L12.9375 21.875C13.382813 20.765625 14.503906 20 15.6875 20 Z M 7 30L8.6875 30L9.9375 30.84375L9.9375 30.8125L9.96875 30.8125C11.136719 31.621094 12.457031 32 13.8125 32L36.1875 32C37.542969 32 38.863281 31.621094 40.03125 30.8125C40.039063 30.808594 40.054688 30.816406 40.0625 30.8125L40.0625 30.84375L41.3125 30L43 30C43.554688 30 44 30.445313 44 31C44 31.554688 43.554688 32 43 32L41 32L41 44L9 44L9 32L7 32C6.445313 32 6 31.554688 6 31C6 30.445313 6.445313 30 7 30 Z M 14.5 35C12.578125 35 11 36.578125 11 38.5C11 40.421875 12.578125 42 14.5 42C16.421875 42 18 40.421875 18 38.5C18 36.578125 16.421875 35 14.5 35 Z M 35.5 35C33.578125 35 32 36.578125 32 38.5C32 40.421875 33.578125 42 35.5 42C37.421875 42 39 40.421875 39 38.5C39 36.578125 37.421875 35 35.5 35 Z M 14.5 37C15.375 37 16 37.625 16 38.5C16 39.375 15.375 40 14.5 40C13.625 40 13 39.375 13 38.5C13 37.625 13.625 37 14.5 37 Z M 35.5 37C36.375 37 37 37.625 37 38.5C37 39.375 36.375 40 35.5 40C34.625 40 34 39.375 34 38.5C34 37.625 34.625 37 35.5 37 Z M 9 46L14 46L14 47C14 47.554688 13.554688 48 13 48L10 48C9.445313 48 9 47.554688 9 47 Z M 36 46L41 46L41 47C41 47.554688 40.554688 48 40 48L37 48C36.445313 48 36 47.554688 36 47Z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Rentals</span>
                        </span>
                    </a>
                </div>

            </div> --}}

            {{-- <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="#">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('parent') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="800px" height="800px" viewBox="0 0 50 50" version="1.2"
                                        baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" overflow="inherit">
                                        <path fill="currentColor"
                                            d="M48 41c-1 0-1.854-.226-2.734-.615-.916-.411-1.852-.652-2.923-.652-1.066 0-2.052.241-2.954.652-.892.389-1.859.615-2.897.615-1.032 0-2.017-.226-2.908-.615-.909-.411-1.925-.652-2.991-.652-1.07 0-2.091.241-3.007.652-.88.39-1.877.615-2.91.615-1.033 0-2.03-.226-2.912-.615-.915-.411-1.936-.652-3.002-.652-1.072 0-2.099.241-3.002.652-.887.389-1.88.615-2.913.615-1.038 0-2.031-.226-2.923-.615-.904-.411-1.931-.652-2.997-.652-1.066 0-2.099.241-3.008.652-.888.389-1.919.615-2.919.615v-4.27c1 0 2.031-.23 2.918-.621.91-.41 1.939-.652 3.005-.652 1.066 0 2.095.242 2.999.652.893.391 1.886.621 2.924.621 1.034 0 2.026-.23 2.913-.621.903-.41 1.931-.652 3.003-.652 1.066 0 2.087.242 3.002.652.881.391 1.88.621 2.913.621s2.032-.23 2.912-.621c.916-.41 1.938-.652 3.009-.652 1.066 0 2.088.242 2.997.652.892.391 1.887.621 2.919.621 1.038 0 2.026-.23 2.918-.621.902-.41 1.931-.652 2.997-.652 1.071 0 1.921.242 2.837.652.88.391 1.734.621 2.734.621v4.27zm-46.972-18l-.017 9.91c1.033 0 2.026-.311 2.913-.701.91-.412 1.937-.697 3.002-.697 1.066 0 2.093.219 2.997.631.893.391 1.885.604 2.923.604 1.034 0 2.026-.229 2.913-.619.903-.412 1.931-.656 3.002-.656 1.066 0 2.087.239 3.002.651.881.391 1.88.614 2.913.614s2.032-.225 2.912-.615c.916-.412 1.938-.653 3.009-.653 1.066 0 2.088.241 2.997.653.892.391 1.887.614 2.919.614.292 0 .572-.061.858-.093.521-.109 1.049-.159 1.555-.356l.034-.017c3.76-1.492 7.003-5.011 9.028-7.766l1.012-1.504h-47.972zm26.776-11h7.044c.079 0 1.902-.281 2.514 1.053l2.647 5.947h-9.023l-3.182-7zm-18.804 6.382c0 .466-.384.618-.855.618h-3.873c-.472 0-1.272-.152-1.272-.618v-5.729c0-.46.8-.653 1.272-.653h3.872c.472 0 .856.193.856.653v5.729zm16 0c0 .466-.418.618-.895.618h-3.867c-.477 0-1.238-.152-1.238-.618v-5.729c0-.46.761-.653 1.238-.653h3.867c.477 0 .895.193.895.653v5.729zm-8 0c0 .466-.416.618-.892.618h-3.844c-.478 0-1.264-.152-1.264-.618v-5.729c0-.46.786-.653 1.264-.653h3.844c.476 0 .892.193.892.653v5.729zm21.545-7.077c-1.151-2.502-4.266-2.305-4.266-2.305h-33.274l-.005 12h41.715l-4.17-9.695z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Tours</span>

                        </span>
                    </a>
                </div>

            </div> --}}





        </div>
    </div>
</div>
