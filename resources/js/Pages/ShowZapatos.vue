<template>
    <Navbar />
    <div class="min-h-screen flex flex-col">
        <main class="container mx-auto px-4 flex-grow" role="main">
            <h1 class="text-xl md:text-2xl font-bold mb-4 mt-6 text-center" role="heading" aria-level="1">
                Detalles de {{ zapatos.name }}
            </h1>
            
            <!-- Tabla Responsive -->
            <div class="overflow-x-auto p-4 bg-white rounded shadow mb-8">
                <table class="w-full min-w-[800px]" aria-label="Información detallada del zapato">
                    <tbody>
                        <tr class="bg-gray-200 text-left">
                            <th class="p-2 border" scope="col">ID</th>
                            <th class="p-2 border" scope="col">Nombre</th>
                            <th class="p-2 border" scope="col">Descripción</th>
                            <th class="p-2 border" scope="col">Número</th>
                            <th class="p-2 border" scope="col">Categoría</th>
                            <th class="p-2 border" scope="col">Foto</th>
                        </tr>

                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-2 border">{{ zapatos.id }}</td>
                            <td class="p-2 border">{{ zapatos.name }}</td>
                            <td class="p-2 border">{{ zapatos.description }}</td>
                            <td class="p-2 border">{{ zapatos.number }}</td>
                            <td class="p-2 border">
                                {{ zapatos.category?.name || 'Sin categoría' }}
                            </td>
                            <td class="p-2 border">
                                <img
                                    v-if="zapatos.photo"
                                    :src="getImageUrl(zapatos.photo)"
                                    :alt="`Imagen de ${zapatos.name}`"
                                    class="w-32 h-32 object-cover rounded"
                                />
                                <span v-else>No hay imagen</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="text-center mb-8">
                <Link 
                    :href="route('zapatos.index')" 
                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded transition duration-200"
                    role="button"
                    aria-label="Volver a la lista de zapatos"
                >
                    Volver
                </Link>
            </div>
        </main>
        <Footer />
    </div>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    zapatos: Object,
});

// Helper para convertir ruta de foto en URL pública
const getImageUrl = path => `/storage/${path}`;
</script>