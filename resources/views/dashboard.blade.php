<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container px-6 py-10 min-h-screen flex justify-center items-center">
        <div class="md:px-4 md:grid md:grid-cols-2 lg:grid-cols-3 gap-5 space-y-4 md:space-y-0">
            @forelse ($unidades_educativas as $item)
            <div class="max-w-sm bg-white px-6 pt-6 pb-2 rounded-xl shadow-lg transform hover:scale-105 transition duration-500">
                <h3 class="mb-3 text-xl font-bold text-indigo-600">{{$item->nombre}}</h3>
                <div class="relative">
                    <img class="w-full rounded-xl" src="https://coolfunbox.com/wp-content/uploads/2016/12/colegio.png" alt="Colors" />
                    <p class="absolute top-0 right-0 bg-yellow-300 text-gray-800 font-semibold py-1 px-3 rounded-tr-lg rounded-bl-lg">Cursos: {{$item->cursos_count}}</p>
                </div>
                <h1 class="mt-4 text-gray-800 text-2xl font-bold cursor-pointer">{{$item->codigo_sie}}</h1>
                <div class="my-4">

                <div class="flex space-x-1 items-center">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-6 w-6 text-indigo-600 mb-1.5" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24"/>
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#4f46e5" fill-rule="nonzero" opacity="0.3"/>
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#4f46e5" fill-rule="nonzero"/>
                            </g>
                        </svg><!--end::Svg Icon-->
                    </span>
                    <p><b>Director: </b>{{$item->director}}</p>
                </div>
                <div class="flex space-x-1 items-center">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-6 w-6 text-indigo-600 mb-1.5" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M5.5,2 L18.5,2 C19.3284271,2 20,2.67157288 20,3.5 L20,6.5 C20,7.32842712 19.3284271,8 18.5,8 L5.5,8 C4.67157288,8 4,7.32842712 4,6.5 L4,3.5 C4,2.67157288 4.67157288,2 5.5,2 Z M11,4 C10.4477153,4 10,4.44771525 10,5 C10,5.55228475 10.4477153,6 11,6 L13,6 C13.5522847,6 14,5.55228475 14,5 C14,4.44771525 13.5522847,4 13,4 L11,4 Z" fill="#4f46e5" opacity="0.3"/>
                                <path d="M5.5,9 L18.5,9 C19.3284271,9 20,9.67157288 20,10.5 L20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 L4,10.5 C4,9.67157288 4.67157288,9 5.5,9 Z M11,11 C10.4477153,11 10,11.4477153 10,12 C10,12.5522847 10.4477153,13 11,13 L13,13 C13.5522847,13 14,12.5522847 14,12 C14,11.4477153 13.5522847,11 13,11 L11,11 Z M5.5,16 L18.5,16 C19.3284271,16 20,16.6715729 20,17.5 L20,20.5 C20,21.3284271 19.3284271,22 18.5,22 L5.5,22 C4.67157288,22 4,21.3284271 4,20.5 L4,17.5 C4,16.6715729 4.67157288,16 5.5,16 Z M11,18 C10.4477153,18 10,18.4477153 10,19 C10,19.5522847 10.4477153,20 11,20 L13,20 C13.5522847,20 14,19.5522847 14,19 C14,18.4477153 13.5522847,18 13,18 L11,18 Z" fill="#4f46e5"/>
                            </g>
                        </svg>
                    </span>
                    <p><b>Sistema: </b>{{$item->sistema}}</p>
                </div>
                <div class="flex space-x-1 items-center">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="h-6 w-6 text-indigo-600 mb-1.5" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M12,22 C7.02943725,22 3,17.9705627 3,13 C3,8.02943725 7.02943725,4 12,4 C16.9705627,4 21,8.02943725 21,13 C21,17.9705627 16.9705627,22 12,22 Z" fill="#4f46e5" opacity="0.3"/>
                                <path d="M11.9630156,7.5 L12.0475062,7.5 C12.3043819,7.5 12.5194647,7.69464724 12.5450248,7.95024814 L13,12.5 L16.2480695,14.3560397 C16.403857,14.4450611 16.5,14.6107328 16.5,14.7901613 L16.5,15 C16.5,15.2109164 16.3290185,15.3818979 16.1181021,15.3818979 C16.0841582,15.3818979 16.0503659,15.3773725 16.0176181,15.3684413 L11.3986612,14.1087258 C11.1672824,14.0456225 11.0132986,13.8271186 11.0316926,13.5879956 L11.4644883,7.96165175 C11.4845267,7.70115317 11.7017474,7.5 11.9630156,7.5 Z" fill="#4f46e5"/>
                            </g>
                        </svg>
                    </span>
                    <p>1:34:23 Minutes</p>
                </div>
                <Link href="#refund-info-{{$item->id}}">
                    <button class="mt-4 text-xl w-full text-white bg-indigo-600 py-2 rounded-xl shadow-lg">Materias</button>
                </Link>
                </div>
            </div>
            <x-splade-modal name="refund-info-{{$item->id}}">
                <ul class='py-6 px-3 flex flex-col gap-3'>
                    @forelse ($item->materias as $materia)
                    <Link href="/evaluaciones/{{$materia->id}}" class="font-bold text-amber-500">
                        <li class='cursor-pointer bg-green-500 p-3 rounded-md hover:opacity-80 text-white'>{{$materia->nombre}}</li>
                    </Link>
                    @empty
                    <li class='cursor-pointer bg-slate-600 p-3 rounded-md hover:opacity-90 text-white'>
                        <li class="p-3">No tiene materias registradas</li>
                        <Link href="/unidad_educativa/{{$item->id}}/materia/create" class="font-bold text-amber-500">
                            <li class='cursor-pointer bg-blue-500 p-3 rounded-md hover:opacity-80 text-white'>Registrar</li>
                        </Link>
                    </li>
                    @endforelse
                </ul>
            </x-splade-modal>
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


