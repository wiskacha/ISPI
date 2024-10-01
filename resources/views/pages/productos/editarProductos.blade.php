@extends('layouts.backend')

@section('css')
    <!-- Add necessary CSS here -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="content content-boxed">
        <!-- Product Edit -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Editar Producto</h3>
            </div>
            <div class="block-content">
                <form id="product-edit" action="{{ route('productos.update', $producto->id_producto) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Main form fields (Two columns) -->
                    <div class="row push">
                        <div class="col-lg-8 col-xl-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Nombre -->
                                    <div class="mb-4">
                                        <label class="form-label" for="nombre">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            value="{{ old('nombre', $producto->nombre) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Código -->
                                    <div class="mb-4">
                                        <label class="form-label" for="codigo">Código</label>
                                        <input type="text" class="form-control" id="codigo" name="codigo"
                                            value="{{ old('codigo', $producto->codigo) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Precio -->
                                    <div class="mb-4">
                                        <label class="form-label" for="precio">Precio</label>
                                        <input type="text" class="form-control" id="precio" name="precio"
                                            value="{{ old('precio', $producto->precio) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Unidad -->
                                    <div class="mb-4">
                                        <label class="form-label" for="unidad">Unidad</label>
                                        <input type="text" class="form-control" id="unidad" name="unidad"
                                            value="{{ old('unidad', $producto->unidad) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Presentación -->
                                    <div class="mb-4">
                                        <label class="form-label" for="presentacion">Presentación</label>
                                        <input type="text" class="form-control" id="presentacion" name="presentacion"
                                            value="{{ old('presentacion', $producto->presentacion) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Empresa -->
                                    <div class="mb-4">
                                        <label class="col-8 form-label" for="empresa">Empresa</label>
                                        <select class="col-12 col-md-12 js-example-basic-single form-control-lg"
                                            id="empresa" name="id_empresa">
                                            @foreach ($empresas as $empresa)
                                                <option class="col-12" value="{{ $empresa->id_empresa }}"
                                                    {{ $producto->id_empresa == $empresa->id_empresa ? 'selected' : '' }}>
                                                    {{ $empresa->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Tags -->
                            <div class="mb-4">
                                <label class="form-label" for="tags">Tags</label>
                                <textarea class="form-control" id="tags" name="tags">{{ old('tags', implode("\n", json_decode($producto->tags, true) ?? [])) }}</textarea>
                                <small class="text-muted">Escribe cada tag en una nueva línea.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Portada Section (Separate Block) -->
                    <div class="block block-bordered mt-5">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Adjuntos - Portada</h3>
                        </div>
                        <div class="block-content">
                            <!-- Imagen actual -->
                            <div class="mb-4">
                                <label class="form-label">Imagen actual</label>
                                <div class="mb-4" id="main-image-preview">
                                    @if (Storage::exists(
                                            'public/productos/' .
                                                substr($producto->nombre, 0, 4) .
                                                '_' .
                                                $producto->created_at->format('YmdHis') .
                                                '/main/main.jpeg'))
                                        <img src="{{ asset(
                                            'storage/productos/' .
                                                substr($producto->nombre, 0, 4) .
                                                '_' .
                                                $producto->created_at->format('YmdHis') .
                                                '/main/main.jpeg',
                                        ) }}"
                                            style="max-width: 200px;" alt="Producto Imagen">
                                    @else
                                        <img src="https://via.placeholder.com/100" alt="No Image" style="max-width: 200px;">
                                    @endif
                                </div>
                                <label for="image" class="form-label">Subir nueva imagen</label>
                                <input class="form-control" type="file" id="image" name="image"
                                    accept=".png, .jpg, .jpeg">
                            </div>

                            <!-- Checkbox to delete the current image -->
                            <div class="mb-4">
                                <label for="delete_image" class="form-label">Eliminar imagen actual</label>
                                <input type="checkbox" id="delete_image" name="delete_image"
                                    onclick="toggleDeleteMainImage()">
                                <small class="text-muted">Marque esta opción para eliminar la imagen actual.</small>
                            </div>
                        </div>
                    </div>


                    {{-- ADJUNTOS --}}
                    <div class="block block-bordered mt-5">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Adjuntos - Imagenes</h3>
                        </div>
                        <div class="block-content">
                            <!-- Imágenes -->
                            <div class="row">
                                @for ($i = 1; $i <= 3; $i++)
                                    <div class="col-md-4 mb-3">
                                        <div class="image-preview" id="image-preview-{{ $i }}">
                                            @php
                                                $adjunto = $producto->adjuntos->firstWhere(
                                                    'descripcion',
                                                    'img' . $i . '.jpeg',
                                                );
                                            @endphp
                                            <div style="width: auto; margin-bottom: 1.2rem;">
                                                @if ($adjunto)
                                                    <img src="{{ asset($adjunto->uri) }}"
                                                        alt="Imagen img{{ $i }}" height="160">
                                                @else
                                                    <img src="https://via.placeholder.com/100" alt="Placeholder"
                                                        width="160">
                                                @endif
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="delete-image-{{ $i }}"
                                                    onclick="toggleDeleteImage('{{ $i }}')"
                                                    value="{{ $adjunto ? $adjunto->id_adjunto : '' }}"
                                                    {{ $adjunto ? '' : 'disabled' }}> <!-- Disable if no image exists -->
                                                <label class="form-check-label"
                                                    for="delete-image-{{ $i }}">Eliminar</label>
                                            </div>
                                            <input type="file" class="form-control form-control-lg form-control-alt"
                                                name="imagenes[{{ $i }}]" id="imagenes-{{ $i }}"
                                                accept=".png, .jpg, .jpeg">
                                        </div>
                                    </div>
                                @endfor


                                <small class="form-text text-muted">Solo se permiten hasta 3 imágenes. Cada archivo debe
                                    ser
                                    menor a 2MB.</small>
                                @error('imagenes.*')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Hidden input for deleted images -->
                    <input type="hidden" id="deletedImages" name="deleted_images" value="">


                    <!-- Documentos -->
                    <div class="block block-bordered mt-5">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Adjuntos - Documentos</h3>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                @for ($i = 1; $i <= 2; $i++)
                                    <div class="col-md-6 mb-3">
                                        <div class="document-preview" id="document-preview-{{ $i }}">
                                            @php
                                                $documento = $producto->adjuntos->firstWhere(
                                                    'descripcion',
                                                    'doc' . $i . '.pdf',
                                                );
                                            @endphp
                                            <div style="height: auto; margin-bottom: 1.2rem;">
                                                @if ($documento)
                                                    <!-- Embed PDF for preview -->
                                                    <div class="justify-content-center"
                                                        style="align-content: center; align-items: center; text-align: center">
                                                        <a href="{{ asset($documento->uri) }}" target="_blank">Documento
                                                            {{ $i }}</a>
                                                    </div>
                                                    <embed src="{{ asset($documento->uri) }}" type="application/pdf"
                                                        width="100%" height="200px" />
                                                @else
                                                    <div class="justify-content-center"
                                                        style="align-content: center; align-items: center; text-align: center">
                                                        <span>No Documento</span>
                                                    </div>
                                                    {{-- //Put a placeholder space to compensate when there's no document so it mantains a proper height --}}
                                                    <embed src="https://via.placeholder.com/470" type="application/pdf"
                                                        width="100%" height="200px" />
                                                @endif
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="delete-doc-{{ $i }}"
                                                    onclick="toggleDeleteDoc('{{ $i }}')"
                                                    value="{{ $documento ? $documento->id_adjunto : '' }}"
                                                    {{ $documento ? '' : 'disabled' }}>
                                                <label class="form-check-label"
                                                    for="delete-doc-{{ $i }}">Eliminar</label>
                                            </div>
                                            <input type="file" class="form-control form-control-lg form-control-alt"
                                                name="documentos[{{ $i }}]"
                                                id="documentos-{{ $i }}" accept="application/pdf">
                                        </div>
                                    </div>
                                @endfor

                                <small class="form-text text-muted">Solo se permiten hasta 2 Documentos. Cada archivo debe
                                    ser
                                    menor a 5MB.</small>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="deleted_documents" value="">

                    <!-- Update Button -->
                    <div class="mb-4 mt-4">
                        <button type="button" class="btn btn-alt-primary" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal">Actualizar</button>
                    </div>

                </form>

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmationModalLabel">Confirmar Cambios</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6>Cambios realizados en ADJUNTOS:</h6>
                                <ul id="changes-list">
                                    <!-- Dynamic changes will be displayed here -->
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="confirm-submit">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function() {
            // Apply Select2 to the ID Empresa field
            $('#empresa').select2({
                placeholder: "Selecciona una empresa",
                allowClear: false,
                
            });
        });
    </script>
    <script>
        // First block: Functions for image and document toggling
        function toggleDeleteImage(index) {
            const checkbox = document.getElementById(`delete-image-${index}`);
            const deletedImagesInput = document.getElementById('deletedImages');
            const currentDeletedImages = deletedImagesInput.value.split(',').filter(Boolean); // Remove empty values
            const imageInput = document.getElementById(`imagenes-${index}`); // Reference to the image input

            if (checkbox.checked) {
                document.getElementById('image-preview-' + index).style.filter = 'sepia(1) saturate(10) hue-rotate(-50deg)'; // Red filter effect
                if (checkbox.value) {
                    currentDeletedImages.push(checkbox.value);
                }
                // Disable the input and clear it
                imageInput.disabled = true;
                imageInput.value = ''; // Clear the previous upload
            } else {
                document.getElementById('image-preview-' + index).style.filter = 'none';
                const indexToRemove = currentDeletedImages.indexOf(checkbox.value);
                if (indexToRemove > -1) {
                    currentDeletedImages.splice(indexToRemove, 1); // Remove unchecked value
                }
                // Enable the input
                imageInput.disabled = false;
            }

            deletedImagesInput.value = currentDeletedImages.join(',') + (currentDeletedImages.length ? ',' :
                ''); // Update hidden input
        }

        function toggleDeleteDoc(index) {
            const checkbox = document.getElementById(`delete-doc-${index}`);
            const documentPreview = document.getElementById(`document-preview-${index}`);
            const deletedDocumentsInput = document.querySelector('input[name="deleted_documents"]');
            const documentInput = document.getElementById(`documentos-${index}`); // Reference to the document input
            const currentDeletedDocuments = deletedDocumentsInput.value.split(',').filter(Boolean); // Remove empty values

            if (checkbox.checked) {
                documentPreview.style.filter = 'sepia(1) saturate(10) hue-rotate(-50deg)'; // Apply sepia filter to document preview
                currentDeletedDocuments.push(checkbox.value);
                // Disable the input and clear it
                documentInput.disabled = true;
                documentInput.value = ''; // Clear the previous upload
            } else {
                documentPreview.style.filter = 'none'; // Remove sepia filter
                const indexToRemove = currentDeletedDocuments.indexOf(checkbox.value);
                if (indexToRemove > -1) {
                    currentDeletedDocuments.splice(indexToRemove, 1); // Remove unchecked value
                }
                // Enable the input
                documentInput.disabled = false;
            }

            deletedDocumentsInput.value = currentDeletedDocuments.join(',') + (currentDeletedDocuments.length ? ',' :
                ''); // Update hidden input
        }

        function toggleDeleteMainImage() {
            const checkbox = document.getElementById('delete_image');
            const mainImagePreview = document.getElementById('main-image-preview');
            const mainImageInput = document.getElementById(
                'image'); // Reference to the main image input (change index if necessary)

            if (checkbox.checked) {
                mainImagePreview.style.filter = 'sepia(1) saturate(10) hue-rotate(-50deg)'; // Apply sepia filter
                // Disable the input and clear it
                mainImageInput.disabled = true;
                mainImageInput.value = ''; // Clear the previous upload
            } else {
                mainImagePreview.style.filter = 'none'; // Remove sepia filter
                // Enable the input
                mainImageInput.disabled = false;
            }
        }


        // Second block: Modal functions
        // Second block: Modal functions
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('button[data-bs-target="#confirmationModal"]').addEventListener('click',
                function() {
                    const changesList = document.getElementById('changes-list');
                    changesList.innerHTML = ''; // Clear the list before populating

                    let changesMade = false; // Flag to check if any changes were made

                    // Check for changes in form fields
                    const formData = new FormData(document.querySelector('form'));

                    // List of fields to check for changes
                    const fieldsToCheck = [{
                            name: 'nombre',
                            label: 'Nombre Completo'
                        },
                        {
                            name: 'codigo',
                            label: 'Código'
                        },
                        {
                            name: 'precio',
                            label: 'Precio/u'
                        },
                        {
                            name: 'unidad',
                            label: 'Unidad'
                        },
                        {
                            name: 'presentacion',
                            label: 'Presentación'
                        }, // Make sure 'presentacion' is in the form
                        {
                            name: 'id_empresa',
                            label: 'Compañía'
                        },
                        {
                            name: 'tags',
                            label: 'Tags'
                        }
                    ];

                    fieldsToCheck.forEach(field => {
                        const input = document.querySelector(`[name="${field.name}"]`);
                        const originalValue = input.defaultValue || (input.selectedOptions && input
                            .selectedOptions[0]?.text) || '';
                        const newValue = formData.get(field.name) || '';

                        if (newValue && newValue !== originalValue) {
                            const listItem = document.createElement('li');
                            listItem.textContent = `${field.label}: ${originalValue} → ${newValue}`;
                            changesList.appendChild(listItem);
                            changesMade = true; // Set flag to true if any change is found
                        }
                    });

                    // Check for the main image delete
                    const deletedImage = [];
                    const mainCheckbox = document.getElementById(`delete_image`);
                    if (mainCheckbox.checked) {
                        const imageName = mainCheckbox.value ? `main.jpeg` : `Imagen main`;
                        deletedImage.push(`Imagen eliminada: ${imageName}`);
                    }

                    if (deletedImage.length > 0) {
                        deletedImage.forEach(imgMessage => {
                            const listItem = document.createElement('li');
                            listItem.textContent = imgMessage;
                            changesList.appendChild(listItem);
                            changesMade = true; // Set flag to true if any deletion is found
                        });
                    }

                    // Check for new MAIN image uploads
                    const mainImageInput = document.getElementById(`image`);
                    const originalMainImage = mainImageInput.dataset
                        .originalName; // Assuming you have this attribute set in HTML
                    if (mainImageInput.files.length > 0) {
                        if (originalMainImage) {
                            const listItem = document.createElement('li');
                            listItem.textContent =
                                `Reemplazando imagen principal: ${originalMainImage} con ${mainImageInput.files[0].name}`;
                            changesList.appendChild(listItem);
                            changesMade = true; // Set flag to true if any new upload is found
                        } else {
                            const listItem = document.createElement('li');
                            listItem.textContent = `Nueva imagen principal: ${mainImageInput.files[0].name}`;
                            changesList.appendChild(listItem);
                            changesMade = true; // Set flag to true if any new upload is found
                        }
                    }

                    // Handle deleted images
                    const deletedImages = [];
                    for (let i = 1; i <= 3; i++) {
                        const checkbox = document.getElementById(`delete-image-${i}`);
                        if (checkbox.checked) {
                            const imageName = checkbox.value ? `img${i}.jpeg` : `Imagen img${i}`;
                            deletedImages.push(`Imagen eliminada: ${imageName}`);
                        }
                    }

                    if (deletedImages.length > 0) {
                        deletedImages.forEach(imgMessage => {
                            const listItem = document.createElement('li');
                            listItem.textContent = imgMessage;
                            changesList.appendChild(listItem);
                            changesMade = true; // Set flag to true if any deletion is found
                        });
                    }

                    // Check for new image uploads
                    for (let i = 1; i <= 3; i++) {
                        const imageInput = document.getElementById(`imagenes-${i}`);
                        const originalImageName = imageInput.dataset
                            .originalName; // Assuming you have this attribute set in HTML
                        if (imageInput.files.length > 0) {
                            if (originalImageName) {
                                const listItem = document.createElement('li');
                                listItem.textContent =
                                    `Reemplazando imagen ${i}: ${originalImageName} con ${imageInput.files[0].name}`;
                                changesList.appendChild(listItem);
                                changesMade = true; // Set flag to true if any new upload is found
                            } else {
                                const listItem = document.createElement('li');
                                listItem.textContent = `Nueva imagen ${i}: ${imageInput.files[0].name}`;
                                changesList.appendChild(listItem);
                                changesMade = true; // Set flag to true if any new upload is found
                            }
                        }
                    }

                    // Handle deleted documents
                    const deletedDocuments = [];
                    for (let i = 1; i <= 2; i++) {
                        const checkbox = document.getElementById(`delete-doc-${i}`);
                        if (checkbox.checked) {
                            const docName = checkbox.value ? `doc${i}.pdf` : `Documento ${i}`;
                            deletedDocuments.push(`Documento eliminado: ${docName}`);
                        }
                    }

                    if (deletedDocuments.length > 0) {
                        deletedDocuments.forEach(docMessage => {
                            const listItem = document.createElement('li');
                            listItem.textContent = docMessage;
                            changesList.appendChild(listItem);
                            changesMade = true; // Set flag to true if any deletion is found
                        });
                    }

                    // Check for new document uploads
                    for (let i = 1; i <= 2; i++) {
                        const docInput = document.getElementById(`documentos-${i}`);
                        const originalDocName = docInput.dataset
                            .originalName; // Assuming you have this attribute set in HTML
                        if (docInput.files.length > 0) {
                            if (originalDocName) {
                                const listItem = document.createElement('li');
                                listItem.textContent =
                                    `Reemplazando documento ${i}: ${originalDocName} con ${docInput.files[0].name}`;
                                changesList.appendChild(listItem);
                                changesMade = true; // Set flag to true if any new upload is found
                            } else {
                                const listItem = document.createElement('li');
                                listItem.textContent = `Nuevo documento ${i}: ${docInput.files[0].name}`;
                                changesList.appendChild(listItem);
                                changesMade = true; // Set flag to true if any new upload is found
                            }
                        }
                    }

                    // Display "No se han realizado cambios" if no changes were made
                    if (!changesMade) {
                        const noChangesItem = document.createElement('li');
                        noChangesItem.textContent = "No se han realizado cambios EN EL AREA DE ADJUNTOS.";
                        changesList.appendChild(noChangesItem);
                    }
                });

            document.getElementById('confirm-submit').addEventListener('click', function() {
                // Close the modal before submitting the form

                const modalElement = document.getElementById('confirmationModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide(); // Close the modal

                document.getElementById('product-edit').submit(); // Submit the form after closing the modal
            });
        });
    </script>
@endsection
