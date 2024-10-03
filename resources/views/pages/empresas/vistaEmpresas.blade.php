@extends('layouts.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <style>
        .card-title {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-nombre {
            padding: 0;
            color: inherit;
        }

        .toggle-nombre:focus {
            outline: none;
            box-shadow: none;
        }

        .nombre-short,
        .nombre-full {
            margin-right: 5px;
        }
    </style>
@endsection

@section('js')
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>

    <!-- Page JS Code -->
    @vite(['resources/js/pages/datatables.js'])

    <script>
        $(document).ready(function() {
            let itemsPerPage; // Variable to store number of items per page
            let currentPage = 1;
            let filteredCards = [];

            $('.card-title').each(function() {
                const fullNombre = $(this).find('.nombre-full').text();
                const shortNombre = fullNombre.length > 17 ?
                    fullNombre.substring(0, 17) + '..' :
                    fullNombre;

                $(this).find('.nombre-short').text(shortNombre);

                if (fullNombre.length <= 15) {
                    $(this).find('.toggle-nombre').hide();
                }
            });

            $('.toggle-nombre').click(function() {
                const $cardTitle = $(this).closest('.card-title');
                const $shortNombre = $cardTitle.find('.nombre-short');
                const $fullNombre = $cardTitle.find('.nombre-full');
                const $icon = $(this).find('i');

                $shortNombre.toggleClass('d-none');
                $fullNombre.toggleClass('d-none');
                $icon.toggleClass('fa-chevron-down fa-chevron-up');

                const expanded = $fullNombre.is(':visible');
                $(this).attr('aria-expanded', expanded);
            });

            function setItemsPerPage() {
                if (window.innerWidth <= 768) { // Mobile breakpoint
                    itemsPerPage = 4; // Set for mobile
                    $('#prevPage').text('←'); // Set left arrow for previous button
                    $('#nextPage').text('→'); // Set right arrow for next button
                } else if (window.innerWidth > 768 && window.innerWidth < 1400) { // Tablet
                    itemsPerPage = 6; // Set for tablet
                    $('#prevPage').text('Anterior'); // Restore original text for previous button
                    $('#nextPage').text('Siguiente'); // Restore original text for next button
                } else { // Desktop
                    itemsPerPage = 9; // Set for desktop
                    $('#prevPage').text('Anterior'); // Restore original text for previous button
                    $('#nextPage').text('Siguiente'); // Restore original text for next button
                }
            }

            function updatePagination() {
                const totalPages = Math.ceil(filteredCards.length / itemsPerPage);
                $('#pageButtons').empty();

                if (totalPages <= 1) return; // No pagination needed if there's only one page

                // Show first page button only if not on the first page
                if (currentPage > 2) {
                    $('#pageButtons').append(
                        `<button class="btn btn-secondary mx-1 page-number" data-page="1">1</button>`);
                }

                // Add ellipsis if current page is greater than 3
                if (currentPage > 3) {
                    $('#pageButtons').append(`<span class="mx-1">...</span>`);
                }

                // Add previous page button only if not on the first page
                if (currentPage > 1) {
                    $('#pageButtons').append(
                        `<button class="btn btn-secondary mx-1 page-number" data-page="${currentPage - 1}">${currentPage - 1}</button>`
                    );
                }

                // Add current page button
                $('#pageButtons').append(`<button class="btn btn-secondary mx-1 active">${currentPage}</button>`);

                // Add next page button only if not on the last page
                if (currentPage < totalPages) {
                    $('#pageButtons').append(
                        `<button class="btn btn-secondary mx-1 page-number" data-page="${currentPage + 1}">${currentPage + 1}</button>`
                    );
                }

                // Add ellipsis if current page is less than total pages minus 2
                if (currentPage < totalPages - 2) {
                    $('#pageButtons').append(`<span class="mx-1">...</span>`);
                }

                // Show last page button only if not on the last page
                if (currentPage < totalPages - 1) {
                    $('#pageButtons').append(
                        `<button class="btn btn-secondary mx-1 page-number" data-page="${totalPages}">${totalPages}</button>`
                    );
                }

                // Disable previous and next buttons appropriately
                $('#prevPage').prop('disabled', currentPage === 1);
                $('#nextPage').prop('disabled', currentPage === totalPages);

                // Handle page number button click events
                $('.page-number').off('click').on('click', function() {
                    currentPage = parseInt($(this).data('page'));
                    showPage(currentPage);
                    updatePagination();
                });
            }

            function showPage(page) {
                const startIndex = (page - 1) * itemsPerPage;
                const endIndex = startIndex + itemsPerPage;
                $('.empresa-card').hide();
                filteredCards.slice(startIndex, endIndex).show();
            }

            function filterAndPaginate() {
                const searchValue = $('#searchInput').val().toLowerCase().trim();
                filteredCards = $('.empresa-card').filter(function() {
                    const cardTitle = $(this).find('.card-title').text().toLowerCase();
                    return cardTitle.indexOf(searchValue) > -1;
                });
                currentPage = 1;
                updatePagination();
                showPage(currentPage);
            }

            $('#searchInput').on('input', filterAndPaginate);

            $('#prevPage').click(function() {
                if (currentPage > 1) {
                    currentPage--;
                    showPage(currentPage);
                    updatePagination();
                }
            });

            $('#nextPage').click(function() {
                const totalPages = Math.ceil(filteredCards.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    showPage(currentPage);
                    updatePagination();
                }
            });

            $(document).on('click', '.page-number', function() {
                currentPage = parseInt($(this).text());
                showPage(currentPage);
                updatePagination();
            });

            // Initial setup
            setItemsPerPage(); // Set items per page on load
            filteredCards = $('.empresa-card');
            updatePagination();
            showPage(currentPage);

            // Adjust items per page on window resize
            $(window).resize(function() {
                setItemsPerPage();
                updatePagination(); // Update pagination and show correct page based on new items per page
                showPage(currentPage);
            });
        });
    </script>
@endsection

@section('content')
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Ver Empresas</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Visualizar empresas</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Empresas</li>
                        <li class="breadcrumb-item" aria-current="page">Vista de Empresas</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <!-- Search input -->
        <div class="mb-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar empresas...">
        </div>

        <div class="row" id="empresasContainer">
            @foreach ($empresas as $empresa)
                <div class="col-md-4 mb-4 empresa-card">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <h2 class="card-title mb-0">
                                <span class="nombre-short"></span>
                                <span class="nombre-full d-none">{{ $empresa->nombre }}</span>
                                <button class="btn btn-link btn-sm ml-2 toggle-nombre" aria-expanded="false">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </h2>
                            <small class="text-info">{{ $empresa->updated_at }}</small>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('empresas.edit', $empresa->id_empresa) }}" class="btn btn-alt-primary"><i
                                    class="fa fa-edit"></i> Editar</a>
                            <form action="{{ route('empresas.destroy', $empresa->id_empresa) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-alt-danger"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta empresa?');"><i
                                        class="fa fa-trash"></i> Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination controls -->
        <div class="d-flex justify-content-center mt-3" id="paginationControls">
            <button id="prevPage" class="btn btn-secondary" disabled>Anterior</button>
            <div id="pageButtons" class="mx-3"></div>
            <button id="nextPage" class="btn btn-secondary">Siguiente</button>
        </div>
    </div>
    <br>
    @if ($errors->any())
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div id="errorToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-white">
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endsection