<script setup>
import { ref, onMounted } from 'vue'

const urls = ref(0)

onMounted(async () => {
    urls.value = await fetch('/getMyUrls').then(res => res.json())
})

const urlBuilder = (url) => {
    return window.location.origin + "/" + url
}

const dateBuilder = (isoDate) => {
    return new Date(isoDate).toLocaleString(window.navigator.language || window.navigator.userLanguage)
}
</script>

<template>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
                <table class="w-full border-collapse border">
                    <thead>
                        <tr>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">#</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Short URL</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Long URL</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Active</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Created</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(u, i) in urls" :key="u.id">
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ i+1 }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">
                                <a :href="urlBuilder(u.short_url)" class="text-green-500">{{ u.short_url }}</a>
                            </td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400">{{ u.long_url }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">
                                <label class="relative inline-flex items-center align-middle cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" :checked="u.active">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                </label>
                            </td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ dateBuilder(u.created_at) }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ dateBuilder(u.updated_at) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style>
td:has(input:checked) {
    background: rgb(22 163 74 / 0.2);
}
</style>