<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title') </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (inclut Popper) -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery + SweetAlert -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- lien select 2 --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <link rel="stylesheet" href="https://unpkg.com/@adminkit/core@latest/dist/css/app.css">
    <script src="https://unpkg.com/@adminkit/core@latest/dist/js/app.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <!-- Dans la section <head> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.css"
        integrity="sha512-WzvUWVv7qb5i8rGy0kx4YyDJo5ddTVK8+o/yoP1R+4/2vG8UGbZ7bJQLr0j3Z7U4s/z0nzjBhQXoSz9vQH6Vg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    @yield('style')


    <style>
        /* Style pour le modal */
        #createAppModal .modal-content {
            border-radius: 12px;
            overflow: hidden;
        }

        #createAppModal .form-label {
            font-weight: 500;
            color: #495057;
        }

        #createAppModal .bi {
            font-size: 1.1em;
        }

        /* Animation d'ouverture */
        .modal.fade .modal-dialog {
            transform: translateY(-50px);
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: none;
        }
    </style>



</head>

<body>

    <div class="wrapper">
        @include('layouts.Partials.sidebar')
        <div class="main">

            @include('layouts.Partials.header')
            @include('layouts.Partials.header-bg')


            <main class="content">

                @yield('content')

            </main>

            @include('layouts.Partials.footer')

        </div>
    </div>

    <script src="js/app.js"></script>
    @yield('script')


    <!-- Avant la fermeture du </body> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.10.1/sweetalert2.min.js"
        integrity="sha512-oGPdYZUvNyDCQh0iiS1m6hXB8ZfpjI8hKZdLVJVJZJzJLjn5q0/+qF6mNYWrF8PdQy3vZDUe6nqvlbV5kY6+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>
