<script setup>
import { ref, onMounted } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const urls = ref(0);

onMounted(async () => {
    let res = await fetch('/getMyUrls');
    //console.log(await res.json());
    urls.value = await res.json();
});

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="border-collapse border m-3">
                        <thead>
                            <tr>
                                <th class="border border-slate-200 dark:border-slate-600 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">ID</th>
                                <th class="border border-slate-200 dark:border-slate-600 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Short URL</th>
                                <th class="border border-slate-200 dark:border-slate-600 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Long URL</th>
                                <th class="border border-slate-200 dark:border-slate-600 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Active</th>
                                <th class="border border-slate-200 dark:border-slate-600 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Created</th>
                                <th class="border border-slate-200 dark:border-slate-600 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="u in urls">
                                <td class="border border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ u.id }}</td>
                                <td class="border border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ u.short_url }}</td>
                                <td class="border border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ u.long_url }}</td>
                                <td class="border border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ u.active }}</td>
                                <td class="border border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ u.created_at }}</td>
                                <td class="border border-slate-200 dark:border-slate-600 p-4 text-slate-500 dark:text-slate-400">{{ u.updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
