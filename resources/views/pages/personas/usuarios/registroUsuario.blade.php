@extends('layouts.backend')

@section('css')
    <style>
        #button-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .custom-btn {
            margin-top: 2rem;
            display: inline-block;
            width: 40%;
            height: 55vh;
            text-align: center;
            font-size: 10vh;
            border-radius: 10px;
            transition: transform 0.9s ease, background-color 0.7s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 10%;
            position: relative;
            overflow: hidden;
            background-color: primary;
            /* Base background color */
        }

        .custom-btn i {
            font-size: 6vw;
            margin-bottom: 1rem;
        }

        .custom-btn p {
            font-size: 2.5vw;
        }

        .custom-btn span {
            font-size: 3vw;
        }
    </style>
@endsection

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>

    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-1">Registro de Persona y Usuario</h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">Nuevo registro</h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Usuarios</li>
                        <li class="breadcrumb-item active" aria-current="page">Registro de Usuario nuevo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 d-flex flex-wrap justify-content-center">
            <div id="button-container">
                <button id="fresh-usuario-button" type="button" class="btn custom-btn btn-primary mx-3"
                    onclick="window.location.href='{{ route('personas.usuarios.create.freshUsuario') }}'">
                    <i class="fas fa-user-plus"></i><br>
                    <span>Nuevo Usuario</span>
                    <p style="opacity: 0.6; margin: 0;">Persona no-registrada</p>
                </button>

                <button id="existing-usuario-button" type="button" class="btn custom-btn btn-info mx-3"
                    onclick="window.location.href='{{ route('personas.usuarios.create.existingUsuario') }}'">
                    <i class="fas fa-address-card"></i><br>
                    <span>Asignar Usuario</span>
                    <p style="opacity: 0.6; margin: 0;">Persona registrada</p>
                </button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.custom-btn');

            buttons.forEach(button => {
                // Store the original background color
                const originalBackgroundColor = window.getComputedStyle(button).backgroundColor;
                const originaltextColor = window.getComputedStyle(button).color;
                button.addEventListener('mouseenter', () => {
                    gsap.to(button, {
                        scale: 1.1,
                        rotation: 2,
                        duration: 0.3,
                        backgroundColor: '#4CAF50',
                        color: '#fff', // Change text color
                        boxShadow: '0 8px 16px rgba(0, 0, 0, 0.3)',
                        ease: 'back.in'
                    });
                });

                button.addEventListener('mouseleave', () => {
                    gsap.to(button, {
                        scale: 1,
                        rotation: 0,
                        duration: 0.3,
                        backgroundColor: originalBackgroundColor, // Use the stored original color
                        color: originaltextColor, // Use the stored original colo
                        boxShadow: '0 4px 8px rgba(0, 0, 0, 0.2)',
                        ease: 'power2.out'
                    });
                });
            });
        });
    </script>
@endsection
