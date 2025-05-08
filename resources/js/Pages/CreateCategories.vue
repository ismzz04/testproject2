<template>
    <!-- Barra de navegación superior -->
    <Navbar />
    <div class="min-h-screen flex flex-col">
        <main class="container mx-auto px-4 flex-grow" role="main">
            <!-- Título principal de la página -->
            <h1 class="text-xl md:text-2xl font-bold mb-4 mt-6" role="heading" aria-level="1">Crear Categoría</h1>
            <div class="bg-white p-4 border rounded shadow mb-8">
                <!-- Formulario para crear una nueva categoría -->
                <form @submit.prevent="submit" class="max-w-2xl mx-auto" role="form" aria-label="Formulario de creación de categoría">
                    <div class="mb-3">
                        <label for="name" class="block mb-1 font-medium">Nombre de la categoría:</label>
                        <!-- Campo de texto para el nombre de la categoría -->
                        <input
                            type="text"
                            id="name"
                            v-model="form.name"
                            class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required
                            aria-required="true"
                            aria-label="Nombre de la categoría"
                        />
                    </div>
                    <!-- Botones para cancelar o guardar la categoría -->
                    <div class="flex flex-col md:flex-row justify-between mt-4 space-y-2 md:space-y-0 md:space-x-4">
                        <Link 
                            :href="route('categories.index')" 
                            class="w-full md:w-auto text-center bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded transition duration-200"
                            role="button"
                            aria-label="Cancelar creación de categoría"
                        >
                            Cancelar
                        </Link>
                        <button 
                            type="submit" 
                            class="w-full md:w-auto bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded transition duration-200"
                            aria-label="Guardar categoría"
                        >
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </main>
        <!-- Pie de página -->
        <Footer />
    </div>
</template>

<script setup>
// Importa los helpers de Inertia y Vue
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';
// Importa los componentes de la barra de navegación y el pie de página
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

// Define las props que puede recibir el componente (no se usan aquí, pero están por si acaso)
const props = defineProps({
    categories: Array,
});

// Crea un formulario reactivo con el campo 'name'
const form = useForm({
    name: '',    
});

// Función que se ejecuta al enviar el formulario
function submit() {
    // Envía los datos del formulario a la ruta 'categories.store' usando POST
    form.post(route('categories.store'));
}
</script>