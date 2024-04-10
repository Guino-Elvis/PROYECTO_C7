<div class="flex flex-col bg-white">

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            <div class="flex flex-col gap-2">
                <div>
                    <form action="/grabar_postulacion" method="POST" enctype="multipart/form-data">
                        @csrf

                            <div class="w-full md:w-6/12 px-3 mb-6 md:mb-0">
                                <label >
                                    documento
                                </label>
                                <input type="file" name="documentos" accept=".pdf, .doc, .docx, .txt">
                            </div>
                            <!-- Agrega un identificador al input para que podamos seleccionarlo fácilmente -->
                            <input id="fecha_postulacion" name="fecha_postulacion" type="hidden">
                            <input type="hidden" name="oferta_laboral_id" value="{{ $detalles->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <div class="flex items-end justify-end  py-2">
                                <button type="submit" class="ad m-2">
                                    Guardar
                                </button>
                                <a href="/"class="m-2">Cancelar</a>
                            </div>
                    </form>
                </div>
            </div>
            <div class="relative">
                <div class="sticky top-24 z-50">
                    <div
                        class="flex flex-col scale-100 bg-white border-2 from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div class="p-6 w-auto h-auto flex flex-col shadow-md shadow-gray-300">
                            <h2 class="mt-6 text-xl font-semibold text-gray-900">{{ $detalles->titulo }}</h2>

                            <div class="flex fle-row justify-start items-center pt-2 gap-2">
                                <span
                                    class="flex justify-start items-center text-sm ">{{ $detalles->empresa->ra_social }}</span>
                                <div class="flex justify-center items-center">
                                    <span class="border-e h-5  border-gray-400"></span>
                                </div>
                                <span class="flex justify-start items-center text-sm ">{{ $detalles->ubicacion }}
                                </span>
                                <div class="flex justify-center items-center">
                                    <span class="border-e h-5  border-gray-400"></span>
                                </div>
                                <span class="flex justify-start items-center text-sm ">{{ $detalles->remuneracion }}
                                </span>
                            </div>
                        </div>
                        <div class="max-h-[34rem] overflow-y-auto" id="scrollableDiv">
                            <div class="p-6 w-auto h-auto flex flex-col border-b border-gray-400">
                                <h2 class="mt-6 text-xl font-semibold text-gray-900">Informacion del empleo</h2>
                                <h6 class="text-xs font-bold text-gray-400">Así es como las especificaciones del empleo
                                    se
                                    alinean con tu perfil</h6>
                                <div class="flex fle-row justify-start items-center pt-2 gap-2">
                                    <span
                                        class="flex justify-start items-center text-sm ">{{ $detalles->empresa->ra_social }}</span>
                                    <div class="flex justify-center items-center">
                                        <span class="border-e h-5  border-gray-400"></span>
                                    </div>
                                    <span class="flex justify-start items-center text-sm ">{{ $detalles->ubicacion }}
                                    </span>
                                </div>
                                <div class="flex flex-col gap-6">
                                    <div class="flex flex-row gap-4">
                                        <samp class="flex justify-start items-start"><i
                                                class="fa-solid fa-circle-dollar-to-slot"></i></samp>
                                        <div class="flex flex-col gap-2 font-bold ">
                                            <h2
                                                class=" text-md font-semibold text-gray-900 justify-start items-center flex">
                                                Sueldo</h2>
                                            <span
                                                class="flex justify-start items-center text-sm bg-gray-200 rounded-md py-1 px-2">{{ $detalles->remuneracion }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex flex-row gap-4">
                                        <samp class="flex justify-start items-start"><i
                                                class="fa-solid fa-suitcase"></i></samp>
                                        <div class="flex flex-col gap-2 font-bold ">
                                            <h2
                                                class=" text-md font-semibold text-gray-900 justify-start items-center flex">
                                                Tipo de empleo</h2>
                                            <span
                                                class="flex justify-start items-center text-sm bg-gray-200 rounded-md py-1 px-2">Tiempo
                                                completo</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 w-auto h-auto flex flex-col">
                                <div class="flex flex-col">
                                    <h2 class="mt-6 text-xl font-semibold text-gray-900">Ubicacion</h2>

                                    <div class="flex fle-row justify-start items-center pt-2 gap-2">
                                        <span
                                            class="flex justify-start items-center text-sm ">{{ $detalles->ubicacion }}</span>
                                    </div>
                                </div>
                                <samp class="border-b border-gray-400 py-2"></samp>
                                <div class="flex flex-col">
                                    <h2 class="mt-6 text-xl font-semibold text-gray-900">Descripción completa del
                                        empleo
                                    </h2>

                                    <div class="flex fle-row justify-start items-center pt-2 gap-2">
                                        <p>
                                            {{ $detalles->body }}
                                        </p>
                                    </div>
                                </div>
                                <samp class="border-b border-gray-400 py-2"></samp>
                                <div class="flex flex-col">

                                    <div class="flex fle-row justify-start items-center pt-2 gap-2">
                                        <span
                                            class="gap-2 flex justify-start items-center text-sm bg-gray-300 rounded-md text-black py-2 px-6 font-bold flex-row">
                                            <samp><i class="fa-solid fa-flag"></i></samp>
                                            <h1>Reportar empleo</h1>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Obtener la fecha actual
    var fechaActual = new Date();

    // Obtener el día, mes y año de la fecha actual
    var dia = fechaActual.getDate();
    var mes = fechaActual.getMonth() + 1; // Los meses en JavaScript son indexados desde 0, por lo que se suma 1 al mes
    var anio = fechaActual.getFullYear();

    // Formatear el día y mes para que tengan dos dígitos si es necesario
    if (dia < 10) {
        dia = '0' + dia;
    }
    if (mes < 10) {
        mes = '0' + mes;
    }

    // Crear una cadena de texto con la fecha actual en el formato "YYYY-MM-DD"
    var fechaHoy = anio + '-' + mes + '-' + dia;

    // Establecer la fecha actual como el valor predeterminado del campo de entrada de fecha
    document.getElementById("fecha_postulacion").value = fechaHoy;
    </script>
