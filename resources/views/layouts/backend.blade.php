<!-- @auth -->
    <!doctype html>
    <html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Sistema ISPI</title>

        <meta name="description" content="ISPI">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="index, follow">

        <!-- Icons -->
        <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

        <link rel="stylesheet" href="{{ asset('css/pace-custom.css') }}">
        <!-- Modules -->
        @yield('css')
        @vite(['resources/sass/main.scss', 'resources/js/oneui/app.js'])

        <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
        {{-- @vite(['resources/sass/main.scss', 'resources/sass/oneui/themes/amethyst.scss', 'resources/js/oneui/app.js']) --}}
        @yield('js')


    </head>

    <body>
        <script data-pace-options='{ "ajax": false }' src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
        {{-- <script>
            // Apply dark mode class as early as possible
            (function() {
                const darkMode = localStorage.getItem('darkMode');
                if (darkMode === 'enabled') {
                    document.documentElement.classList.add('dark-mode');
                }
            })
            ();
        </script> --}}

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Function to set dark mode based on stored preference
                function setDarkMode() {
                    const darkMode = localStorage.getItem('darkMode');
                    const pageContainer = document.getElementById('page-container');

                    if (darkMode === 'enabled') {
                        pageContainer.classList.add('dark-mode');
                    } else {
                        pageContainer.classList.remove('dark-mode');
                    }

                    // Call additional setup function if defined
                    if (typeof additionalDarkModeSetup === 'function') {
                        additionalDarkModeSetup(darkMode);
                    }
                }

                // Function to toggle dark mode and save the preference
                function toggleDarkMode() {
                    const pageContainer = document.getElementById('page-container');
                    const isDarkMode = pageContainer.classList.toggle('dark-mode');
                    localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');

                    // Call additional setup function if defined
                    if (typeof additionalDarkModeSetup === 'function') {
                        additionalDarkModeSetup(isDarkMode ? 'enabled' : 'disabled');
                    }
                }

                // Attach event listener to the dark mode toggle button
                const darkModeToggle = document.getElementById('dark-mode-toggle');
                if (darkModeToggle) {
                    darkModeToggle.addEventListener('click', toggleDarkMode);
                }

                // Initialize dark mode on page load
                setDarkMode();
            });
        </script>

        <style>
            /* CSS for modal animation */
            .modal.fade .modal-dialog {
                transform: translateY(+50px);
                opacity: 0;
                transition: transform 0.3s ease-out, opacity 0.3s ease-out;
            }

            .modal.show .modal-dialog {
                transform: translateY(0);
                opacity: 1;
            }

            /* CSS for dark mode transition */
            /* #page-container {
                                                                                                        transition: background-color 0.5s ease, color 0.5s ease;
                                                                                                    } */

            .hero,
            .modal-content,
            .content,
            .btn,
            .form-control {
                /* transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease; */
            }
        </style>

        <script>
            function additionalDarkModeSetup(darkMode) {
                const icon = document.getElementById('theme-icon');
                if (darkMode === 'enabled') {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }
        </script>

        <!-- Page Container -->
        <!--
                                                                                                    Available classes for #page-container:

                                                                                                    GENERIC

                                                                                                      'remember-theme'                            Remembers active color theme and dark mode between pages using localStorage when set through
                                                                                                                                                  - Theme helper buttons [data-toggle="theme"],
                                                                                                                                                  - Layout helper buttons [data-toggle="layout" data-action="dark_mode_[on/off/toggle]"]
                                                                                                                                                  - ..and/or One.layout('dark_mode_[on/off/toggle]')

                                                                                                    SIDEBAR & SIDE OVERLAY

                                                                                                      'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
                                                                                                      'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
                                                                                                      'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
                                                                                                      'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
                                                                                                      'sidebar-dark'                              Dark themed sidebar

                                                                                                      'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
                                                                                                      'side-overlay-o'                            Visible Side Overlay by default

                                                                                                      'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

                                                                                                      'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

                                                                                                    HEADER

                                                                                                      ''                                          Static Header if no class is added
                                                                                                      'page-header-fixed'                         Fixed Header

                                                                                                    HEADER STYLE

                                                                                                      ''                                          Light themed Header
                                                                                                      'page-header-dark'                          Dark themed Header

                                                                                                    MAIN CONTENT LAYOUT

                                                                                                      ''                                          Full width Main Content if no class is added
                                                                                                      'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
                                                                                                      'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)

                                                                                                    DARK MODE

                                                                                                      'sidebar-dark page-header-dark dark-mode'   Enable dark mode (light sidebar/header is not supported with dark mode)
                                                                                                    -->
        <div id="page-container"
            class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">
            <!-- Side Overlay-->
            <aside id="side-overlay" class="fs-sm">
                <!-- Side Header -->
                <div class="content-header border-bottom">
                    <!-- User Avatar -->
                    <a class="img-link me-1" href="javascript:void(0)">
                        <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar10.jpg') }}" alt="">
                    </a>
                    <!-- END User Avatar -->

                    <!-- User Info -->
                    <div class="ms-2">
                        <a class="text-dark fw-semibold fs-sm" href="javascript:void(0)">{{ auth()->user()->nick }}</a>
                    </div>
                    <!-- END User Info -->

                    <!-- Close Side Overlay -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <a class="ms-auto btn btn-sm btn-alt-danger" href="javascript:void(0)" data-toggle="layout"
                        data-action="side_overlay_close">
                        <i class="fa fa-fw fa-times"></i>
                    </a>
                    <!-- END Close Side Overlay -->
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
                <div class="content-side">
                    <p>
                        Content..
                    </p>
                </div>
                <!-- END Side Content -->
            </aside>
            <!-- END Side Overlay -->

            <!-- Sidebar -->
            <!--
                                                                                                        Sidebar Mini Mode - Display Helper classes

                                                                                                        Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
                                                                                                        Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
                                                                                                            If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

                                                                                                        Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
                                                                                                        Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
                                                                                                        Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
                                                                                                    -->

            <nav id="sidebar" aria-label="Main Navigation">
                <!-- Side Header -->
                <div class="content-header">
                    <!-- Logo -->
                    <a class="font-semibold text-dual" href="/dashboard">
                        <span class="smini-visible">
                            <i class="fa fa-circle-notch text-primary"></i>
                        </span>
                        <div class="d-flex align-items-center">
                            <h1 class="h1 mb-1 me-2">ISPI</h1>
                            <span class="text-city"><i class="fas fa-fish fa-2x text-alert"></i>
                        </div>
                    </a>
                    <!-- END Logo -->

                    <!-- Extra -->
                    <div>
                        <!-- Dark Mode -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a id="dark-mode-toggle" class="btn btn-sm btn-alt-secondary" href="javascript:void(0)">
                            <i id="theme-icon" class="far fa-moon"></i>
                        </a>
                        <!-- END Dark Mode -->

                        <!-- Options -->
                        <div class="dropdown d-inline-block ms-1">
                            <a class="btn btn-sm btn-alt-secondary" id="sidebar-themes-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="fa fa-brush"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end fs-sm smini-hide border-0"
                                aria-labelledby="sidebar-themes-dropdown">
                                <!-- Sidebar Styles -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <a class="dropdown-item fw-medium" data-toggle="layout" data-action="sidebar_style_light"
                                    href="javascript:void(0)">
                                    <span>Sidebar Light</span>
                                </a>
                                <a class="dropdown-item fw-medium" data-toggle="layout" data-action="sidebar_style_dark"
                                    href="javascript:void(0)">
                                    <span>Sidebar Dark</span>
                                </a>
                                <!-- END Sidebar Styles -->

                                <div class="dropdown-divider"></div>

                                <!-- Header Styles -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <a class="dropdown-item fw-medium" data-toggle="layout" data-action="header_style_light"
                                    href="javascript:void(0)">
                                    <span>Header Light</span>
                                </a>
                                <a class="dropdown-item fw-medium" data-toggle="layout" data-action="header_style_dark"
                                    href="javascript:void(0)">
                                    <span>Header Dark</span>
                                </a>
                                <!-- END Header Styles -->
                            </div>
                        </div>
                        <!-- END Options -->

                        <!-- Close Sidebar, Visible only on mobile screens -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout"
                            data-action="sidebar_close" href="javascript:void(0)">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                        <!-- END Close Sidebar -->
                    </div>
                    <!-- END Extra -->
                </div>
                <!-- END Side Header -->

                <!-- Sidebar Scrolling -->
                <div class="js-sidebar-scroll">
                    <!-- Side Navigation -->
                    <div class="content-side">
                        <ul class="nav-main">
                            <li class="nav-main-item">
                                <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="/dashboard">
                                    <i class="nav-main-link-icon si si-cursor"></i>
                                    <span class="nav-main-link-name">Dashboard</span>
                                </a>
                            </li>

                            @if (Auth::check() && Auth::user()->hasRole('admin'))
                                <li class="nav-main-heading">Modulos - ADMINISTRACIÓN</li>
                                <li class="nav-main-item{{ request()->is('personas/*') ? ' open' : '' }}">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                        aria-haspopup="true" aria-expanded="true" href="#">
                                        <i class="nav-main-link-icon si si-users"></i>
                                        <span class="nav-main-link-name">Personas</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item{{ request()->is('personas/clientes/*') ? ' open' : '' }}">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="true" href="#">
                                                <i class="nav-main-link-icon si si-handbag"></i>
                                                <span class="nav-main-link-name">Clientes</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('personas/clientes/vista') ? ' active' : '' }}"
                                                        href="/personas/clientes/vista">
                                                        <i class="nav-main-link-icon si si-list"></i>
                                                        <span class="nav-main-link-name">Ver Clientes</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('personas/clientes/registro') ? ' active' : '' }}"
                                                        href="/personas/clientes/registro">
                                                        <i class="nav-main-link-icon si si-plus"></i>
                                                        <span class="nav-main-link-name">Registrar Cliente</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li
                                            class="nav-main-item{{ request()->is('personas/usuarios/*') ? ' open' : '' }}">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="true" href="#">
                                                <i class="nav-main-link-icon si si-user"></i>
                                                <span class="nav-main-link-name">Usuarios</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('personas/usuarios/vista') ? ' active' : '' }}"
                                                        href="/personas/usuarios/vista">
                                                        <i class="nav-main-link-icon si si-list"></i>
                                                        <span class="nav-main-link-name">Ver Usuarios</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('personas/usuarios/registro') ? ' active' : '' }}"
                                                        href="/personas/usuarios/registro">
                                                        <i class="nav-main-link-icon si si-plus"></i>
                                                        <span class="nav-main-link-name">Registrar Usuario</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-main-item{{ request()->is('productos/*') ? ' open' : '' }}">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                        aria-haspopup="true" aria-expanded="true" href="#">
                                        <i class="nav-main-link-icon si si-bag"></i>
                                        <span class="nav-main-link-name">Productos</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link{{ request()->is('productos/vista') ? ' active' : '' }}"
                                                href="/productos/vista">
                                                <i class="nav-main-link-icon si si-list"></i>
                                                <span class="nav-main-link-name">Ver productos</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link{{ request()->is('productos/registro') ? ' active' : '' }}"
                                                href="/productos/registro">
                                                <i class="nav-main-link-icon si si-plus"></i>
                                                <span class="nav-main-link-name">Registrar Productos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-main-item{{ request()->is('empresas/*') || request()->is('contactos/*') ? ' open' : '' }}">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                        aria-haspopup="true" aria-expanded="true" href="#">
                                        <i class="nav-main-link-icon si si-briefcase"></i>
                                        <span class="nav-main-link-name">Empresas</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item{{ request()->is('empresas/vista') ? ' open' : '' }}">
                                            <a class="nav-main-link{{ request()->is('empresas/vista') ? ' active' : '' }}"
                                                href="/empresas/vista">
                                                <i class="nav-main-link-icon si si-list"></i>
                                                <span class="nav-main-link-name">Ver Empresas</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item{{ request()->is('empresas/registro') ? ' open' : '' }}">
                                            <a class="nav-main-link{{ request()->is('empresas/registro') ? ' active' : '' }}"
                                                href="/empresas/registro">
                                                <i class="nav-main-link-icon si si-plus"></i>
                                                <span class="nav-main-link-name">Registrar Empresa</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item{{ request()->is('contactos/*') ? ' open' : '' }}">
                                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                                aria-haspopup="true" aria-expanded="true" href="#">
                                                <i class="nav-main-link-icon si si-users"></i>
                                                <span class="nav-main-link-name">Proveedores</span>
                                            </a>
                                            <ul class="nav-main-submenu">
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('contactos/vista') ? ' active' : '' }}"
                                                        href="/contactos/vista">
                                                        <i class="nav-main-link-icon si si-list"></i>
                                                        <span class="nav-main-link-name">Ver Contactos</span>
                                                    </a>
                                                </li>
                                                <li class="nav-main-item">
                                                    <a class="nav-main-link{{ request()->is('contactos/registro') ? ' active' : '' }}"
                                                        href="/contactos/registro">
                                                        <i class="nav-main-link-icon si si-plus"></i>
                                                        <span class="nav-main-link-name">Registrar Contacto</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-main-item{{ request()->is('almacenes/*') ? ' open' : '' }}">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                        aria-haspopup="true" aria-expanded="true" href="#">
                                        <i class="nav-main-link-icon si si-social-dropbox"></i>
                                        <span class="nav-main-link-name">Almacenes</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link{{ request()->is('almacenes/vista') ? ' active' : '' }}"
                                                href="/almacenes/vista">
                                                <i class="nav-main-link-icon si si-list"></i>
                                                <span class="nav-main-link-name">Ver almacenes</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link{{ request()->is('almacenes/registro') ? ' active' : '' }}"
                                                href="/almacenes/registro">
                                                <i class="nav-main-link-icon si si-plus"></i>
                                                <span class="nav-main-link-name">Registrar Almacenes</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-main-item{{ request()->is('recintos/*') ? ' open' : '' }}">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                        aria-haspopup="true" aria-expanded="true" href="#">
                                        <i class="nav-main-link-icon si si-pin"></i>
                                        <span class="nav-main-link-name">Recintos</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link{{ request()->is('recintos/vista') ? ' active' : '' }}"
                                                href="/recintos/vista">
                                                <i class="nav-main-link-icon si si-list"></i>
                                                <span class="nav-main-link-name">Ver recintos</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link{{ request()->is('recintos/registro') ? ' active' : '' }}"
                                                href="/recintos/registro">
                                                <i class="nav-main-link-icon si si-plus"></i>
                                                <span class="nav-main-link-name">Registrar Recintos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <hr>
                                <li class="nav-main-item{{ request()->is('movimientos/*') ? ' open' : '' }}">
                                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu"
                                        aria-haspopup="true" aria-expanded="true" href="#">
                                        <i class="nav-main-link-icon si si-shuffle"></i>
                                        <span class="nav-main-link-name">Movimientos</span>
                                    </a>
                                    <ul class="nav-main-submenu">
                                        <li class="nav-main-item">
                                            <a class="nav-main-link{{ request()->is('movimientos/vista') ? ' active' : '' }}"
                                                href="/movimientos/vista">
                                                <i class="nav-main-link-icon si si-list"></i>
                                                <span class="nav-main-link-name">Ver Movimientos</span>
                                            </a>
                                        </li>
                                        <li class="nav-main-item">
                                            <a class="nav-main-link{{ request()->is('movimientos/registro') ? ' active' : '' }}"
                                                href="/movimientos/registro">
                                                <i class="nav-main-link-icon si si-plus"></i>
                                                <span class="nav-main-link-name">Registrar Movimiento</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <hr>
                            @endif

                            <li class="nav-main-heading">Modulos - OPERACIÓN</li>
                            <li class="nav-main-item{{ request()->is('movimientos/*') ? ' open' : '' }}">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                    aria-expanded="true" href="#">
                                    <i class="nav-main-link-icon si si-pin"></i>
                                    <span class="nav-main-link-name">Movimientos</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('recintos/vista') ? ' active' : '' }}"
                                            href="/recintos/vista">
                                            <i class="nav-main-link-icon si si-list"></i>
                                            <span class="nav-main-link-name">Ver Movimientos</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('recintos/registro') ? ' active' : '' }}"
                                            href="/recintos/registro">
                                            <i class="nav-main-link-icon si si-plus"></i>
                                            <span class="nav-main-link-name">Registrar Movimientos</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-main-heading">Various</li>
                            <li class="nav-main-item{{ request()->is('pages/*') ? ' open' : '' }}">
                                <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                                    aria-expanded="true" href="#">
                                    <i class="nav-main-link-icon si si-bulb"></i>
                                    <span class="nav-main-link-name">Examples</span>
                                </a>
                                <ul class="nav-main-submenu">
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('pages/datatables') ? ' active' : '' }}"
                                            href="/pages/datatables">
                                            <span class="nav-main-link-name">DataTables</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('pages/slick') ? ' active' : '' }}"
                                            href="/pages/slick">
                                            <span class="nav-main-link-name">Slick Slider</span>
                                        </a>
                                    </li>
                                    <li class="nav-main-item">
                                        <a class="nav-main-link{{ request()->is('pages/blank') ? ' active' : '' }}"
                                            href="/pages/blank">
                                            <span class="nav-main-link-name">Blank</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-main-heading">More</li>
                            <li class="nav-main-item open">
                                <a class="nav-main-link" href="/">
                                    <i class="nav-main-link-icon si si-globe"></i>
                                    <span class="nav-main-link-name">Landing</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- END Sidebar Scrolling -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header" class="page-header" style="background-color: #334155; color: #fff;">
                <!-- Header Content -->
                <div id="content-header" class="content-header">
                    <!-- Left Section -->
                    <div class="d-flex align-items-center">
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                        <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout"
                            data-action="sidebar_toggle">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                        <!-- END Toggle Sidebar -->

                        <!-- Open Search Section (visible on smaller screens) -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-sm btn-alt-secondary d-md-none" data-toggle="layout"
                            data-action="header_search_on">
                            <i class="fa fa-fw fa-search"></i>
                        </button>
                        <!-- END Open Search Section -->

                        <!-- Search Form (visible on larger screens) -->
                        <form class="d-none d-md-inline-block" action="/dashboard" method="POST">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-alt" placeholder="Search.."
                                    id="page-header-search-input2" name="page-header-search-input2">
                                <span class="input-group-text border-0">
                                    <i class="fa fa-fw fa-search"></i>
                                </span>
                            </div>
                        </form>
                        <!-- END Search Form -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="d-flex align-items-center">
                        <!-- User Dropdown -->
                        <div class="dropdown d-inline-block ms-2">
                            <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center"
                                id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <img class="rounded-circle" src="{{ asset('media/avatars/avatar10.jpg') }}"
                                    alt="Header Avatar" style="width: 21px;">
                                <span class="d-none d-sm-inline-block ms-2">{{ auth()->user()->nick }}</span>
                                <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ms-1 mt-1"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
                                aria-labelledby="page-header-user-dropdown">
                                <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                                    <img class="img-avatar img-avatar48 img-avatar-thumb"
                                        src="{{ asset('media/avatars/avatar10.jpg') }}" alt="">
                                    <p class="mt-2 mb-0 fw-medium">{{ auth()->user()->persona->nombre }}
                                        {{ auth()->user()->persona->papellido }}</p>
                                    <p class="mb-0 text-muted fs-sm fw-medium">Web Developer</p>
                                </div>
                                <div class="p-2">
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span class="fs-sm fw-medium">Inbox</span>
                                        <span class="badge rounded-pill bg-primary ms-2">3</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span class="fs-sm fw-medium">Profile</span>
                                        <span class="badge rounded-pill bg-primary ms-2">1</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span class="fs-sm fw-medium">Settings</span>
                                    </a>
                                </div>
                                <div role="separator" class="dropdown-divider m-0"></div>
                                <div class="p-2">
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                        href="javascript:void(0)">
                                        <span class="fs-sm fw-medium">Lock Account</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between"
                                        href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                        <span class="fs-sm fw-medium">Log Out</span>
                                    </a>

                                </div>
                            </div>
                        </div>
                        <!-- END User Dropdown -->

                        <!-- Notifications Dropdown -->
                        <div class="dropdown d-inline-block ms-2">
                            <button type="button" class="btn btn-sm btn-alt-secondary"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fa fa-fw fa-bell"></i>
                                <span class="text-primary">•</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0 border-0 fs-sm"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-2 bg-body-light border-bottom text-center rounded-top">
                                    <h5 class="dropdown-header text-uppercase">Notifications</h5>
                                </div>
                                <ul class="nav-items mb-0">
                                    <li>
                                        <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 me-2 ms-3">
                                                <i class="fa fa-fw fa-check-circle text-success"></i>
                                            </div>
                                            <div class="flex-grow-1 pe-2">
                                                <div class="fw-semibold">You have a new follower</div>
                                                <span class="fw-medium text-muted">15 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 me-2 ms-3">
                                                <i class="fa fa-fw fa-plus-circle text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 pe-2">
                                                <div class="fw-semibold">1 new sale, keep it up</div>
                                                <span class="fw-medium text-muted">22 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 me-2 ms-3">
                                                <i class="fa fa-fw fa-times-circle text-danger"></i>
                                            </div>
                                            <div class="flex-grow-1 pe-2">
                                                <div class="fw-semibold">Update failed, restart server</div>
                                                <span class="fw-medium text-muted">26 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 me-2 ms-3">
                                                <i class="fa fa-fw fa-plus-circle text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1 pe-2">
                                                <div class="fw-semibold">2 new sales, keep it up</div>
                                                <span class="fw-medium text-muted">33 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 me-2 ms-3">
                                                <i class="fa fa-fw fa-user-plus text-success"></i>
                                            </div>
                                            <div class="flex-grow-1 pe-2">
                                                <div class="fw-semibold">You have a new subscriber</div>
                                                <span class="fw-medium text-muted">41 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="text-dark d-flex py-2" href="javascript:void(0)">
                                            <div class="flex-shrink-0 me-2 ms-3">
                                                <i class="fa fa-fw fa-check-circle text-success"></i>
                                            </div>
                                            <div class="flex-grow-1 pe-2">
                                                <div class="fw-semibold">You have a new follower</div>
                                                <span class="fw-medium text-muted">42 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="p-2 border-top text-center">
                                    <a class="d-inline-block fw-medium" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-arrow-down me-1 opacity-50"></i> Load More..
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- END Notifications Dropdown -->

                        <!-- Toggle Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-sm btn-alt-secondary ms-2" data-toggle="layout"
                            data-action="side_overlay_toggle">
                            <i class="fa fa-fw fa-list-ul fa-flip-horizontal"></i>
                        </button>
                        <!-- END Toggle Side Overlay -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Search -->
                <div id="page-header-search" class="overlay-header bg-body-extra-light">
                    <div class="content-header">
                        <form class="w-100" action="/dashboard" method="POST">
                            @csrf
                            <div class="input-group">
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <button type="button" class="btn btn-alt-danger" data-toggle="layout"
                                    data-action="header_search_off">
                                    <i class="fa fa-fw fa-times-circle"></i>
                                </button>
                                <input type="text" class="form-control" placeholder="Search or hit ESC.."
                                    id="page-header-search-input" name="page-header-search-input">
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Header Search -->

                <!-- Header Loader -->
                <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
                <div id="page-header-loader" class="overlay-header bg-body-extra-light">
                    <div class="content-header">
                        <div class="w-100 text-center">
                            <i class="fa fa-fw fa-circle-notch fa-spin"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                @if (session('success') || isset($success))
                    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
                        <div id="successToast" class="toast show" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="toast-header bg-success text-white">
                                <strong class="me-auto">Éxito</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                @if (session('success'))
                                    {{ session('success') }}
                                @elseif (isset($success))
                                    @if (is_array($success))
                                        <ul>
                                            @foreach ($success as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $success }}
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @yield('content')
            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="bg-body-light">
                <div class="content py-3">
                    <div class="row fs-sm">
                        <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                            Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold"
                                href="https://pixelcave.com" target="_blank">pixelcave</a>
                        </div>
                        <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                            <a class="fw-semibold" href="https://pixelcave.com/products/oneui" target="_blank">OneUI</a>
                            &copy; <span data-toggle="year-copy"></span>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro(a) de cerrar sesión?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="/logout" class="btn btn-danger">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- END Page Container -->
    </body>

    </html>
    <!--
@endauth -->
