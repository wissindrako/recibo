<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container px-6 py-10 mx-auto">
        <div class="grid grid-cols-1 gap-8 mt-8 md:mt-16 md:grid-cols-2">
            @forelse ($unidades_educativas as $item)
            <div class="p-4 items-center justify-center max-w-md mx-auto sm:max-w-xl rounded-xl group sm:flex space-x-6 bg-white bg-opacity-50 shadow-xl hover:rounded-2xl">
                <img  class="mx-auto w-full block w-2/5 md:w-3/12 h-35 sm:40 rounded-lg"  alt="art cover" loading="lazy" src='https://coolfunbox.com/wp-content/uploads/2016/12/colegio.png' />
                <div class="max-w-md md:w-9/12 pl-0 p-5">
                    <div class="space-y-2">
                        <div class="space-y-4">
                            <h4 class="text-md font-semibold text-cyan-900 text-justify">
                                <b>UE: </b>{{$item->nombre}}
                            </h4>
                        </div>
                        <div class="space-y-4">
                            <h5 class="text-sm font-semibold text-cyan-900 text-justify">
                                {{$item->codigo_sie}}
                            </h5>
                        </div>
                        <div class="flex items-center space-x-4 justify-between">
                            <div class="flex gap-3 space-y-1">
                                <img  src="https://sworld.co.uk/img/img/users/984/images/profile/profile_256x256.jpg"  class="rounded-full h-8 w-8" />
                                <span class="text-md"><b>Docente: </b>{{$item->usuario->name}}</span>
                            </div>
                            <div class=" px-3 py-1 rounded-lg flex space-x-2 flex-row">
                                <div class="text-center text-md justify-center items-center flex">
                                    <span class="text-md mx-1"><b>Sistema: </b>{{$item->sistema}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 justify-between">
                            <div class="flex flex-row space-x-1">
                                <div class='relative'>
                                    <button class="bg-sky-500 shadow-lg shadow- shadow-sky-600 text-white cursor-pointer px-3 py-1 text-center justify-center items-center rounded-xl flex space-x-2 flex-row peer transition-all duration-200  ">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <polygon fill="#fff" opacity="0.3" points="6 3 18 3 20 6.5 4 6.5"/>
                                                <path d="M6,5 L18,5 C19.1045695,5 20,5.8954305 20,7 L20,19 C20,20.1045695 19.1045695,21 18,21 L6,21 C4.8954305,21 4,20.1045695 4,19 L4,7 C4,5.8954305 4.8954305,5 6,5 Z M9,9 C8.44771525,9 8,9.44771525 8,10 C8,10.5522847 8.44771525,11 9,11 L15,11 C15.5522847,11 16,10.5522847 16,10 C16,9.44771525 15.5522847,9 15,9 L9,9 Z" fill="#fff"/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                        Cursos: <b>{{$item->cursos_count}}</b>
                                    </button>
                                    <div class=' w-80 absolute top-5 z-10
                                    after:content-[""] after:inline-block after:absolute after:top-0 after:bg-white/40
                                    after:w-full after:h-full after:-z-20 after:blur-[2px] after:rounded-lg
                                peer-focus:top-12 peer-focus:opacity-100 peer-focus:visible
                                transition-all duration-300 invisible  opacity-0
                                '>
                                        <ul class='py-6 px-3 flex flex-col gap-3'>
                                            @forelse ($item->cursos as $curso)
                                            <li class='cursor-pointer bg-sky-500 p-3 rounded-md hover:opacity-80 text-white'>{{$curso->descripcion}}</li>
                                            @empty
                                            <li class='cursor-pointer bg-slate-600 p-3 rounded-md hover:opacity-90 text-white'>No tiene cursos registrados</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class='relative'>
                                    <button class="bg-green-500 shadow-lg shadow- shadow-green-600 text-white cursor-pointer px-3 text-center justify-center items-center py-1 rounded-xl flex space-x-2 flex-row peer transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <polygon fill="#fff" opacity="0.3" points="6 3 18 3 20 6.5 4 6.5"/>
                                                <path d="M6,5 L18,5 C19.1045695,5 20,5.8954305 20,7 L20,19 C20,20.1045695 19.1045695,21 18,21 L6,21 C4.8954305,21 4,20.1045695 4,19 L4,7 C4,5.8954305 4.8954305,5 6,5 Z M9,9 C8.44771525,9 8,9.44771525 8,10 C8,10.5522847 8.44771525,11 9,11 L15,11 C15.5522847,11 16,10.5522847 16,10 C16,9.44771525 15.5522847,9 15,9 L9,9 Z" fill="#fff"/>
                                            </g>
                                        </svg><!--end::Svg Icon-->
                                        Materias: <b>{{$item->materias_count}}</b>
                                    </button>
                                    <div class=' w-80 absolute top-5 z-10
                                    after:content-[""] after:inline-block after:absolute after:top-0 after:bg-white/40
                                    after:w-full after:h-full after:-z-20 after:blur-[2px] after:rounded-lg
                                peer-focus:top-12 peer-focus:opacity-100 peer-focus:visible
                                transition-all duration-300 invisible opacity-0
                                '>
                                        <ul class='py-6 px-3 flex flex-col gap-3'>
                                            @forelse ($item->materias as $materia)
                                            {{-- <Link href="/evaluaciones/materia/{{$materia->id}}/periodo/2" class="font-bold text-amber-500"> --}}
                                            <Link href="/evaluaciones/{{$materia->id}}" class="font-bold text-amber-500">
                                                <li class='cursor-pointer bg-green-500 p-3 rounded-md hover:opacity-80 text-white'>{{$materia->nombre}}</li>
                                            </Link>

                                            @empty
                                            <li class='cursor-pointer bg-slate-600 p-3 rounded-md hover:opacity-90 text-white'>No tiene materias registradas</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 justify-between">
                            <div class="text-grey-500 flex flex-row space-x-1  my-4">
                                <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-xs">2 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <span class="text-slate-700">No hay registro aún...
                    <Link href="/unidad_educativa/create" class="font-bold text-green-500">
                        Agregar Institución Educativa (+)
                    </Link>
                </span>
            @endforelse

        </div>
    </div>

</x-app-layout>
