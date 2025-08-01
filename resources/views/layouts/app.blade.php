<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SquashPlash | @yield('title')</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>

    {{-- h-[1500px] Para probar el index-z en el nav: Se pone en el Body --}}
    <body class="dark bg-gray-100 dark:bg-sky-950 transition-all duration-800">
        <!-- ===== HEADER: Navegación principal con logo y sticky ===== -->
        <header class="bg-gray-300/75 dark:bg-sky-200/75 backdrop-blur-md p-5 mt-5 border border-black border-hidden dark:border-white mx-115 dark:shadow-xl shadow-inner shadow-black/35 dark:shadow-white/45 rounded-full z-50 top-0 sticky">
            <div class="flex justify-between items-center px-4">
                 <!-- Logotipo posicionado con absolute a la izquierda -->
                
                <h1 class="absolute left-[-300px] top-1/2 -translate-y-1/2 text-3xl">
                    <a class="text-white" href="/"> <span class="text-black dark:text-white font-black">SQUASH</span><span class="text-black dark:text-white font-extralight">PLASH</span></a>
                </h1>

                 <!-- Menú de navegación principal -->
                <nav class="flex gap-5 items-center text-neutral-900 dark:text-white">
                    <a class="uppercase font-black hover:text-white dark:hover:text-cyan-300 text-sm" href="{{ request()->is('/') ? '#inicio' : '/#inicio' }}">Inicio</a>
                    <a class="uppercase font-black hover:text-white dark:hover:text-cyan-300 text-sm" href="{{request()->is('/') ? '#clases' : '/#clases'}}">Clases</a>
                    <a class="uppercase font-black hover:text-white dark:hover:text-cyan-300 text-sm" href="{{request()->is('/') ? '#instructores' : '/#instructores'}}">Instructores</a>
                    <a class="uppercase font-black hover:text-white dark:hover:text-cyan-300 text-sm" href="{{request()->is('/') ? '#costos' : '/#costos'}}">Costos</a>
                    <a class="uppercase font-black hover:text-white dark:hover:text-cyan-300 text-sm" href="{{request()->is('/') ? '#contacto' : '/#contacto'}}">Contacto</a>
                </nav>

                 <!-- Botones de modo Dark y Light usando librería Lucide-->
                <div class="absolute right-[-300px] top-7 -translate-y-1/2">
                    <div class="cursor-pointer">
                        <i data-lucide="Sun" id="light" class="size-8 stroke-gray-100 hidden dark:inline-block"></i>
                        <i data-lucide="Moon" id="dark" class="size-8 stroke-gray-600 inline-block dark:hidden"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido Principal -->
        <main class="mx-auto mt-16"> {{-- max-w-[1800px] px-4 BORRAR --}} 
            @yield('contenido')
        </main>

       <footer class="w-full bg-gray-100 dark:bg-neutral-500 text-neutral-800 dark:text-neutral-200 py-10">
            <div class="container mx-auto text-center">
                <p class="text-sm">&copy; {{now()->year}} SQUASHPLASH.</p>
                <p class="text-sm">Todos los derechos reservados.</p>
                <a class="text-sm text-blue-600 dark:text-cyan-400" href="/privacidad">Aviso de Privacidad</a>
                <p class="text-xs mt-2">Desarrollado por Alan Cid Díaz</p>
            </div>
        </footer>

    </body>
</html>