<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        v-model="model"
        ref="input"
    />
</template>


<!-- 🧠 Guía paso a paso para hacer un CRUD con Laravel + Vue (Inertia)
1. 🛠 Crear modelo, migración, controlador y recurso
bash
Copiar
Editar
sail artisan make:model Task -mcr
Esto genera:

app/Models/Task.php → modelo

database/migrations/xxxx_create_tasks_table.php → migración

app/Http/Controllers/TaskController.php → controlador

Registra automáticamente las rutas (-r)

2. 🧱 Editar la migración (database/migrations/...create_tasks_table.php)
Agregamos los campos que necesitemos, por ejemplo:

title (string)

description (text)

image (string nullable)

categoria_id (unsignedBigInteger nullable)

Ejecutamos la migración:

bash
Copiar
Editar
sail artisan migrate
3. 📁 Modelo (app/Models/Task.php)
Podés definir qué campos son asignables:

php
Copiar
Editar
protected $fillable = ['title', 'description', 'image', 'categoria_id'];
Si usás relaciones, por ejemplo con Categoria, lo agregás:

php
Copiar
Editar
public function categoria() {
    return $this->belongsTo(Categoria::class);
}
4. 🌐 Rutas (routes/web.php)
Agregamos el recurso:

php
Copiar
Editar
Route::resource('task', TaskController::class);
5. 📋 Controlador (app/Http/Controllers/TaskController.php)
Cada método tiene su función:

index()
php
Copiar
Editar
return Inertia::render('Task/Index', [
    'tasks' => Task::with('categoria')->latest()->get()
]);
create()
php
Copiar
Editar
return Inertia::render('Task/Create', [
    'categories' => Categoria::all()
]);
store()
php
Copiar
Editar
$task = Task::create($request->all());
return redirect()->route('task.index');
show($id)
php
Copiar
Editar
$task = Task::findOrFail($id);
return Inertia::render('Task/Show', ['task' => $task]);
edit($id)
php
Copiar
Editar
$task = Task::findOrFail($id);
return Inertia::render('Task/Edit', [
    'task' => $task,
    'categories' => Categoria::all()
]);
update(Request $request, Task $task)
php
Copiar
Editar
$task->update($request->all());
return redirect()->route('task.index');
destroy($id)
php
Copiar
Editar
Task::destroy($id);
return redirect()->route('task.index');
6. 🧩 Vista Vue: Task/Index.vue
Recibe las tareas con defineProps

Las muestra con v-for

Botones: Ver, Editar, Eliminar

js
Copiar
Editar
defineProps({ tasks: Array });
Usás <Link> de Inertia para navegar o router.delete() para eliminar.

7. ✏️ Vista Vue: Task/Create.vue y Task/Edit.vue
Usás useForm() para el formulario

Inputs enlazados con v-model

Botón con @submit.prevent="form.post(...)" o .put()

Si editás:

js
Copiar
Editar
const form = useForm({
    title: props.task.title,
    ...
});
8. 📦 Subida de imágenes
En store y update, usás $request->file('image')

Guardás con store('public') y guardás la ruta

En Vue, usás <input type="file" @change="handleFile">

9. 🧹 Extras
Agregar búsqueda, filtrado, paginación, etc.

Usar Tailwind para estilos rápidos

Mostrar alertas o redirecciones con onSuccess

📝 Resumen de pasos clave:
make:model Task -mcr

Editar migración → migrate

Modelo con $fillable

Rutas Route::resource(...)

Controlador: index, create, store, show, edit, update, destroy

Crear vistas Index.vue, Create.vue, Edit.vue, Show.vue

Formulario con useForm(), métodos post o put

Mostrar imágenes, inputs con v-model

Eliminar con router.delete -->



Create

<!-- 🧰 Paso 1: Crear el modelo y recursos de Tarea
bash
Copiar
Editar
php artisan make:model Task -mcr
🧱 Paso 2: Migración de tareas
Edita la migración generada xxxx_xx_xx_create_tasks_table.php así:

php
Copiar
Editar
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->decimal('price', 8, 2);
    $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});
Después:

bash
Copiar
Editar
php artisan migrate
🔁 Paso 3: Relaciones en el modelo
app/Models/Task.php

php
Copiar
Editar
public function categoria()
{
    return $this->belongsTo(Categoria::class);
}
📋 Paso 4: Mostrar en tabla (index)
Controlador: TaskController.php
php
Copiar
Editar
public function index()
{
    $tasks = Task::with('categoria')->get();
    return Inertia::render('Task/Index', [
        'tasks' => $tasks
    ]);
}
Vista: resources/js/Pages/Task/Index.vue
vue
Copiar
Editar
<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  tasks: Array
});
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Lista de Tareas</h1>

    <table class="w-full border">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-2">Título</th>
          <th class="p-2">Descripción</th>
          <th class="p-2">Precio</th>
          <th class="p-2">Categoría</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td class="p-2">{{ task.title }}</td>
          <td class="p-2">{{ task.description }}</td>
          <td class="p-2">€{{ task.price }}</td>
          <td class="p-2">{{ task.categoria?.title ?? 'Sin categoría' }}</td>
        </tr>
      </tbody>
    </table>

    <Link :href="route('task.create')" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
      Crear nueva tarea
    </Link>
  </div>
</template>
📝 Paso 5: Crear nueva tarea (create + store)
Controlador:
php
Copiar
Editar
public function create()
{
    $categorias = Categoria::all();
    return Inertia::render('Task/Create', ['categorias' => $categorias]);
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'categoria_id' => 'required|exists:categorias,id'
    ]);

    Task::create($request->all());

    return redirect()->route('task.index');
}
Vista: resources/js/Pages/Task/Create.vue
vue
Copiar
Editar
<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  categorias: Array
});

const form = useForm({
  title: '',
  description: '',
  price: '',
  categoria_id: ''
});

const submit = () => {
  form.post(route('task.store'));
};
</script>

<template>
  <div class="p-6 max-w-xl mx-auto">
    <h1 class="text-xl font-bold mb-4">Crear Nueva Tarea</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block">Título:</label>
        <input v-model="form.title" type="text" class="w-full border p-2 rounded" required />
      </div>

      <div>
        <label class="block">Descripción:</label>
        <textarea v-model="form.description" class="w-full border p-2 rounded" required></textarea>
      </div>

      <div>
        <label class="block">Precio (€):</label>
        <input v-model="form.price" type="number" step="0.01" class="w-full border p-2 rounded" required />
      </div>

      <div>
        <label class="block">Categoría:</label>
        <select v-model="form.categoria_id" class="w-full border p-2 rounded" required>
          <option value="" disabled>Selecciona una categoría</option>
          <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
            {{ categoria.title }}
          </option>
        </select>
      </div>

      <div class="flex justify-between">
        <Link :href="route('task.index')" class="bg-gray-300 px-4 py-2 rounded">Cancelar</Link>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
      </div>
    </form>
  </div>
</template> -->

Editar

<!-- 🛠️ 1. Rutas (web.php o RouteServiceProvider si usas resource)
Si ya usaste:

bash
Copiar
Editar
php artisan make:model Task -mcr
Y en tu routes/web.php usaste:

php
Copiar
Editar
Route::resource('task', TaskController::class);
Entonces ya tienes las rutas edit y update.

🎯 2. Controlador (TaskController.php)
✏️ Método edit:
php
Copiar
Editar
public function edit(Task $task)
{
    $categorias = Categoria::all();

    return Inertia::render('Task/Edit', [
        'task' => $task,
        'categorias' => $categorias
    ]);
}
💾 Método update:
php
Copiar
Editar
public function update(Request $request, Task $task)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'categoria_id' => 'required|exists:categorias,id'
    ]);

    $task->update($request->all());

    return redirect()->route('task.index');
}
🎨 3. Vista: resources/js/Pages/Task/Edit.vue
vue
Copiar
Editar
<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
  task: Object,
  categorias: Array
});

const form = useForm({
  title: props.task.title,
  description: props.task.description,
  price: props.task.price,
  categoria_id: props.task.categoria_id
});

const submit = () => {
  form.put(route('task.update', props.task.id));
};
</script>

<template>
  <div class="p-6 max-w-xl mx-auto">
    <h1 class="text-xl font-bold mb-4">Editar Tarea</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block">Título:</label>
        <input v-model="form.title" type="text" class="w-full border p-2 rounded" required />
      </div>

      <div>
        <label class="block">Descripción:</label>
        <textarea v-model="form.description" class="w-full border p-2 rounded" required></textarea>
      </div>

      <div>
        <label class="block">Precio (€):</label>
        <input v-model="form.price" type="number" step="0.01" class="w-full border p-2 rounded" required />
      </div>

      <div>
        <label class="block">Categoría:</label>
        <select v-model="form.categoria_id" class="w-full border p-2 rounded" required>
          <option value="" disabled>Selecciona una categoría</option>
          <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
            {{ categoria.title }}
          </option>
        </select>
      </div>

      <div class="flex justify-between">
        <Link :href="route('task.index')" class="bg-gray-300 px-4 py-2 rounded">Cancelar</Link>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
      </div>
    </form>
  </div>
</template> -->

eliminar y ver

<!-- 🧨 1. Eliminar (destroy)
🔧 Controlador (TaskController.php)
php
Copiar
Editar
public function destroy(Task $task)
{
    $task->delete();
    return redirect()->route('task.index');
}
📄 Vista (por ejemplo en Index.vue)
Dentro de la tabla de tareas o donde tengas el listado:

vue
Copiar
Editar
<button @click="deleteTask(task.id)" class="text-red-600 hover:underline">
  Eliminar
</button>
🧠 Script en Index.vue
vue
Copiar
Editar
<script setup>
import { router } from '@inertiajs/vue3';

function deleteTask(id) {
  if (confirm('¿Estás seguro de que deseas eliminar esta tarea?')) {
    router.delete(route('task.destroy', id));
  }
}
</script>
👁️ 2. Vista Individual (show)
🔧 Controlador (TaskController.php)
php
Copiar
Editar
public function show(Task $task)
{
    return Inertia::render('Task/Show', [
        'task' => $task,
    ]);
}
🖼️ Componente resources/js/Pages/Task/Show.vue
vue
Copiar
Editar
<script setup>
import { defineProps, Link } from 'vue';

const props = defineProps({
  task: Object
});
</script>

<template>
  <div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">{{ task.title }}</h1>

    <p class="mb-2"><strong>Descripción:</strong> {{ task.description }}</p>
    <p class="mb-2"><strong>Precio:</strong> {{ task.price }} €</p>
    <p class="mb-2"><strong>Categoría:</strong> {{ task.categoria?.title ?? 'Sin categoría' }}</p>

    <Link :href="route('task.index')" class="mt-4 inline-block text-blue-600 underline">
      ← Volver al listado
    </Link>
  </div>
</template> -->