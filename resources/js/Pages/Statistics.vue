<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import UrlTrafficStatistics from '../Components/UrlTrafficStatistics.vue'

</script>

<template>
    <Head title="Statistics" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Statistics</h2>
        </template>
        <UrlTrafficStatistics />
    </AuthenticatedLayout>
</template>