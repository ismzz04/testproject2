<template>

    <Head title="Añadir Tarea" />
    <div class="bg-white text-black">
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#252850] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="py-10">
                    <h1 class="text-2xl font-bold">Añadir Tarea</h1>
                </header>

                <!-- Formulario para añadir eventos -->
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium">Título</label>
                        <input type="text" id="title" v-model="form.title" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#252850] focus:ring-[#252850] bg-gray-100" />
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium">Descripción</label>
                        <textarea id="description" v-model="form.description" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#252850]  bg-gray-100"></textarea>
                    </div>

                    <!-- Campo de categorías -->
                    <div>
                        <label for="category" class="block text-sm font-medium">Categoría</label>
                        <select id="category" v-model="form.categoria_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm   bg-gray-100">
                            <option v-for="categoria in categories" :key="categoria.id" :value="categoria.id">{{
                                categoria.title }}</option>
                        </select>
                    </div>

                    <!-- Campo de imagen -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Imagen de la Tarea</label>
                        <input type="file" id="image" @input="handleImageChange" class="w-full border p-2 rounded"
                            accept="image/*" />
                        <div class="p-2 text-left">
                            <img v-if="previewImage" class="w-20" :src="previewImage" :alt="form.name" />
                        </div>
                    </div>

                    <!-- Botón para enviar -->
                    <button type="submit"
                        class="inline-flex justify-center rounded-md border border-transparent bg-[#252850] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-[#252850]/80 ">
                        Añadir Tarea
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';


const form = useForm({
    title: '',
    description: '',
    categoria_id: '',  // Se añadió el campo para la categoría
    image: '',
});

const previewImage = ref(null);

// Función para manejar el cambio de imagen
const handleImageChange = (task) => {
    const file = task.target.files[0];
    form.image = file;

    if (file) {
        previewImage.value = URL.createObjectURL(file);
    }
};

// Función de envío del formulario
const submit = () => {
    form.post(route('task.store'));
};

const props = defineProps({
    categories: Array,
})
</script>


<style scoped>
body {
    background-color: #f5f5f5;
    /* Color de fondo claro */
}

h1 {
    color: #333;
    /* Color del texto del encabezado */
}

input,
textarea {
    background-color: #f9f9f9;
    /* Color de fondo claro para los campos */
    border: 1px solid #ccc;
    /* Color de borde claro */
}

input:focus,
textarea:focus {
    border-color: #252850;

}
</style>