<script setup lang="ts">
import {Head, Link, useForm} from "@inertiajs/vue3";
import {ref, reactive, watch} from "vue";

defineProps({
    cities: {
        type:Array,
    },
    categories:{
        type:Array,
    },
})

const filters = reactive({
    location: "",
    category: "",
    type: [],
    salary: [],
});

const form = useForm({
    location: filters.location,
    category: filters.category,
    type: filters.type,
    salary: filters.salary,
});
const applyFilters = () => {
    form.get(route("jobs.index"), { preserveState: true });
};
const clearFilters = () => {
    form.city = "";
    form.category = "";
    form.type = [];
    form.salary = [];
    form.get(route("jobs.index"), { preserveState: false });
};

</script>

<template>
    <section id="left" class="w-4/5 mx-auto lg:w-1/3 h-fit border-gray-300 border rounded-lg lg:border-1">
        <div class="flex justify-between py-3 px-6">
            <span class="font-bold text-xl">Filter</span>
        </div>
        <div class="px-6 py-2">
            <span class="font-bold">Location</span>
            <select
                v-model="form.location"
                class=" rounded-md border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full bg-transparent">
                <option disabled selected value="">City</option>
                <option v-for="city in cities" :key="city.id" :value="city.id">{{city.name}}</option>
            </select>
        </div>
        <div class="px-6 py-2">
            <span class="font-bold">Category</span>
            <select
                v-model="form.category"
                class="rounded-md border-gray-300 p-2 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full bg-transparent">
                <option disabled selected value="">Category</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
            </select>
        </div>
        <div class="px-6 py-2">
            <span class="font-bold">Job Type</span>
            <ul>
                <li class="space-x-2 flex items-center" v-for="type in ['Full-Time', 'Part-Time', 'Remote']" :key="type">
                    <input type="checkbox" :value="type" v-model="form.type" />
                    <label>{{ type }}</label>
                </li>
            </ul>
        </div>
        <div class="px-6 py-2">
            <span class="font-bold">Expected Salary</span>
            <ul>
                <li class="space-x-2 flex items-center" v-for="range in ['$350-$700', '$700-$1000', '+$1000']" :key="range">
                    <input type="checkbox" :value="range" v-model="form.salary" />
                    <label>{{ range }}</label>
                </li>
            </ul>
        </div>
        <div class="px-6 py-4 grid w-3/4 gap-2 mx-auto">
            <button
                @click="applyFilters"
                class="bg-[#2F2F2F] text-white text-sm px-4 py-2 rounded-md shadow hover:bg-gray-700"
            >
                Apply Filters
            </button>
            <button
                @click="clearFilters"
                class="bg-[#FFCB74] text-black text-sm px-4 py-2 rounded-md shadow hover:text-white"
            >
                Remove Filters
            </button>
        </div>
    </section>
</template>
