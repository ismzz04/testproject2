<script setup>
import { ref } from 'vue'
import Navbar from '@/Components/NavBar.vue';


// Índice de la imagen actual del carrusel
const currentIndex = ref(0)

// Lista de imágenes estáticas (rutas locales)
const images = [
  { src: '/storage/task/2opYrKsSqnhhPeRaFPTZXhKn7Icl8bDbMDA8r8H9.png' },
  { src: '/storage/task/lYOq82TRyY51PV9EVmPHPGVFRd5uZW0ZvzKwt4yF.jpg' }
]

// Cambia a la imagen según el índice elegido
const goToImage = (index) => {
  currentIndex.value = index
}

// Props recibidas: una tarea con título y descripción
const props = defineProps({
  task: {
    type: Array,
    required: true
  }
})
</script>

<template>
  <Navbar />

  <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
    <!-- Imagen del carrusel -->
    <img :src="images[currentIndex].src" :alt="'Imagen ' + (currentIndex + 1)"
      class="w-96 h-auto rounded-lg shadow-lg" />

    <!-- Puntos de navegación del carrusel -->
    <div class="flex space-x-2 mt-4">
      <span v-for="(img, index) in images" :key="index" @click="goToImage(index)"
        class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300" :class="{
          'bg-gray-800': index === currentIndex,
          'bg-gray-400': index !== currentIndex
        }" />
    </div>
            <!-- image -->

    <img :src="`/storage/${task.image}`" alt="Imagen de la tarea" class="mt-4  rounded-lg shadow-md">
        <!-- Datos de la tarea -->
    <div class="task bg-white p-6 rounded-lg shadow-lg max-w-xl mx-auto mt-4">
  <!-- Título de la tarea -->
  <h1 class="text-3xl font-semibold text-[#252850] mb-4">Titulo:{{ task.title }}</h1>

  <!-- Descripción de la tarea -->
  <p class="text-lg text-gray-700 mb-4">Descripcion:{{ task.description }}</p>

  <!-- Categoría ID (si es necesario mostrarla) -->
  <p class="text-sm text-gray-500 mb-2">Categoría ID: {{ task.categoria_id }}</p>

  <!-- Título de la categoría -->
  <div class="flex justify-between items-center">
    <span class="text-sm font-medium text-gray-500">Categoría:</span>
    <span class="text-sm text-[#252850]">{{ task.categoria.title }}</span>
  </div>
</div>

  </div>

</template>

<style scoped>
.task {
  padding: 1rem;
  max-width: 600px;
  margin: auto;
  font-family: sans-serif;
}

h1 {
  color: #333;
}
</style>