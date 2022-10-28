<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.8.23/themes/base/jquery-ui.css">
        <style>
            .ui-autocomplete-loading {
                background: white url("{{ asset('img/ui-anim_basic_16x16.gif') }}") right center no-repeat;
            }

            .ui-front {
                z-index: 1050;
            }

            .ui-autocomplete {
                max-height: 200px;
                overflow-y: auto;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
            }

            /* IE 6 doesn't support max-height
             * we use height instead, but this forces the menu to always be this tall
             */
            * html .ui-autocomplete {
                height: 200px;
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        <livewire:styles />
    </head>
    <body>
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200 font-roboto">
            @include('layouts.navigation')

            <div class="flex overflow-hidden flex-col flex-1">
                @include('layouts.header')

                <main class="overflow-y-auto overflow-x-hidden flex-1 bg-gray-200">
                    <div class="container px-6 py-8 mx-auto">
                        @if (isset($header))
                            <h3 class="mb-4 text-3xl font-medium text-gray-700">
                                {{ $header }}
                            </h3>
                        @endif

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.8.23/jquery-ui.min.js"></script>
        <script src="{{ asset('js/datepicker-bg.js') }}"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
          const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 5000,
            timerProgressBar: true,
            didOpen: toast => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          });

          window.addEventListener('swal:toast', ({detail: {type, message}}) => {
            Toast.fire({
              icon: type,
              title: message
            })
          })

          window.addEventListener('swal:toast2', function (event) {
            Swal.fire({
              //position: 'top-end',
              icon: event.detail.type, //'success', 'error', 'warning',
              title: event.detail.title,
              showConfirmButton: false,
              timer: 1500
            })
          })

          window.addEventListener('swal:success', function (event) {
            Swal.fire({
              title: event.detail.title,
              text: event.detail.text,
              icon: 'success',
            })
          })

          window.addEventListener('swal:error', function (event) {
            Swal.fire({
              title: event.detail.title,
              html: event.detail.text,
              icon: event.detail.type,
            })
          })

          window.addEventListener('swal:confirm', function (event) {
            const swalWithBootstrapButtons = Swal.mixin({
              customClass: {
                confirmButton: 'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm',
                cancelButton: 'mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm'
              },
              buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
              title: event.detail.title,
              text: event.detail.text,
              icon: event.detail.type,
              showCancelButton: true,
              confirmButtonText: event.detail.confirm_btn_text || 'Да, изтрий!',
              cancelButtonText: 'Затвори',
              reverseButtons: true
            })
              .then(function (result) {
                if (result.isConfirmed) {
                  window.livewire.emit(event.detail.listener, event.detail.id)
                }
              })
          })
        </script>

        @stack('scripts')
        <livewire:scripts />

        @if (session()->has('message'))
            <script>
              document.addEventListener('livewire:load', function () {
                window.dispatchEvent(new CustomEvent('swal:toast', {detail: {type: 'success', message: '{{ session('message') }}'}}))
              })
            </script>
        @endif
    </body>
</html>
