<script setup>
import { ref, onMounted } from 'vue'

const stats = ref([])

onMounted(async () => {
    stats.value = await fetch('/getMyStats').then(res => res.json())
})

const baseUrl = ref(window.location.origin + "/")

const urlBuilder = (url) => {
    return baseUrl.value + url
}

const getIp = (ip, http_x) => http_x ? http_x : ip

const getRobot = (isRobot, name) => isRobot ? name : "-" 

//const getQueryParams = q => q ? q.substring(1).split('&') : "-"

//const getLanguages = l => l ? l.split(',') : "-"

</script>

<template>
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Empty -->
        <div v-if="stats.length == 0" class="flex flex-col justify-center items-center align-middle">
            <svg class="w-6 h-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="18" height="20" fill="none" viewBox="0 0 18 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 2h4a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4m6 0v3H6V2m6 0a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1M5 5h8m-5 5h5m-8 0h.01M5 14h.01M8 14h5"/>
            </svg>
            <p class="mt-2 text-gray-300">Nothing here yet</p>
        </div>

        <!-- Card -->
        <div class="py-4 fadeInAnimation" v-if="stats.length > 0" v-for="(s, i) in stats" :key="s.id" >
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="grid grid-cols-[100px_repeat(5,_1fr)] grid-rows-3 h-52">                
                    <div class="row-span-3 flex justify-center items-center p-0 m-0 font-black font-[sans-serif] text-6xl row-count-number">{{ i+1 }}</div>
                    
                    <div class="col-span-2 flex items-center">
                        <span class="bg-orange-100 text-orange-500 font-medium me-2 px-2.5 py-0.5 rounded ">{{ urlBuilder(s.url.short_url) }}</span>
                    </div>
                    <div class="col-span-2 col-start-2 row-start-2 flex flex-col justify-center">
                        <p>{{ getIp(s.ip_address, s.http_x_forwarded_for) }}</p>
                        <small class="text-gray-300">IP address</small>
                    </div>
                    <div class="col-span-2 col-start-2 row-start-3 flex flex-col justify-center">
                        <p>{{ s.referer ? s.referer : "-" }}</p>
                        <small class="text-gray-300">Referer</small>
                    </div>

                    <div class="col-start-4 row-start-1 flex flex-col justify-center">
                        <div class="flex flex-col justify-center" title="Desktop" v-if="s.is_desktop">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14v4m-4 1h8M1 10h18M2 1h16a1 1 0 0 1 1 1v11a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                            </svg>
                            <small>Desktop</small>
                        </div>
                        <div class="flex flex-col justify-center" title="Phone" v-if="s.is_phone">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 14h12M1 4h12M6.5 16.5h1M2 1h10a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                            </svg>
                            <small>Phone</small>
                        </div>
                        <div class="flex flex-col justify-center" title="Tablet" v-if="s.is_tablet">
                            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 16.5h3M2 1h14a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Z"/>
                            </svg>
                            <small>Tablet</small>
                        </div>
                    </div>                    
                    <div class="col-start-4 row-start-2 flex flex-col justify-center" title="Robot">
                        <p>{{ getRobot(s.is_robot, s.robot_name) }}</p>
                        <small class="text-gray-300">Robot</small>
                    </div>
                    <div class="col-start-4 row-start-3 flex flex-col justify-center" title="Query params">
                        <p>{{ s.query_string ? s.query_string : "-"}}</p>
                        <small class="text-gray-300">Query params</small>
                    </div>

                    <div class="col-start-5 row-start-1 flex flex-col justify-center " title="Device" v-if="s.device">
                        <p>{{ s.device }}</p>
                        <small class="text-gray-300">Device</small>
                    </div>
                    <div class="col-start-5 row-start-2 flex flex-col justify-center " title="Platform" v-if="s.platform">
                        <p>{{ s.platform }}</p>
                        <small class="text-gray-300">Platform</small>
                    </div>
                    <div class="col-start-5 row-start-3 flex flex-col justify-center " title="Browser" v-if="s.browser">
                        <p>{{ s.browser }}</p>
                        <small class="text-gray-300">Browser</small>
                    </div>
                        
                    <div class="col-start-6 row-start-1 flex flex-col justify-center " title="Languages">
                        <p>{{ s.languages }}</p>
                        <small class="text-gray-300">Languages</small>
                    </div>
                    <div class="col-start-6 row-start-2 flex flex-col justify-center " title="Request time">
                        <p>{{ s.request_time }}</p>
                        <small class="text-gray-300">Request time</small>
                    </div>
                    <div class="col-start-6 row-start-3 flex flex-col justify-center " title="Request duration">
                        <p>{{ s.request_duration_in_ms }} ms</p>
                        <small class="text-gray-300">Request duration</small>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</template>