<template>

    <Head title="Editar Tarea" />

    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Editar Tarea</h1>

        <div class="bg-white p-4 border rounded">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label for="title" class="block mb-1">Título:</label>
                    <input type="text" id="title" v-model="form.title" class="w-full border p-2 rounded" required />
                </div>

                <div class="mb-3">
                    <label for="description" class="block mb-1">Descripción:</label>
                    <input type="text" id="description" v-model="form.description" class="w-full border p-2 rounded"
                        required />
                </div>


                <!-- Campo de categorías -->
                <div>
                    <label for="category" class="block text-sm font-medium">Categoría</label>
                    <select id="category" v-model="form.categoria_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                        <option value="" disabled>Selecciona una categoría</option>
                        <option v-for="categoria in categories" :key="categoria.id" :value="categoria.id">
                            {{ categoria.title }}
                        </option>
                    </select>
                </div>

                <!-- Imagen existente -->
                <div class="mb-3">
                    <label for="image" class="block mb-1">Imagen Actual:</label>
                    <div>
                        <img v-if="props.task.image" :src="`/storage/${props.task.image}`" alt="Imagen de la tarea"
                            class="w-32 h-32 object-cover" />
                    </div>
                </div>

                <input type="file" id="image" @change="handleFileChange" class="w-full border p-2 rounded"
                    accept="image/*,audio/*" />

                <div class="flex justify-between mt-4">
                    <Link :href="route('task.index')" class="bg-gray-300 px-3 py-1 rounded">
                    Cancelar
                    </Link>
                    <button type="submit" class="bg-[#252850] text-white px-3 py-1 rounded">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, onMounted } from 'vue';

const props = defineProps({
    task: Object,
    categories: Array,
});



// Definimos el formulario
const form = useForm({
    title: '',
    description: '',
    categoria_id: null,
    image: null, // Inicialmente la imagen es null
    _method: 'put',
});

onMounted(() => {
    // Si la tarea ya tiene datos, los asignamos al formulario
    if (props.task) {
        form.title = props.task.title;
        form.description = props.task.description;
        form.categoria_id = props.task.categoria_id; // <- Esto es CLAVE

        // No asignamos la imagen directamente, ya que no es un campo de texto
    }
});

// Manejar el cambio de archivo
function handleFileChange(event) {
    const file = event.target.files[0];
    form.image = file; // Asignamos el archivo al formulario
}

// Enviar el formulario
function submit() {
    // Enviamos los datos del formulario con el método POST para actualizar la tarea
    form.post(route('task.update', props.task.id), {
        onSuccess: () => {
            // Lógica en caso de éxito (puedes redirigir, mostrar un mensaje, etc.)
            console.log('Tarea actualizada con éxito');
        },
        onError: () => {
            // Lógica para manejar errores (mostrar mensaje, etc.)
            console.log('Error al actualizar la tarea');
        },
    });
}
</script>