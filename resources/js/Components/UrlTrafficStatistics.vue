<script setup>
import { ref, onMounted } from 'vue'

const stats = ref(0)

onMounted(async () => {
    stats.value = await fetch('/getMyStats').then(res => res.json())
})

const getIp = (ip, http_x) => http_x ? http_x : ip

const getRobot = (isRobot, name) => isRobot ? name ? name : "-" : isRobot

const getQueryParams = q => q ? q.substring(1).split('&') : "-"

const getLanguages = l => l ? l.split(',') : "-"

</script>

<template>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
                <table class="w-full border-collapse border block overflow-auto">
                    <thead>
                        <tr>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">#</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">URL</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">IP address</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center text-top-bottom">Mobile</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center text-top-bottom">Desktop</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center text-top-bottom">Phone</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center text-top-bottom">Tablet</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Robot</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Device</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Platform</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Browser</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Referrer</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Query params</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Browser languages</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Request time</th>
                            <th class="border border-slate-200 font-medium p-4 pt-3 pb-3 dark:text-slate-600 text-center">Request duration (ms)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(s, i) in stats" :key="s.id">
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ i+1 }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ s.url.short_url }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ getIp(s.ip_address, s.http_x_forwarded_for) }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400">{{ s.is_mobile }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400">{{ s.is_desktop }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400">{{ s.is_phone }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400">{{ s.is_tablet }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400">{{ getRobot(s.is_robot, s.robot_name) }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ s.device }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ s.platform }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ s.browser }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ s.referer }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">
                                <ul>
                                    <li v-for="p in getQueryParams(s.query_string)">{{ p }}</li>
                                </ul>
                            </td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">
                                <ul>
                                    <li v-for="l in getLanguages(s.languages)">{{ l }}</li>
                                </ul>
                            </td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ s.request_time }}</td>
                            <td class="border border-slate-200 p-4 text-slate-500 dark:text-slate-400 text-center">{{ s.request_duration_in_ms }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style>
.text-top-bottom {
    writing-mode: vertical-lr;
}
</style>