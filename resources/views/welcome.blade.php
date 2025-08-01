@extends('layouts.app')

@section('title')
    Inicio
@endsection

@section('contenido')
    <div id="inicio" class="relative w-full max-w-4xl mx-auto mb-20">
        <img class="w-full h-auto rounded-xl overflow-hidden" src="img/home-pool.jpg" alt="Imagen de Piscina">
        <div class="absolute inset-7 justify-center py-65">
            <h2 class="text-white font-extrabold text-4xl">Bienvenido a Natación</h2>
            <p class="text-white text-2xs mt-2.5">Las mejores clases de natación con instructores certificados.</p>
            <div class="mt-8">
                <a href="/login" class="bg-sky-500 px-3 py-4 mt-2.5 rounded-md text-white cursor-pointer hover:bg-gray-50 hover:text-sky-500 transition-colors duration-300 dark:bg-white font-bold dark:text-sky-600 dark:hover:bg-sky-500 dark:hover:text-white">Iniciar Sesión</a>
            </div>
        </div>
    </div>
    
    <!-- Sección Clases -->
    <section id="clases" class="bg-gray-100 dark:bg-gray-300 p-10 mx-auto mt-10 w-full min-h-screen pt-30 transition-all duration-800">
        <div class="container mx-auto">
            <div class="columns-2 gap-10">
                <img class="w-full rounded-xl" src="img/section-1.jpg" alt="Imagen de Piscina">
                <h2 class="text-3xl flex justify-center mb-10 text-gray-800 font-bold dark:text-black uppercase">Nuestras Clases</h2>
                <div class="text-gray-800 dark:text-black text-justify leading-relaxed space-y-4">
                    <p> 
                        En <span class="font-extrabold">SquashPlash</span> ofrecemos clases de natación diseñadas para todas las edades y niveles, desde principiantes hasta nadadores avanzados. Nuestros instructores certificados brindan una atención personalizada, fomentando la seguridad, la técnica y el amor por el agua en un ambiente divertido y profesional.
                    </p>
                    <p>
                        Ya sea que busques aprender desde cero, perfeccionar tu estilo o prepararte para competencias, tenemos el plan perfecto para ti. No esperes más y empieza hoy mismo a vencer el agua.
                    </p>
                    <p>
                        Contamos con programas adaptados para niños, adolescentes y adultos, en horarios flexibles que se ajustan a tu rutina. Cada clase está diseñada para lograr progresos reales, paso a paso, respetando tu ritmo y objetivos personales.
                    </p>
                    <p>
                        En SquashPlash no solo enseñamos a nadar, enseñamos a confiar en ti mismo dentro y fuera del agua. Atrévete a descubrir lo que eres capaz de lograr. Tu transformación empieza aquí.
                    </p>
                </div>
            </div>
        </div>
    </section><!-- Fin Sección Clases -->

    <!-- Sección Instructores -->
    <section id="instructores" class="bg-gray-100 dark:bg-neutral-700 p-10 mx-auto mt-auto w-full min-h-screen pt-30 transition-all duration-800">
        <div class="container mx-auto">
            <div class="columns-2 gap-10">
                <h2 class="text-3xl flex justify-center mb-10 text-gray-700 font-bold dark:text-indigo-50 uppercase">Instructores Certificados</h2>
                <div class="text-gray-800 dark:text-neutral-50 text-justify leading-relaxed space-y-4">
                    <p>
                        Nos enorgullece contar con un equipo de instructores altamente capacitados y certificados, comprometidos con brindar una experiencia de aprendizaje segura, divertida y efectiva para cada alumno.
                    </p>
                    <p>
                        Nuestros profesionales no solo dominan las técnicas de natación, sino que también poseen formación en pedagogía, primeros auxilios y trabajo con personas de todas las edades. Gracias a esto, pueden adaptar cada clase a las necesidades específicas de niños, adolescentes y adultos.
                    </p>
                    <p>
                        La cercanía, el respeto y la motivación constante son pilares en cada sesión. Nuestro objetivo es que te sientas acompañado, guiado y retado a superarte en cada clase.
                    </p>
                    <p>
                        Si buscas aprender con los mejores, en un entorno controlado, profesional y lleno de energía positiva, nuestros instructores están listos para ayudarte a cumplir tus metas acuáticas.
                    </p>
                    <img class="rounded-xl rotate-5" src="img/section-2.jpg" alt="Imagen de Piscina">
                </div>
            </div>
        </div>
    </section> <!-- Fin Sección Instructores -->

    <!-- Sección Costos -->
    <section id="costos" class="bg-gray-100 dark:bg-neutral-800 p-10 mx-auto mt-auto w-full min-h-screen pt-10 transition-all duration-800">
        <div class="px-10 py-10">
            <h2 class="text-3xl text-center font-bold text-gray-800 dark:text-white uppercase mb-10">Paquetes Para Toda La Familia</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                <!-- Paquete 1: Niños -->
                <div class="overflow-hidden rounded-2xl shadow-md hover:shadow-amber-300 dark:bg-gray-100 dark:shadow-xl dark:hover:shadow-amber-300 dark:transition-all dark:duration-300">
                    <img class="w-full h-64 hover:scale-105 transition-transform duration-300" src="img/kid-swim.jpg" alt="Niños nadando">
                    <div class="px-6 py-8">
                        <h3 class="text-lg font-semibold text-neutral-900">Paquete Niños</h3>
                        <p class="text-gray-600 text-sm mt-2 text-justify leading-relaxed space-y-4">Clases divertidas y seguras para los más pequeños de la familia. Ayúdalos a desarrollarse en un ambiente seguro de la mano con profesionales.</p>
                        <p class="text-gray-600 text-sm mt-2 mb-10 text-justify leading-relaxed space-y-4">Edad Recomendada: 4 a 12 años.</p>
                        <a href="#" class="bg-neutral-100 text-amber-400 hover:bg-amber-400 hover:text-neutral-100 font-bold px-4 py-3 rounded-md text-sm transition-colors duration-700">Más Información</a>
                    </div>
                </div>

                <!-- Paquete 2: Adolescentes -->
                <div class="overflow-hidden rounded-2xl shadow-md hover:shadow-amber-300 dark:bg-gray-100 dark:shadow-xl dark:hover:shadow-amber-300 dark:transition-all dark:duration-300">
                    <img class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300" src="img/teenager-swim.jpg" alt="Adolescentes nadando">
                    <div class="px-6 py-8">
                            <h3 class="text-lg font-semibold">Paquete Adolescentes</h3>
                            <p class="text-gray-600 text-sm mt-2 text-justify leading-relaxed space-y-4">Entrenamiento enfocado en mejorar la técnica, la resistencia y la confianza en el agua, con un enfoque recreativo y competitivo.</p>
                            <p class="text-gray-600 text-sm mt-2 mb-10 text-justify leading-relaxed space-y-4">Edad Recomendada: 13 a 17 años</p>
                            <a href="#" class="bg-neutral-100 text-amber-400 hover:bg-amber-400 hover:text-neutral-100 font-bold px-4 py-3 rounded-md text-sm transition-colors duration-700">Más Información</a>
                    </div>
                </div>

                <!-- Paquete 3: Adultos -->
                <div class="overflow-hidden rounded-2xl shadow-md hover:shadow-amber-300 dark:bg-gray-100 dark:shadow-xl dark:hover:shadow-amber-300 dark:transition-all dark:duration-300">
                    <img class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300" src="img/adult-swim.jpg" alt="Adultos nadando">
                    <div class="px-6 py-8">
                            <h3 class="text-lg font-semibold">Paquete Adultos</h3>
                            <p class="text-gray-600 text-sm mt-2 text-justify leading-relaxed space-y-4">Clases adaptadas a todos los niveles, desde principiantes hasta nadadores avanzados. Mejora tu salud, condición física y técnica en un ambiente relajado.</p>
                            <p class="text-gray-600 text-sm mt-2 mb-10 text-justify leading-relaxed space-y-4">Edad Recomendada: 18 años en adelante.</p>
                            <a href="#" class="bg-neutral-100 text-amber-400 hover:bg-amber-400 hover:text-neutral-100 font-bold px-4 py-3 rounded-md text-sm transition-colors duration-700">Más Información</a>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- Fin Sección Costos -->

    <!-- Sección Contácto mt-15 mb-15-->
    <section id="contacto" class="bg-gray-100 dark:bg-sky-950 py-20 px-30">
        <div class="max-w-xl mx-auto px-10 py-15 bg-white rounded-2xl shadow-lg dark:bg-gray-900">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-6 uppercase">Contáctanos</h2>

            <form class="space-y-6">
                <!-- Nombre -->
                    <label 
                        for="nombre" 
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nombre completo</label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        required placeholder="Tu nombre completo"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-400 focus:border-sky-400 dark:bg-gray-800 dark:text-white dark:border-gray-600" 
                    />

                <!-- Teléfono -->
                    <label 
                        for="telefono" 
                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">Teléfono</label>
                    <input 
                        type="tel" 
                        id="telefono" 
                        name="telefono" 
                        placeholder="(55) 1234 5678"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-400 focus:border-sky-400 dark:bg-gray-800 dark:text-white dark:border-gray-600"
                    />
            
                <!-- Correo -->
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Correo electrónico</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required placeholder="correo@ejemplo.com"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-400 focus:border-sky-400 dark:bg-gray-800 dark:text-white dark:border-gray-600" 
                    />
                
                <!-- Asunto (opcional) -->
                    <label for="asunto" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Asunto</label>
                    <select 
                        id="asunto" 
                        name="asunto"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-400 focus:border-sky-400 dark:bg-gray-800 dark:text-white dark:border-gray-600">
                        <option value="" disabled selected>--Selecciona una opción--</option>
                        <option value="informacion">Solicitar información</option>
                        <option value="inscripcion">Inscripción a clases</option>
                        <option value="comentario">Comentario o sugerencia</option>
                    </select>
            
                <!-- Mensaje -->
                <label for="mensaje" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Mensaje</label>
                <textarea 
                    id="mensaje" 
                    name="mensaje" rows="4" 
                    required placeholder="Escribe tu mensaje aquí..."
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-sky-400 focus:border-sky-400 dark:bg-gray-800 dark:text-white dark:border-gray-600">
                </textarea>
                
                <!-- Botón -->
                <div class="text-center">
                <button 
                    type="submit"
                    class="w-full sm:w-auto bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-6 rounded-md shadow-lg transition-colors duration-300 cursor-pointer">
                    Enviar mensaje
                </button>
                </div>
            </form>
        </div> 
    </section><!-- Fin Sección Contácto -->

    
@endsection
