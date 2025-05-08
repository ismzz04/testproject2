<template>
    <Navbar />
    <div class="container mx-auto px-4">
        <div class="text-xl md:text-2xl p-4 text-center">
            Show de {{ categories.name }}
        </div>
        
        <!-- Tabla Responsive -->
        <div class="overflow-x-auto p-4">
            <table class="w-full min-w-[600px]">
                <tbody>
                    <tr class="bg-gray-400 text-left">
                        <th class="p-2 border border-black">ID</th>
                        <th class="p-2 border border-black">name</th>
                    </tr>

                    <tr class="border-t">
                        <td class="p-2 border border-black">{{ categories.id }}</td>
                        <td class="p-2 border border-black">{{ categories.name }}</td>

                    </tr>
                    <tr>
                        <td colspan="7" class="p-2 text-center"></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
    <Footer />
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    categories: Object,
});

</script>