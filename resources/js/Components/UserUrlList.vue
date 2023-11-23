<script setup>
import { ref, onMounted } from 'vue'
import { vOnClickOutside } from '@vueuse/components';

const urls = ref([])
const toggleResponse = ref(0)
const deleteResponse = ref(false)

const urlId = ref(0)
const toggleModalWindow = ref(false)

const baseUrl = ref(window.location.origin + "/")

const tr = ref({
    clicks: "Clicks",
    created: "Created",
    updated: "Updated"
})

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
    }
}

const closeModal = () => {
    urlId.value = 0
    toggleModalWindow.value = false
}

</script>

<template>
    <div class="pt-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Empty -->
        <div v-if="urls.length == 0" class="flex flex-col justify-center items-center align-middle">
            <svg class="w-6 h-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="20" fill="none" viewBox="0 0 18 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 2h4a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4m6 0v3H6V2m6 0a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1M5 5h8m-5 5h5m-8 0h.01M5 14h.01M8 14h5"/>
            </svg>
            <p class="mt-2 text-gray-300">Nothing here yet</p>
        </div>

        <!-- Card -->
        <div class="py-4 fadeInAnimation url-list" v-if="urls.length > 0" v-for="(u, i) in urls" :key="u.id" >
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Card content -->
                <div class="grid grid-cols-[100px_repeat(3,_1fr)_80px] grid-rows-3 h-36">
                    <div class="row-span-3 flex justify-center items-center p-0 m-0 font-black font-[sans-serif] text-6xl row-count-number">{{ i+1 }}.</div>
                    <div class="col-span-3">
                        <span class="bg-orange-100 text-orange-500 font-medium me-2 px-2.5 py-0.5 rounded ">{{ urlBuilder(u.short_url) }}</span>
                    </div>
                    <div class="col-span-3 col-start-2 row-start-2">
                        <span class="flex items-center text-ellipsis ">
                            <span>{{ u.long_url }}</span>
                        </span>
                    </div>
                    
                    <div class="col-start-2 row-start-3 text-gray-400 text-sm">{{ tr.clicks }}: {{ u.stat_count }}</div>
                    <div class="col-start-3 row-start-3 text-gray-400 text-sm">{{ tr.created }}: {{ dateBuilder(u.created_at) }}</div>
                    <div class="col-start-4 row-start-3 text-gray-400 text-sm">{{ tr.updated }}: {{ dateBuilder(u.updated_at) }}</div>

                    <div class="col-start-5 row-start-1 bg-red-200 hover:bg-red-300">
                        <a href="#" class="flex justify-center h-full w-full text-center items-center align-middle" @click="openModal(u.id)" >
                            <svg class="w-6 h-6 text-red-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                <path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="col-start-5 row-start-2 bg-amber-200 hover:bg-amber-300">
                        <a href="#" class="flex justify-center h-full w-full text-center items-center align-middle" @click="openModal(u.id)" >
                            <svg class="w-6 h-6 text-amber-500 mr-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z"/>
                                <path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z"/>
                            </svg>      
                        </a>
                    </div>
                    <div class="col-start-5 row-start-3 bg-green-200 hover:bg-green-300 flex justify-center gap-0">
                        <label class="relative flex items-center align-middle cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" :checked="u.active" @change="toggleActiveUrl(u.id)">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                        </label>
                    </div>
                </div>
    
            </div>
        </div>    
    </div>

    <Transition>
        <div id="popup-modal-bg" class="fixed top-0 left-0 right-0 w-full h-full bg-black dark:bg-black bg-opacity-50 dark:bg-opacity-50 z-49 " v-if="toggleModalWindow">
            <div id="popup-modal" tabindex="-1" class="fixed flex items-center justify-center z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full" v-if="toggleModalWindow">
                <div class="relative w-full max-w-md max-h-full " v-on-click-outside="closeModal">
                    <div class="relative bg-sky-800 rounded-lg shadow dark:bg-sky-800">
                        <button type="button" @click="closeModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-red-200 hover:text-red-500 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-red-600 dark:hover:text-white" data-modal-hide="popup-modal">
                            <svg class="w-3 h-3 mr-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-6 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-orange-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-300 dark:text-gray-300">Are you sure you want to delete this URL?</h3>
                            <button @click="deleteShortUrl()" data-modal-hide="popup-modal" type="button" class="text-white bg-orange-600 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-orange-300 dark:focus:ring-orange-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Yes, I'm sure
                            </button>
                            <button @click="closeModal()" data-modal-hide="popup-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>