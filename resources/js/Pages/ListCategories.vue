<template>
  <!-- Barra de navegación superior -->
  <Navbar />
  <main class="container mx-auto px-4" role="main">
      <!-- Título principal de la página -->
      <h1 class="text-center text-3xl md:text-5xl p-4" @click="Welcome" role="heading" aria-level="1">
          Lista de Categories
      </h1>
      <!-- Botón para crear una nueva categoría -->
      <div class="text-center text-lg md:text-xl p-4">
          <button 
              @click="CreateCategories" 
              class="w-full md:w-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              aria-label="Crear nueva categoría"
          >
              Crear Categorias
          </button>
      </div>

      <!-- Buscador de categorías -->
      <div class="search-container text-center" role="search">
          <label for="category-search" class="sr-only">Buscar categorías</label>
          <input 
              id="category-search"
              type="text" 
              v-model="search" 
              placeholder="Buscar por nombre..." 
              class="w-full md:w-1/2 px-4 py-2 border rounded-lg shadow-sm"
              aria-label="Buscar categorías por nombre"
          />
      </div>

      <!-- Tabla Responsive con la lista de categorías -->
      <div class="overflow-x-auto p-4" role="region" aria-label="Lista de categorías">
          <table class="w-full border min-w-[600px]" role="grid">
              <thead>
                  <tr class="bg-gray-400 text-left">
                      <th scope="col" class="p-2 border border-black">Name</th>
                      <th scope="col" class="p-2 border border-black">Acciones</th>
                  </tr>
              </thead>
              <tbody>
                  <!-- Recorre las categorías filtradas y muestra cada una en una fila -->
                  <tr v-for="category in filteredCategories" :key="category.id" role="row">
                      <td class="p-2 border border-black" role="cell">{{ category.name }}</td>
                      <td class="p-2 border border-black" role="cell">
                          <div class="flex gap-2">
                              <!-- Botón para editar la categoría -->
                              <Link 
                                  :href="route('categories.edit', category.id)" 
                                  class="text-blue-500 hover:underline"
                                  aria-label="Editar categoría"
                              >
                                  Editar
                              </Link>
                              <!-- Botón para eliminar la categoría -->
                              <button 
                                  @click="DeleteCategories(category.id)" 
                                  class="text-red-500 hover:underline"
                                  aria-label="Eliminar categoría"
                              >
                                  Eliminar
                              </button>
                          </div>
                      </td>
                  </tr>
              </tbody>
          </table>
      </div>
  </main>
  <!-- Pie de página -->
  <Footer />
</template>

<script setup>
// Importa los helpers de Inertia y Vue
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
// Importa los componentes de la barra de navegación y el pie de página
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

// Variable reactiva para el texto de búsqueda
const search = ref('');

// Recibe las categorías como prop
const props = defineProps({
  categories: Array,
});

// Computed para filtrar las categorías según el texto de búsqueda
const filteredCategories = computed(() =>
  props.categories.filter(category =>
      category.name.toLowerCase().includes(search.value.toLowerCase())
  )
);

// Función para eliminar una categoría
function DeleteCategories(id){
  router.delete(route('categories.destroy', id))
}

// function DeleteCategories(id) {
//   router.delete(route('categories.destroy', id), {
//     preserveScroll: true,
//     onSuccess: () => {
//         zapato.value = category.value.filter(category => category.id !== id);
//     }
//   });
// }

// Función para ir a la página de inicio
function Welcome(){
  router.visit('/');
}

// Función para ir a la página de crear categorías
function CreateCategories(){
  router.visit('categories/create');
}
</script>