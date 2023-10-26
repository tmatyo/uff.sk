<script setup>
import { ref, onMounted } from 'vue'

const urls = ref(0)
const toggleResponse = ref(0)
const deleteResponse = ref(false)

const urlId = ref(0)
const toggleModalWindow = ref(false)

const baseUrl = ref(window.location.origin + "/")
const duckduck = ref("https://icons.duckduckgo.com/ip2/")

// fetching data
onMounted(() => loadData())

const loadData = async () => {
    urls.value = await fetch('/getMyUrls').then(res => res.json())
}

// formatting data from db
const urlBuilder = (url) => {
    return baseUrl.value + url
}

const dateBuilder = (isoDate) => {
    return new Date(isoDate).toLocaleString(window.navigator.language || window.navigator.userLanguage)
}

const getFavicon = (url) => {
    let domain = new URL(url)
    return duckduck.value + domain.host + ".ico"
}

// interaction (crud)
const toggleActiveUrl = async (url_id) => {
    toggleResponse.value = await fetch('/toggleActiveUrl', { 
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        method: "POST", 
        body: JSON.stringify({url_id})
    }).then(res => res.json())

    toggleResponse.value.ok ? loadData() : console.log("summfink vent vonk")
}

const deleteShortUrl = async (url_id = urlId.value) => {
    deleteResponse.value = await fetch('/deleteUrl', { 
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
        },
        method: "POST", 
        body: JSON.stringify({url_id})
    }).then(res => res.json())

    deleteResponse.value.ok ? (() => {closeModal(); loadData();})() : console.log("summfink vent vonk")
}

// modal helpers for double confirming deletion
const openModal = (id) => {
    if(id > 0) {
        urlId.value = id
        toggleModalWindow.value = true
        console.log(toggleModalWindow.value)
    }
}
const closeModal = () => {
    urlId.value = 0
    toggleModalWindow.value = false
}

</script>

<template>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
                <table class="w-full border-collapse border block overflow-auto">
                    <thead>
                        <tr>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">#</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Short URL</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Long URL</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Clicks</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Created</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Updated</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Active</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(u, i) in urls" :key="u.id">
                            <td class="border border-slate-200 p-1 text-slate-500 dark:text-slate-400 text-center overflow-hidden">{{ i+1 }}</td>
                            <td class="border border-slate-200 p-1 text-slate-500 dark:text-slate-400 text-center overflow-hidden">
                                <a :href="urlBuilder(u.short_url)" target="_blank" class="text-orange-500 flex overflow-hidden"><span>{{ urlBuilder(u.short_url) }}</span></a>
                            </td>
                            <td class="border border-slate-200 p-1 text-slate-500 dark:text-slate-400 overflow-hidden">
                                <span class="flex items-center text-ellipsis max-w-sm"><img :src="getFavicon(u.long_url)" width="24" class="mr-2"><span>{{ u.long_url }}</span></span>
                            </td>
                            <td class="border border-slate-200 p-1 text-slate-500 dark:text-slate-400 text-center overflow-hidden">{{ u.stat_count }}</td>
                            <td class="border border-slate-200 p-1 text-slate-500 dark:text-slate-400 text-center overflow-hidden">{{ dateBuilder(u.created_at) }}</td>
                            <td class="border border-slate-200 p-1 text-slate-500 dark:text-slate-400 text-center overflow-hidden">{{ dateBuilder(u.updated_at) }}</td>
                            <td class="border border-slate-200 p-1 text-slate-500 dark:text-slate-400 text-center overflow-hidden">
                                <label class="relative inline-flex items-center align-middle cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" :checked="u.active" @change="toggleActiveUrl(u.id)">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                </label>
                            </td>
                            <td class="border border-slate-200 p-1 text-slate-500 dark:text-slate-400 text-center overflow-hidden bg-red-200 dark:bg-red-200">
                                <a href="#" class="flex justify-center h-full w-full text-center align-middle" @click="openModal(u.id)" >
                                    <svg class="h-8 w-8 text-red-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="15" y1="9" x2="9" y2="15" />  <line x1="9" y1="9" x2="15" y2="15" /></svg>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="popup-modal-bg" class="fixed top-0 left-0 right-0 w-full h-full bg-black dark:bg-black bg-opacity-50 dark:bg-opacity-50 z-49 " v-if="toggleModalWindow"></div>
    <div id="popup-modal" tabindex="-1" class="fixed flex items-center justify-center z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full" v-if="toggleModalWindow">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" @click="closeModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
                    <button @click="deleteShortUrl()" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Yes, I'm sure
                    </button>
                    <button @click="closeModal()" data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                </div>
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