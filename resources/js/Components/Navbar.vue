<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isOpen = ref(false);

const toggleMenu = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <nav class="bg-gray-800" role="navigation" aria-label="Navegación principal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <Link 
                            href="/" 
                            class="text-white font-bold text-xl"
                            aria-label="Ir a la página de inicio"
                        >
                            Inicio
                        </Link>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4" role="menubar">
                            <Link
                                href="/zapatos"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                role="menuitem"
                                aria-label="Ver lista de zapatos"
                            >
                                Zapatos
                            </Link>
                            <Link
                                href="/categories"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                role="menuitem"
                                aria-label="Ver lista de categorías"
                            >
                                Categorías
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Botones de autenticación -->
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center space-x-4" role="group" aria-label="Acciones de autenticación">
                        <Link
                            :href="route('login')"
                            class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                            role="button"
                            aria-label="Iniciar sesión"
                        >
                            Iniciar Sesión
                        </Link>
                        <Link
                            :href="route('register')"
                            class="bg-blue-700 hover:bg-blue-600 text-white px-3 py-2 rounded-md text-sm font-medium"
                            role="button"
                            aria-label="Registrarse"
                        >
                            Registrarse
                        </Link>
                    </div>
                </div>

                <!-- Botón hamburguesa -->
                <div class="md:hidden">
                    <button 
                        @click="toggleMenu" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-expanded="isOpen"
                        aria-controls="mobile-menu"
                        aria-label="Abrir menú de navegación"
                    >
                        <span class="sr-only">Abrir menú principal</span>
                        <svg 
                            class="h-6 w-6" 
                            :class="{'hidden': isOpen, 'block': !isOpen }"
                            stroke="currentColor" 
                            fill="none" 
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M4 6h16M4 12h16M4 18h16" 
                            />
                        </svg>
                        <svg 
                            class="h-6 w-6" 
                            :class="{'block': isOpen, 'hidden': !isOpen }"
                            stroke="currentColor" 
                            fill="none" 
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12" 
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menú móvil -->
        <div 
            id="mobile-menu"
            class="md:hidden"
            :class="{'block': isOpen, 'hidden': !isOpen}"
            @click="isOpen = false"
            role="menu"
            aria-label="Menú móvil"
        >
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <Link
                    href="/zapatos"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
                    role="menuitem"
                    aria-label="Ver lista de zapatos"
                >
                    Zapatos
                </Link>
                <Link
                    href="/categories"
                    class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
                    role="menuitem"
                    aria-label="Ver lista de categorías"
                >
                    Categorías
                </Link>
                <!-- Botones de autenticación en móvil -->
                <div class="pt-4 pb-3 border-t border-gray-700" role="group" aria-label="Acciones de autenticación móvil">
                    <Link
                        :href="route('login')"
                        class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
                        role="button"
                        aria-label="Iniciar sesión"
                    >
                        Iniciar Sesión
                    </Link>
                    <Link
                        :href="route('register')"
                        class="bg-blue-500 hover:bg-blue-600 text-white block px-3 py-2 rounded-md text-base font-medium mt-2"
                        role="button"
                        aria-label="Registrarse"
                    >
                        Registrarse
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
/* Transiciones para el menú móvil */
.md\:hidden {
    transition: all 0.3s ease-in-out;
}

/* Mejoras de accesibilidad para el foco */
:focus {
    outline: 2px solid #4F46E5;
    outline-offset: 2px;
}

/* Mejora del contraste para texto */
.text-gray-300 {
    color: #E5E7EB;
}

/* Mejora del contraste para hover */
.hover\:bg-gray-700:hover {
    background-color: #374151;
}
</style> 