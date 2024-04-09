
<div class="flex flex-col bg-white">
    <div class=" justify-center items-center flex w-full">
        <div class=" py-6 w-2/4">
            <div class=" flex flex-row text-lg gap-0.5 border border-gray-400  rounded-lg shadow-md shadow-gray-400">
                <div class="relative flex w-5/12">
                    <span class="absolute left-5 top-5 flex items-center">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="search" placeholder="Título del empleo, palabras clave o empresa"
                        class="w-full pl-14 rounded-l-lg py-4 border-none outline-none   text-ellipsis">
                </div>
                <div class="flex justify-center items-center">
                    <span class="border-e h-8  border-gray-400"></span>
                </div>
                <div class="relative flex w-5/12">
                    <span class="absolute left-5 top-5 flex items-center">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <input type="search" placeholder="Ciudad, región, código postal o trabajo remoto"
                        class="w-full pl-14 rounded-r-lg py-4 border-none outline-none text-ellipsis">
                </div>
                <div class="my-2 mx-1 w-2/12 justify-center items-center flex">
                    <button class="px-6 py-3 bg-[#164081] text-sm font-bold text-white rounded-md">Buscar
                        empleos</button>
                </div>

            </div>
        </div>
    </div>
    <div class="flex justify-center items-center">
        <div class="flex flex-row text-lg gap-0.5 pb-8">
            <a href="" class="font-bold text-blue-800">Publica tu CV -</a>
            <h1>Postúlate a empleos fácilmente</h1>
        </div>
    </div>
    <div class="font-bold flex justify-center items-center border-b border-gray-400">
        <div class="flex flex-row">
            <a href="" class="px-20 border-b-4 border-blue-700 hover:border-black">Feed de empleo</a>
            <a href="" class="px-20 border-b border-transparent hover:border-black">Búsquedas recientes</a>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            <div class="flex flex-col gap-2">
                @foreach ($ofertas as $item)
                <a href="{{ route('inicio', ['idDeseado' => $item->id]) }}"
                        class="scale-100 p-6 bg-white border-2 from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-blue-500 flex-col">
                        <div class="flex justify-between">
                            <div class="flex flex-row gap-2">
                                <div class="flex justify-center items-center">
                                    <span
                                        class="bg-gray-200 rounded-md px-2 py-1 text-gray-600 text-sm font-bold ">nuevo
                                        empleo</span>
                                </div>
                                <div class="flex justify-center items-center">
                                    <span
                                        class="bg-gray-200 rounded-md px-2 py-1 text-gray-600 text-sm font-bold ">nuevo
                                        empleo</span>
                                </div>
                            </div>
                            <div class="flex justify-center items-center">
                                <span
                                    class="text-xl text-gray-600 px-4 py-2 flex justify-center items-center bg-transparent hover:bg-gray-200 hover:rounded-md hover:text-black ">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>

                                </span>
                            </div>
                        </div>
                        <h2 class="mt-6 text-xl font-semibold text-gray-900">ASESOR (A) DE VENTAS PART TIME - REAL PLAZA
                            CUSCO</h2>
                        <div class="flex fle-row justify-start items-center pt-2 gap-2">
                            <span class="flex justify-start items-center text-sm ">Be Smart</span>
                            <samp class="font-bold text-sm ">5.0<i class="fa-solid fa-star fa-xs "></i></samp>
                        </div>
                        <span class="flex justify-start items-center text-sm ">Lima, Lima </span>
                        <div class="flex fle-row gap-2 justify-start items-center pt-2">
                            <div class="flex fle-row gap-2 font-bold bg-green-200 rounded-md py-1 px-2">
                                <span class="flex justify-start items-center text-sm ">S/.2,300 - S/.2,300 al mes</span>
                                <samp><i class="fa-solid fa-heart"></i></samp>
                            </div>
                            <div class="flex fle-row gap-2 font-bold bg-gray-200 rounded-md py-1 px-2">
                                <span class="flex justify-start items-center text-sm ">Tiempo completo</span>
                            </div>
                        </div>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="py-5">
                                        <div class="flex flex-row gap-1">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" focusable="false" role="img"
                                                    fill="#2557A7" viewBox="0 0 24 24" aria-hidden="true"
                                                    class="w-6 h-6">
                                                    <path
                                                        d="M2.344 4.018a.25.25 0 00-.33.31l1.897 5.895a.5.5 0 00.371.335l7.72 1.44-7.72 1.44a.5.5 0 00-.371.335l-1.898 5.896a.25.25 0 00.33.31l19.494-7.749a.25.25 0 000-.464L2.344 4.018z">
                                                    </path>
                                                </svg>
                                            </span>
                                            <span>Postulación vía Indeed</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pb-5 text-gray-500">
                                        <ul class="list-disc mt-0 mb-5 pl-5">
                                            <li class="mb-0">Agradecemos a las personas que no cumplan con los
                                                requerimientos
                                                abstenerse de postular, ya que se evaluará el cumplimiento de los
                                                requisitos.
                                            </li>
                                            <li>Se le brinda los equipos y herramientas de trabajo.</li>
                                        </ul>
                                        <span class="text-sm">
                                            Activo hace 2 días
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </a>
                @endforeach
            </div>
            <div class="relative">
                <div class="sticky top-24 z-50">
                    <div
                        class="flex flex-col scale-100 bg-white border-2 from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">

                        @if (isset($detalles))
                        <div class="p-6 w-auto h-auto flex flex-col shadow-md shadow-gray-300">
                            <h2 class="mt-6 text-xl font-semibold text-gray-900">{{ $detalles->titulo }}</h2>

                            <div class="flex fle-row justify-start items-center pt-2 gap-2">
                                <span class="flex justify-start items-center text-sm ">{{ $detalles->empresa->ra_social }}</span>
                                <div class="flex justify-center items-center">
                                    <span class="border-e h-5  border-gray-400"></span>
                                </div>
                                <span class="flex justify-start items-center text-sm ">{{ $detalles->ubicacion }} </span>
                            </div>
                            <div class="flex gap-2 font-bold">
                                <span class="flex justify-start items-center text-sm ">S/.{{ $detalles->remuneracion }} - S/.{{ $detalles->remuneracion }} al
                                    mes</span>
                            </div>
                            <div class="flex flex-row gap-4 py-4">
                                <a href=""
                                    class="rounded-lg py-2 px-4 text-white bg-blue-600 font-bold">Postulate
                                    ahora</a>
                                <a href="" class="rounded-lg py-2 px-4 text-gray-800 bg-gray-300 font-bold"><i
                                        class="fa-regular fa-bookmark"></i></a>

                            </div>
                        </div>
                        <div class="max-h-[34rem] overflow-y-auto">
                            <div class="p-6 w-auto h-auto flex flex-col">
                                <h2 class="mt-6 text-xl font-semibold text-gray-900">Informacion del empleo</h2>
                                <h6 class="text-xs font-bold text-gray-400">Así es como las especificaciones del empleo
                                    se
                                    alinean con tu perfil</h6>
                                <div class="flex fle-row justify-start items-center pt-2 gap-2">
                                    <span class="flex justify-start items-center text-sm ">{{ $detalles->empresa->ra_social }}</span>
                                    <div class="flex justify-center items-center">
                                        <span class="border-e h-5  border-gray-400"></span>
                                    </div>
                                    <span class="flex justify-start items-center text-sm ">{{ $detalles->ubicacion }} </span>
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
                                                class="flex justify-start items-center text-sm bg-gray-200 rounded-md py-1 px-2">S/.{{ $detalles->remuneracion }}
                                                al mes</span>
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
                            <samp class="border-b border-gray-400"></samp>
                            <div class="p-6 w-auto h-auto flex flex-col">
                                <div class="flex flex-col">
                                    <h2 class="mt-6 text-xl font-semibold text-gray-900">Ubicacion</h2>

                                    <div class="flex fle-row justify-start items-center pt-2 gap-2">
                                        <span class="flex justify-start items-center text-sm ">{{ $detalles->ubicacion }}</span>
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
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

