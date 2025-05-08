<template>
  <footer class="bg-gray-800 text-white mt-12 py-8 px-4">
      <div class="container mx-auto">
          <div class="flex flex-col md:flex-row justify-between items-center">
              <div class="mb-4 md:mb-0">
                  <h2 class="text-xl font-bold">Zapatos Titulo</h2>
                  <p class="text-gray-300">A ver si funciona en el test project</p>
              </div>
              
              <div class="flex space-x-8">
                  <div>
                      <h3 class="font-semibold mb-2">Enlaces</h3>
                      <ul class="space-y-1">
                          <li><Link href="/" class="text-gray-300 hover:text-white">Inicio</Link></li>
                          <li><Link href="/zapatos" class="text-gray-300 hover:text-white">Zapatos</Link></li>
                          <li><Link href="/categories" class="text-gray-300 hover:text-white">Categorías</Link></li>
                      </ul>
                  </div>
                  
              </div>
          </div>
          
          <div class="mt-8 pt-4 border-t border-gray-700 text-center">
              <p class="text-gray-400">&copy; {{ new Date().getFullYear() }} Denis </p>
          </div>
      </div>
  </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>