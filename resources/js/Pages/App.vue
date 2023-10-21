<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import UrlShorteher from '@/Components/UrlShortener.vue'

const page = usePage()
const isAuth = computed(() => page.props.auth.user)

</script>

<template>
    <GuestLayout v-if="!isAuth">
        <UrlShorteher />
    </GuestLayout>

    <AuthenticatedLayout v-if="isAuth">
        <UrlShorteher />
    </AuthenticatedLayout>
</template>

