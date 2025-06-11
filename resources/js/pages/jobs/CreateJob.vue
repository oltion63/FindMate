<script setup lang="ts">
import {Head, useForm} from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import JobsTextInput from "@/components/jobs/JobsTextInput.vue";
import TextArea from "@/components/jobs/TextArea.vue";
import {ref} from "vue";
import NumberInput from "@/components/jobs/NumberInput.vue";
import InputLabel from "@/components/InputLabel.vue";
import InputError from "@/components/InputError.vue";
import type { BreadcrumbItem } from '@/types/index.js';

const input = ref('');

const props = defineProps({
    authUser: {
        type: Number,
        required: true,
    },
    cities:{
        type:Array,
    },
    categories:{
        type:Array,
    },
    kompania:{
        type: Object,
    },
});
console.log(props.kompania)
const form = useForm({
    user_id: props.authUser,
    tittle: '',
    description: '',
    category_id: '',
    company_id: props.kompania.id,
    type: '',
    salary: '',
    nrWorkers: '',
    location_id: '',
    expiration_date: '',
});
console.log(form)
const submit = () => {
    console.log(form)
    form.post(route('jobs.store'))
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Add Job',
        href: '/jobs.index',
    },
];

</script>

<template>
    <Head title="Add Jobs" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4  ">
            <div class="mx-auto max-w-3xl bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                <h2 class="mb-6 text-3xl font-extrabold text-[#111111]">Add a New Job</h2>
                <form @submit.prevent="submit">
                    <input type="hidden" name="user_id" v-model="form.user_id" />
                    <div class="space-y-6">

                        <!-- Basic Info: Title and Company -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="tittle" class="mb-2 font-semibold text-gray-800" value="Title" />
                                <JobsTextInput
                                    id="tittle"
                                    name="tittle"
                                    placeholder="Job title"
                                    v-model="form.tittle"
                                    required
                                    autofocus
                                    autocomplete="tittle"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                />
                                <InputError class="mt-1 text-red-600 text-sm" :message="form.errors.tittle" />
                            </div>

                            <div>
                                <InputLabel for="company_id" class="mb-2 font-semibold text-gray-800" value="Company" />
                                <JobsTextInput
                                    id="company_id"
                                    name="company_id"
                                    v-model="props.kompania.name"
                                    readonly
                                    class="w-full rounded-md border border-gray-300 bg-gray-100 px-4 py-2 cursor-not-allowed"
                                />
                                <InputError class="mt-1 text-red-600 text-sm" :message="form.errors.company_id" />
                            </div>
                        </div>

                        <!-- Description (full width) -->
                        <div>
                            <InputLabel for="description" class="mb-2 font-semibold text-gray-800" value="Description" />
                            <TextArea
                                placeholder="Job description here"
                                v-model="form.description"
                                id="description"
                                name="description"
                                required
                                autocomplete="description"
                                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                            />
                            <InputError class="mt-1 text-red-600 text-sm" :message="form.errors.description" />
                        </div>

                        <!-- Selection Inputs: Category, Type, Location -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <InputLabel for="category_id" class="mb-2 font-semibold text-gray-800" value="Category" />
                                <select
                                    id="category_id"
                                    name="category_id"
                                    v-model="form.category_id"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                >
                                    <option value="" disabled selected>Select category</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                </select>
                                <InputError class="mt-1 text-red-600 text-sm" :message="form.errors.category_id" />
                            </div>

                            <div>
                                <InputLabel for="type" class="mb-2 font-semibold text-gray-800" value="Type" />
                                <select
                                    id="type"
                                    name="type"
                                    v-model="form.type"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                >
                                    <option value="" disabled selected>Select a type</option>
                                    <option value="Full-Time">Full-Time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Remote">Remote</option>
                                </select>
                                <InputError class="mt-1 text-red-600 text-sm" :message="form.errors.type" />
                            </div>

                            <div>
                                <InputLabel for="location_id" class="mb-2 font-semibold text-gray-800" value="Location" />
                                <select
                                    id="location_id"
                                    name="location_id"
                                    v-model="form.location_id"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                >
                                    <option value="" disabled selected>Select city</option>
                                    <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                                </select>
                                <InputError class="mt-1 text-red-600 text-sm" :message="form.errors.location_id" />
                            </div>
                        </div>

                        <!-- Numbers and Date: Salary, Nr. of Workers, Expiration -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <InputLabel for="salary" class="mb-2 font-semibold text-gray-800" value="Salary" />
                                <NumberInput
                                    id="salary"
                                    name="salary"
                                    type="number"
                                    min="350"
                                    v-model="form.salary"
                                    placeholder="699"
                                    required
                                    autocomplete="salary"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                />
                                <InputError class="mt-1 text-red-600 text-sm" :message="form.errors.salary" />
                            </div>

                            <div>
                                <InputLabel for="nrWorkers" class="mb-2 font-semibold text-gray-800" value="Nr. of Workers" />
                                <NumberInput
                                    id="nrWorkers"
                                    name="nrWorkers"
                                    type="number"
                                    min="1"
                                    v-model="form.nrWorkers"
                                    placeholder="3"
                                    required
                                    autocomplete="nrWorkers"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                />
                                <InputError class="mt-1 text-red-600 text-sm" :message="form.errors.nrWorkers" />
                            </div>

                            <div>
                                <InputLabel for="expiration_date" class="mb-2 font-semibold text-gray-800" value="Expiration Date" />
                                <JobsTextInput
                                    id="expiration_date"
                                    name="expiration_date"
                                    type="date"
                                    v-model="form.expiration_date"
                                    required
                                    autocomplete="expiration_date"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                />
                                <InputError class="mt-1 text-red-600 text-sm" :message="form.errors.expiration_date" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-center">
                        <button
                            type="submit"
                            class="w-full sm:w-auto px-6 py-2  font-semibold text-[#111111] bg-[#FFCB74] rounded-full shadow-md hover:bg-[#e6b864] transition duration-200"
                        >
                            Add Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
