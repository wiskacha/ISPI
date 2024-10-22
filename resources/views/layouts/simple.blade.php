<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>ISPI Landing</title>

    <meta name="description" content="Página de Inicio - ISPI">
    <meta name="author" content="w'iskacha">
    <meta name="robots" content="index, follow">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

    <!-- Modules -->
    @yield('css')
    @vite(['resources/sass/main.scss', 'resources/js/oneui/app.js'])

    <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
    {{-- @vite(['resources/sass/main.scss', 'resources/sass/oneui/themes/amethyst.scss', 'resources/js/oneui/app.js']) --}}
    @yield('js')
    <!-- In your backend.layout.blade.php, inside the <head> tag -->
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

            // Toggle dark mode
            function toggleDarkMode() {
                const pageContainer = document.getElementById('page-container');
                pageContainer.classList.toggle('dark-mode');

                // Store preference in localStorage
                const darkMode = pageContainer.classList.contains('dark-mode') ? 'enabled' : 'disabled';
                localStorage.setItem('darkMode', darkMode);

                // Call additional setup function if defined
                if (typeof additionalDarkModeSetup === 'function') {
                    additionalDarkModeSetup(darkMode);
                }
            }

            // Event listener for the dark mode toggle button
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', function() {
                    toggleDarkMode();
                });
            }

            // Initialize dark mode based on stored preference
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
        #page-container {
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        #page-container.dark-mode {
            background-color: #121212;
            /* Dark mode background color */
            color: #e0e0e0;
            /* Dark mode text color */
        }

        .hero,
        .modal-content,
        .content,
        .btn,
        .form-control {
            transition: background-color 0.5s ease, color 0.5s ease, border-color 0.5s ease;
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
</head>

<body>
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
    <div id="page-container">
        <!-- Main Container -->
        <main id="main-container">
            @yield('content')
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->
</body>

</html>
