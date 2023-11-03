<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <footer class="sticky top-[100vh] bg-white dark:bg-sky-800">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <Link :href="route('dashboard')">
                        <ApplicationLogo class="block h-14 w-auto fill-current text-gray-800" />
                    </Link>
                </div>
                <!-- Footer menu -->
                <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-300 sm:mb-0 dark:text-gray-300">
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline md:mr-6 ">Contact</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="mr-4 hover:underline">Terms & Conditions</a>
                    </li>
                </ul>
            </div>
            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-400 lg:my-8" />
            <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-300">© {{ new Date().getFullYear() }} <a href="/" class="hover:underline">UFF!</a> All Rights Reserved.</span>
        </div>
    </footer>
</template>
