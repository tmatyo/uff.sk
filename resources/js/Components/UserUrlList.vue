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
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Clicks</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Edit</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(u, i) in urls" :key="u.id">
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ i+1 }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">
                                <a :href="urlBuilder(u.short_url)" target="_blank" class="text-green-500">{{ "uff.sk/" + u.short_url }}
                                    <svg class="h-4 w-4 text-green-500 short-url" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
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
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ u.stat_count }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">
                                <a :href="urlBuilder(u.short_url)" class="text-center align-middle">
                                    <svg class="h-6 w-6 text-yellow-500 items-center align-middle" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" /></svg>
                                </a>
                            </td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">
                                <a :href="urlBuilder(u.short_url)" class="text-center align-middle">
                                    <svg class="h-6 w-6 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>
                                </a>
                            </td>
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

.short-url {
    display: inline;
}
</style>