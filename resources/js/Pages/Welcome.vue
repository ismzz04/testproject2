<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import axios from 'axios';
import Navbar from '@/Components/NavBar.vue';

const props = defineProps({
    events: {
        type: Array,
        required: true,
    },
});



function deletevent (id){
    router.delete(route('events.destroy',id))
}

</script>

<template>
    <Head title="Welcome" />
    <Navbar />

    <div class="bg-gray-50 text-black/50  dark:text-white/50">
        <div class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#252850] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">

                <!-- Botón para ir a crear un nuevo evento -->
                <Link
                    href="/events/create"
                    class="inline-flex items-center justify-center mb-4 rounded-md border border-transparent bg-[#252850] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#FF2D20]/80 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20] focus-visible:ring-offset-2"
                >
                    Crear Nuevo Evento
                </Link>

                <!-- Tabla para mostrar eventos -->
                <h2 class="mt-10 text-xl font-bold text-black">Eventos</h2>
                <table class="min-w-full mt-4 border border-gray-300 bg-white shadow-md rounded-lg">
                    <thead class="bg-[#252850] text-white">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Título</th>
                            <th class="border border-gray-300 px-4 py-2">Descripción</th>
                            <th class="border border-gray-300 px-4 py-2">Fecha de Creación</th>
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="event in events" :key="event.id" class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2 text-black">{{ event.title }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-black">{{ event.description }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-black">{{ event.created_at }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                <Link
                                    :href="route('events.edit', event.id)"
                                    class="text-blue-500 hover:underline"
                                >
                                    Editar
                                </Link>
                                <button @click="deletevent(event.id)" class="text-red-500 hover:underline">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>
body {
    background-color: #f5f5f5;
}
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 12px;
}

th {
    background-color: #252850; /* Color de fondo para el encabezado */
    color: white; /* Color del texto en el encabezado */
}

tbody tr:hover {
    background-color: #f5f5f5; /* Color de fondo al pasar el mouse */
}
</style>