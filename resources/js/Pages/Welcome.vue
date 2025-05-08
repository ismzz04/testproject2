<template>
    <!-- Barra de navegación superior -->
    <Navbar />
    <div class="container mx-auto px-4">
        <!-- Título principal, clicable para volver al inicio -->
        <div class="text-center text-3xl md:text-5xl p-4" @click="Welcome">
            Lista de Zapatos
        </div>
        <!-- Botones para crear zapatos o categorías -->
        <div class="text-center text-lg md:text-xl p-4 space-y-2 md:space-y-0 md:space-x-4">
            <button @click="CreateZapatos" class="w-full md:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Zapatos
            </button>
            <button @click="CreateCategories" class="w-full md:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Categorias
            </button>
        </div>

        <!-- Tabs para alternar entre tablas de zapatos y categorías -->
        <div class="flex justify-center my-4 gap-4">
            <button
                :class="[
                    'px-4 py-2 rounded font-bold focus:outline-none',
                    activeTable === 'zapatos'
                        ? 'bg-blue-700 text-white'
                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                ]"
                @click="activeTable = 'zapatos'"
                aria-pressed="activeTable === 'zapatos'"
            >
                Ver Zapatos
            </button>
            <button
                :class="[
                    'px-4 py-2 rounded font-bold focus:outline-none',
                    activeTable === 'categorias'
                        ? 'bg-blue-700 text-white'
                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                ]"
                @click="activeTable = 'categorias'"
                aria-pressed="activeTable === 'categorias'"
            >
                Ver Categorías
            </button>
        </div>

        <!-- Tabla de Categorías (con tab) -->
        <section
            v-if="activeTable === 'categorias'"
            aria-label="Lista de Categorías"
            class="bg-white p-4 border rounded mb-8"
        >
            <!-- Buscador de categorías -->
            <div class="mb-4" role="search">
                <label for="category-search" class="sr-only">Buscar categorías</label>
                <input
                    id="category-search"
                    type="text"
                    v-model="searchCategories"
                    placeholder="Buscar por nombre..."
                    class="w-full px-4 py-2 border rounded-lg shadow-sm"
                    aria-label="Buscar categorías por nombre"
                />
            </div>
            <!-- Tabla de categorías -->
            <div class="overflow-x-auto" role="region" aria-label="Tabla de categorías">
                <table class="w-full border min-w-[400px]" role="grid">
                    <thead>
                        <tr class="bg-gray-400 text-left">
                            <th scope="col" class="p-2 border border-black">Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in filteredCategories" :key="category.id">
                            <td class="p-2 border border-black">{{ category.name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Tabla de Zapatos (con tab) -->
        <section
            v-if="activeTable === 'zapatos'"
            aria-label="Lista de Zapatos"
            class="bg-white p-4 border rounded mb-8"
        >
            <!-- Buscador de zapatos -->
            <div class="mb-4" role="search">
                <label for="zapato-search" class="sr-only">Buscar zapatos</label>
                <input
                    id="zapato-search"
                    type="text"
                    v-model="searchZapatos"
                    placeholder="Buscar por nombre o categoría..."
                    class="w-full px-4 py-2 border rounded-lg shadow-sm"
                    aria-label="Buscar zapatos por nombre o categoría"
                />
            </div>
            <!-- Tabla de zapatos -->
            <div class="overflow-x-auto" role="region" aria-label="Tabla de zapatos">
                <table class="w-full border min-w-[600px]" role="grid">
                    <thead>
                        <tr class="bg-gray-400 text-left">
                            <th scope="col" class="p-2 border border-black">Nombre</th>
                            <th scope="col" class="p-2 border border-black">Descripción</th>
                            <th scope="col" class="p-2 border border-black">Número</th>
                            <th scope="col" class="p-2 border border-black">Categoría</th>
                            <th scope="col" class="p-2 border border-black">Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="zapato in filteredZapatos" :key="zapato.id">
                            <td class="p-2 border border-black">{{ zapato.name }}</td>
                            <td class="p-2 border border-black">{{ zapato.description }}</td>
                            <td class="p-2 border border-black">{{ zapato.number }}</td>
                            <td class="p-2 border border-black">{{ zapato.category?.name || 'Sin categoría' }}</td>
                            <td class="p-2 border border-black">
                                <img
                                    v-if="zapato.photo"
                                    :src="`/storage/${zapato.photo}`"
                                    :alt="`Foto de ${zapato.name}`"
                                    class="w-16 h-16 object-cover rounded"
                                />
                                <span v-else>No hay imagen</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Carrusel de Imágenes -->
        <div class="w-full max-w-4xl mx-auto mt-10">
            <div class="relative overflow-hidden rounded-xl shadow-lg">
                <!-- Imagen actual del carrusel -->
                <img
                    :src="getImageUrl(images[currentImageIndex])"
                    :alt="imageNames[currentImageIndex]"
                    class="w-full h-48 md:h-64 object-cover transition-all duration-500"
                />
                <div class="absolute bottom-0 w-full bg-black bg-opacity-50 text-white p-4">
                    <div class="text-center text-lg font-semibold">
                        {{ imageNames[currentImageIndex] }}
                    </div>
                </div>
                <!-- Botones para navegar el carrusel -->
                <button @click="prevImage"
                    class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full hover:bg-opacity-75">
                    ‹
                </button>
                <button @click="nextImage"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full hover:bg-opacity-75">
                    ›
                </button>
            </div>
            <!-- Indicadores del carrusel -->
            <div class="flex justify-center mt-4 space-x-2">
                <span
                    v-for="(_, index) in images"
                    :key="index"
                    @click="goToImage(index)"
                    class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
                    :class="{ 'bg-gray-800': index === currentImageIndex, 'bg-gray-400': index !== currentImageIndex }"
                />
            </div>
        </div>

        <!-- Carrusel de Texto (comentado, puedes activarlo si lo necesitas)
        <div class="w-full max-w-4xl mx-auto mt-10 mb-16">
            <div class="relative overflow-hidden rounded-xl shadow-lg bg-gradient-to-r from-blue-500 to-purple-600 p-8">
                <div class="relative h-32">
                    <transition-group 
                        name="slide" 
                        tag="div" 
                        class="absolute w-full"
                    >
                        <div 
                            v-for="(zapato, index) in zapatos" 
                            :key="zapato.id"
                            v-show="currentTextIndex === index"
                            class="text-center text-white"
                        >
                            <h2 class="text-2xl md:text-3xl font-bold mb-4">{{ zapato.name }}</h2>
                            <p class="text-lg md:text-xl">{{ zapato.description }}</p>
                            <p class="text-md mt-2">Categoría: {{ zapato.category?.name || 'Sin categoría' }}</p>
                            <p class="text-md">Número: {{ zapato.number }}</p>
                        </div>
                    </transition-group>
                </div>
                
                Controles del carrusel de texto
                <div class="flex justify-center mt-6 space-x-4">
                    <button @click="prevText"
                        class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-full hover:bg-opacity-30 transition-all">
                        Anterior
                    </button>
                    <button @click="nextText"
                        class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-full hover:bg-opacity-30 transition-all">
                        Siguiente
                    </button>
                </div> 

                Indicadores del carrusel de texto
                <div class="flex justify-center mt-4 space-x-2">
                    <span
                        v-for="(_, index) in zapatos"
                        :key="index"
                        @click="goToText(index)"
                        class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
                        :class="{ 'bg-white': index === currentTextIndex, 'bg-white bg-opacity-50': index !== currentTextIndex }"
                    />
                </div> 
            </div> 
        </div> -->
    </div>
    <!-- Pie de página -->
    <Footer />
</template>

<script setup>
// Importa los helpers de Inertia y Vue
import { Link, router } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, computed } from 'vue';
// Importa los componentes de la barra de navegación y el pie de página
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

// Variables reactivas para el carrusel y tabs
const currentImageIndex = ref(0);
const currentTextIndex = ref(0);
const imageAutoplayInterval = ref(null);
const textAutoplayInterval = ref(null);
const activeTable = ref('zapatos'); // Por defecto muestra la tabla de zapatos

// Props para recibir los datos de las tablas
const props = defineProps({
    zapatos: {
        type: Array,
        required: true
    },
    categories: {
        type: Array,
        required: true
    }
});

// Buscador de categorías
const searchCategories = ref('');
const filteredCategories = computed(() =>
    props.categories.filter(category =>
        category.name.toLowerCase().includes(searchCategories.value.toLowerCase())
    )
);

// Buscador de zapatos
const searchZapatos = ref('');
const filteredZapatos = computed(() =>
    props.zapatos.filter(zapato =>
        zapato.name.toLowerCase().includes(searchZapatos.value.toLowerCase()) ||
        (zapato.category && zapato.category.name && zapato.category.name.toLowerCase().includes(searchZapatos.value.toLowerCase()))
    )
);

// Imágenes de ejemplo para el carrusel
const images = [
    'zapato1.jpeg',
    'zapato2.jpg',
    'zapato3.jpg',
];

// Nombres descriptivos para cada imagen
const imageNames = [
    'Zapatos Deportivos',
    'Zapatos Casuales',
    'Zapatos Formales',
];

// Funciones de navegación
function Welcome(){
    router.visit('/');
}
function CreateZapatos(){
    router.visit('zapatos/create');
}
function CreateCategories(){
    router.visit('categories/create');
}

// Funciones para el carrusel de imágenes
const nextImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % images.length;
};
const prevImage = () => {
    currentImageIndex.value = (currentImageIndex.value - 1 + images.length) % images.length;
};
const goToImage = (index) => {
    currentImageIndex.value = index;
};

// Funciones para el carrusel de texto (comentado en el template)
const nextText = () => {
    currentTextIndex.value = (currentTextIndex.value + 1) % props.zapatos.length;
};
const prevText = () => {
    currentTextIndex.value = (currentTextIndex.value - 1 + props.zapatos.length) % props.zapatos.length;
};
const goToText = (index) => {
    currentTextIndex.value = index;
};

// Devuelve la URL de la imagen
const getImageUrl = (path) => `/images/${path}`;

// Autoplay de los carruseles
onMounted(() => {
    imageAutoplayInterval.value = setInterval(nextImage, 3000);
    textAutoplayInterval.value = setInterval(nextText, 5000);
});
onUnmounted(() => {
    if (imageAutoplayInterval.value) {
        clearInterval(imageAutoplayInterval.value);
    }
    if (textAutoplayInterval.value) {
        clearInterval(textAutoplayInterval.value);
    }
});
</script>