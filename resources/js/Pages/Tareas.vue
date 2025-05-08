<script setup>
// Importamos funcionalidades de Vue y de Inertia.js
import { ref, computed } from 'vue'; // ref = variables reactivas, computed = valores calculados
import { Head, Link, router } from '@inertiajs/vue3'; // Head: título HTML, Link: enlaces SPA, router: navegación programática

// Importamos componentes
import Navbar from '@/Components/NavBar.vue';
import Footer from '@/Components/Footer.vue';

//contador de tasks
const totalTasks = computed(() => props.tasks.length);

const isCarouselVisible = ref(true); // Controlar la visibilidad del carrusel

// Definimos las propiedades (props) que recibe el componente desde el backend
const props = defineProps({
    tasks: {
        type: Array,
        required: true, // Lista de tareas obligatoria
    },
});

// Variables reactivas para buscar y filtrar
const search = ref('');              // Texto que se escribe en el input de búsqueda
const selectedCategory = ref('');    // Categoría seleccionada en el <select>
const currentIndex = ref(0);         // Índice de la imagen destacada actual

// Computed: lista de tareas filtradas por búsqueda y categoría
const filteredTasks = computed(() =>
    props.tasks.filter(task =>
        // Filtramos por texto buscado en título o categoría
        (task.title.toLowerCase().includes(search.value.toLowerCase()) ||
            task.categoria?.title?.toLowerCase().includes(search.value.toLowerCase())) &&
        // Y si hay categoría seleccionada, debe coincidir
        (selectedCategory.value === '' || task.categoria?.title === selectedCategory.value)
    )
);

// Computed: lista única de categorías para mostrar en el <select>
const uniqueCategories = computed(() => {
    const categories = new Set(); // Set evita duplicados
    props.tasks.forEach(task => {
        if (task.categoria?.title) {
            categories.add(task.categoria.title);
        }
    });
    return Array.from(categories); // Convertimos el Set en un array
});

// Función para cambiar la imagen destacada en el carrusel
const goToImage = (index) => {
    if (props.tasks.length > 0) {
        currentIndex.value = index;
    }
};

// Función que devuelve la URL pública de una imagen
const getImageUrl = (path) => `/storage/${path}`;

// Función que elimina una tarea usando el router de Inertia
function deleteTask(id) {
    router.delete(route('task.destroy', id));
}
</script>


<template>
    <!-- Título de la pestaña del navegador -->

    <Head title="Tareas" />

    <!-- Contenedor principal -->
    <div class="max-w-screen min-h-screen bg-gray-100 text-black">
        <Navbar /> <!-- Componente del menú de navegación -->

        <div class="flex flex-col items-center justify-center min-h-screen selection:bg-[#252850] selection:text-white">

            <!-- Imagen destacada -->
            <!-- Imagen destacada -->
            <div v-if="isCarouselVisible">
                <img v-if="props.tasks.length > 0" :src="getImageUrl(props.tasks[currentIndex].image)"
                    :alt="props.tasks[currentIndex].title" class="mt-4 w-96 h-auto rounded-lg shadow-lg" />


                <!-- Indicadores de navegación tipo "puntos" -->
                <div class="flex justify-center mt-4 space-x-2">
                    <span v-for="(task, index) in props.tasks" :key="task.id" @click="goToImage(index)"
                        class="w-4 h-4 rounded-full cursor-pointer"
                        :class="index === currentIndex ? 'bg-black' : 'bg-gray-400'" />
                </div>
            </div>

            <!-- Botón para mostrar u ocultar el carrusel -->
            <button @click="isCarouselVisible = !isCarouselVisible"
                class="mt-4 bg-[#252850] text-white px-4 py-2 rounded">
                {{ isCarouselVisible ? 'Ocultar Carrusel' : 'Mostrar Carrusel' }}
            </button>


            <!-- Controles: botón crear, buscar, filtrar -->
            <div class="w-full max-w-6xl p-6">
                <div class="flex flex-wrap gap-4 justify-between mb-4">

                    <!-- Botón para ir a crear nueva tarea -->
                    <Link :href="route('task.create')" class="bg-[#252850] text-white px-6 py-3 rounded-md font-medium">
                    Crear Nueva Tarea
                    </Link>

                    <!-- Input de búsqueda -->
                    <label for="search" class="sr-only">Buscar tareas</label>
                    <input id="search" v-model="search" type="text" placeholder="Buscar..."
                        class="px-4 py-2 border rounded-lg text-black" />


                    <label for="category" class="sr-only">Seleccionar categoría</label>
                    <select id="category" v-model="selectedCategory" class="px-4 py-2 border rounded-lg text-black">
                        <option value="">Todas las categorías</option>
                        <option v-for="category in uniqueCategories" :key="category" :value="category">
                            {{ category }}
                        </option>
                    </select>

                </div>

                <!-- Tabla de tareas -->
                <h2 class="text-2xl font-bold text-[#333] mb-4">Tareas</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg">
                        <thead class="bg-[#252850] text-white">
                            <tr>
                                <th class="px-6 py-4">Título</th>
                                <th class="px-6 py-4">Descripción</th>
                                <th class="px-6 py-4">Imagen</th>
                                <th class="px-6 py-4">Categoría</th>
                                <th class="px-6 py-4">Fecha</th>
                                <th class="px-6 py-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Fila por cada tarea filtrada -->
                            <tr v-for="task in filteredTasks" :key="task.id" class="hover:bg-gray-100 text-black">
                                <td class="px-6 py-4">{{ task.title }}</td>
                                <td class="px-6 py-4">{{ task.description }}</td>
                                <td class="px-6 py-4">
                                    <img :src="getImageUrl(task.image)" alt="" class="w-20 h-auto" />
                                </td>
                                <td class="px-6 py-4">{{ task.categoria?.title ?? 'Sin categoría' }}</td>
                                <td class="px-6 py-4">{{ task.created_at }}</td>
                                <td class="px-6 py-4 space-x-2">
                                    <Link :href="route('task.show', task.id)" class="text-[#252850] hover:underline">Ver
                                    </Link>
                                    <Link :href="route('task.edit', task.id)" class="text-[#252850] hover:underline">
                                    Editar</Link>
                                    <button @click="deleteTask(task.id)"
                                        class="text-[#252850] hover:underline">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- contador de tareas -->
                    <p class="text-lg text-gray-700 mb-2">Total de tareas: {{ totalTasks }}</p>

                </div>
            </div>
        </div>

        <!-- Pie de página -->
        <Footer />
    </div>
</template>