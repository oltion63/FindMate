<script setup lang="ts">
import type { BreadcrumbItem } from '@/types/index.js';
import {onMounted, ref} from "vue";
import AppLayout from '@/layouts/AppLayout.vue';
import {Head} from '@inertiajs/vue3';
import DashboardInfoCard from "@/components/dashboard/DashboardInfoCard.vue";
import Chart from "chart.js/auto";
import { Contact, FileUp, FileCheck, UserCog} from 'lucide-vue-next';
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import ReportGenerator from '@/components/dashboard/ReportGenerator.vue'


const props = defineProps({
    EmployeeCount: Number,
    EmployerCount: Number,
    PostCount: Number,
    ApplicationCount: Number,
    Users: Array,
    Posts:Array,
    accepted: Number,
    rejected: Number,
});

const currentTab = ref('users');
const chartRef = ref(null);
const chartRef2 = ref(null);
const mapRef = ref(null);
const markersLayer = ref(null);
onMounted(() => {
    if (chartRef.value) {
        new Chart(chartRef.value, {
            type: "doughnut",
            data: {
                labels: ["Employers", "Employees", "Posts", "Applications"],
                datasets: [{
                    label: "Statistics",
                    data: [props.EmployerCount, props.EmployeeCount, props.PostCount, props.ApplicationCount],
                    backgroundColor: ["#4CAF50", "#2196F3", "#FF9800", "#E91E63"],
                    borderColor: "#fff",
                    borderWidth: 2,
                    hoverOffset: 10, // Adds a hover effect
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Allows resizing
                layout: {
                    padding: 20, // Adds padding around the chart
                },
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom", // Moves labels to the side
                        labels: {
                            align: "start",
                            boxWidth: 20, // Makes color boxes smaller
                            padding: 15, // Adds spacing between labels
                            font: {
                                size: 14, // Increases label font size
                                weight: "bold",
                            },
                        },
                    },
                    tooltip: {
                        enabled: true, // Enables tooltips
                        backgroundColor: "rgba(0, 0, 0, 0.8)", // Darker tooltip
                        bodyFont: {
                            size: 14,
                        },
                    },
                },
            },
        });
    }
    if (mapRef.value) {
        const map = L.map(mapRef.value, {
            minZoom: 8,
            maxZoom: 8
        }).setView([42.6026, 20.9030], 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        markersLayer.value = L.layerGroup().addTo(map);
        const cityData = {};
        const customIcon = L.icon({
            iconUrl: '/storage/images/professional.png',
            iconSize: [26, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        props.Users.forEach(user => {
            if (user.city && user.city.latitude && user.city.longitude) {
                const cityKey = user.city.name;
                if (!cityData[cityKey]) {
                    cityData[cityKey] = {
                        name: user.city.name,
                        count: 0,
                        latitude: user.city.latitude,
                        longitude: user.city.longitude
                    };
                }
                cityData[cityKey].count++;
            }
        });
        Object.values(cityData).forEach(city => {
            L.marker([city.latitude, city.longitude], {icon: customIcon})
                .addTo(markersLayer.value)
                .bindPopup(`<b>${city.name}</b><br>Users: ${city.count}`);
        });

    }
    if (chartRef2.value) {
        new Chart(chartRef2.value, {
            type: "bar",
            data: {
                labels: ['Accepted', 'Rejected'],
                datasets: [{
                    label: "Applications",
                    data: [props.accepted, props.rejected],
                    backgroundColor: ["#4CAF50", "#2196F3"],
                    borderColor: ['#388E3C', '#2196F5'],
                    borderWidth: 1,
                    barThickness: 150,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: true, // Allows resizing
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            color: "#ffffff",  // White color for y-axis labels
                        },
                        grid: {
                            color: "#6b7280", // Grid line color for y-axis (change to desired color)
                            lineWidth: 1,     // Thickness of the grid lines
                        },
                    },
                    x: {
                        barPercentage: 0.1,  // Reduces the width of each bar
                        categoryPercentage: 0.6,  // Adjusts the space between bars
                        ticks: {
                            color: "#ffffff",  // White color for x-axis labels
                        },
                        grid: {
                            color: "#6b7280", // Grid line color for x-axis (change to desired color)
                            lineWidth: 1,     // Thickness of the grid lines
                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                tooltip: {
                    enabled: true, // Enables tooltips
                    backgroundColor: "rgba(0, 0, 0, 0.8)", // Darker tooltip
                    bodyFont: {
                        size: 14,
                    },
                },
            },
        });
    }
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <section class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 xl:max-w-6xl md:max-w-2xl lg:max-w-4xl max-w-xs w-full mx-auto px-4">
            <DashboardInfoCard>
                <template #Information> Employers</template>
                <template #icon>
                    <UserCog />
                </template>
                <template #DbInfo> {{ EmployerCount }}</template>
            </DashboardInfoCard>

            <DashboardInfoCard>
                <template #Information> Employees</template>
                <template #icon>
                    <Contact />
                </template>
                <template #DbInfo> {{ EmployeeCount }}</template>
            </DashboardInfoCard>

            <DashboardInfoCard>
                <template #Information> Posts</template>
                <template #icon>
                    <FileUp />
                </template>
                <template #DbInfo> {{ PostCount }}</template>
            </DashboardInfoCard>

            <DashboardInfoCard>
                <template #Information> Applications</template>
                <template #icon>
                    <FileCheck />
                </template>
                <template #DbInfo> {{ ApplicationCount }}</template>
            </DashboardInfoCard>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6 xl:max-w-6xl max-w-xs md:max-w-2xl lg:max-w-4xl mx-auto px-4">
            <!-- Chart Section -->
            <div class="bg-gradient-to-br from-gray-100 to-gray-300 border border-gray-300
                rounded-2xl shadow-lg p-6 flex justify-center items-center dark:bg-gray-800 dark:border-gray-700
                dark:from-gray-700 dark:to-gray-900 transition-transform transform hover:shadow-xl ">
                <div class="w-full h-96 md:w-full md:h-96">
                    <span class="absolute text-2xl font-bold">Chart</span>
                    <canvas ref="chartRef" class="w-full h-full"></canvas>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-100 to-gray-300 border border-gray-300 rounded-2xl shadow-lg p-8 transition-transform transform  hover:shadow-xl">
                <ReportGenerator />
            </div>
        </section>
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 my-6 xl:max-w-6xl max-w-xs md:max-w-2xl lg:max-w-4xl mx-auto px-4">
            <div class="bg-gray-800 border border-gray-300 rounded-2xl shadow-lg p-6 items-center space-y-4">
                <span class="text-gray-50 text-2xl font-bold">Map of users</span>
                <div ref="mapRef" class="w-full h-96 rounded-xl z-40"></div>
            </div>
            <div id="postsPerDay" class="bg-gray-800 border border-gray-300 rounded-2xl min-h-96 flex flex-col justify-between shadow-lg p-6   space-y-4">
                <span class="text-gray-50 text-xl lg:text-2xl font-bold">Accepted/Rejected Applications</span>
                <canvas ref="chartRef2" class=" w-full h-96"></canvas>
            </div>
        </section>
    </AppLayout>
</template>
