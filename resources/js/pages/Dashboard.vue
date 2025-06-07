<script setup>
import {onMounted, ref} from "vue";
import AppLayout from '@/layouts/AppLayout.vue';
import {Head} from '@inertiajs/vue3';
import DashboardInfoCard from "@/components/dashboard/DashboardInfoCard.vue";
import Chart from "chart.js/auto";
import UsersTable from "@/components/dashboard/UsersTable.vue";
import PostsTable from "@/components/dashboard/PostsTable.vue";
import "leaflet/dist/leaflet.css";
import L from "leaflet";

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

</script>

<template>
    <Head title="Dashboard"/>
    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 xl:max-w-6xl md:max-w-2xl lg:max-w-4xl max-w-xs w-full mx-auto px-4">
            <DashboardInfoCard>
                <template #Information> Employers</template>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="white" class="h-5 w-5 md:h-10 md:w-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </template>
                <template #DbInfo> {{ EmployerCount }}</template>
            </DashboardInfoCard>

            <DashboardInfoCard>
                <template #Information> Employees</template>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="white" class="h-5 w-5 md:h-10 md:w-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                    </svg>
                </template>
                <template #DbInfo> {{ EmployeeCount }}</template>
            </DashboardInfoCard>

            <DashboardInfoCard>
                <template #Information> Posts</template>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="white" class="h-5 w-5 md:h-10 md:w-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                    </svg>
                </template>
                <template #DbInfo> {{ PostCount }}</template>
            </DashboardInfoCard>

            <DashboardInfoCard>
                <template #Information> Applications</template>
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="white" class="h-5 w-5 md:h-10 md:w-10">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.042 21.672 13.684 16.6m0 0-2.51 2.225.569-9.47 5.227 7.917-3.286-.672Zm-7.518-.267A8.25 8.25 0 1 1 20.25 10.5M8.288 14.212A5.25 5.25 0 1 1 17.25 10.5"/>
                    </svg>
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
                    <span class="absolute text-gray-50 text-2xl font-bold">Chart</span>
                    <canvas ref="chartRef" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Elegant Text Explanation -->
            <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700
                rounded-2xl shadow-lg p-8 transition-transform transform  hover:shadow-xl">
                <h3 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white tracking-wide">
                    Dashboard Overview
                </h3>

                <!-- Elegant Divider -->
                <div class="w-16 border-t-4 border-yellow-500 my-4"></div>

                <p class="mt-4 text-sm md:text-base lg:text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                    This interactive chart provides a **visual breakdown** of key platform statistics, offering
                    insights into overall user engagement and activity.
                </p>

                <!-- Information List with Numbers -->
                <ul class="mt-6 space-y-3 text-gray-800 dark:text-gray-300">
                    <li class="flex items-center">
                        <span class="text-sm md:text-base lg:text-lg"> <strong>Employers</strong> - Registered on the platform. </span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-sm md:text-base lg:text-lg"> <strong>Employees</strong> - Active job seekers. </span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-sm md:text-base lg:text-lg"> <strong>Posts</strong> - Total job listings currently available. </span>
                    </li>
                    <li class="flex items-center">
                        <span class="text-sm md:text-base lg:text-lg"> <strong>Applications</strong> - Submitted job applications. </span>
                    </li>
                </ul>

                <p class="mt-6 text-sm md:text-base lg:text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                    These insights help in understanding the **platform's activity trends** over time, ensuring better
                    decision-making for both employers and employees.
                </p>
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
<section class="xl:max-w-6xl max-w-xs md:max-w-2xl lg:max-w-4xl mx-auto px-4">
        <section class="my-6 bg-gray-800 shadow-md rounded-lg text-white pt-2 border-t border-gray-500 ">
            <button
                class="mx-4 my-2 text-xl font-semibold px-2 py-1 transition-all duration-300 rounded-md"
                @click="currentTab = 'users'"
                :class="{
            'bg-blue-500 text-white shadow-md ': currentTab === 'users',
            'hover:bg-gray-400  ': currentTab !== 'users'
        }">
                Users
            </button>
            <button
                class="mx-4 text-xl font-semibold px-2 py-1 transition-all duration-300 rounded-md"
                @click="currentTab = 'posts'"
                :class="{
            'bg-blue-500 text-white shadow-md ': currentTab === 'posts',
            'hover:bg-gray-400': currentTab !== 'posts'
        }">
                Posts
            </button>
            <UsersTable :Users="Users" v-if="currentTab === 'users'"/>
            <PostsTable :Posts="Posts" v-if="currentTab === 'posts'"/>
        </section>
</section>



    </AppLayout>
</template>
