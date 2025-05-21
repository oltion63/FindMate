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
    <Head title="Add Jobs"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <main class="p-4">
            <div class="py-4 px-4 mx-auto max-w-2xl lg:py-8 bg-white border-gray-200 border rounded-lg mt-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 ">Add a new job</h2>
                <form @submit.prevent="submit">
                    <input type="hidden" name="user_id" v-model="form.user_id">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div >
                            <InputLabel for="tittle" class="mb-1" value="Tittle"/>
                            <JobsTextInput
                                placeholder="Job tittle"
                                id="tittle"
                                type="text"
                                name="tittle"
                                class="mt-1 block w-full"
                                v-model="form.tittle"
                                required
                                autofocus
                                autocomplete="tittle"
                            />
                            <InputError class="mt-2" :message="form.errors.tittle"/>
                        </div>
                        <div >
                            <InputLabel for="company_id" class="mb-1" value="Company"/>
                            <JobsTextInput
                                id="company_id"
                                type="text"
                                name="company_id"
                                class="mt-1 block w-full"
                                v-model="props.kompania.name"
                                readonly
                            />
                            <InputError class="mt-2" :message="form.errors.company_id"/>
                        </div>
                        <div class="sm:col-span-2">
                            <InputLabel for="description" class="mb-1" value="Description"/>
                            <TextArea
                                placeholder="Job description here"
                                v-model="form.description"
                                id="description"
                                name="description"
                                required
                                autocomplete="description"
                            />
                            <InputError class="mt-2" :message="form.errors.description"/>
                        </div>
                        <div>
                            <InputLabel for="category_id" class="mb-1" value="Category"/>
                            <select
                                name="category_id"
                                id="category_id"
                                ref="input"
                                v-model="form.category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                                <option value="" disabled selected>Select category</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.category_id"/>
                        </div>
                        <div>
                            <InputLabel for="type" class="mb-1" value="Type"/>
                            <select
                                name="type"
                                id="type"
                                ref="input"
                                v-model="form.type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                                <option value="" disabled selected>Select a type</option>
                                <option value="Full-Time">Full-Time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Remote">Remote</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.type"/>
                        </div>
                        <div class="w-full">
                            <InputLabel for="salary" class="mb-1" value="Salary"/>
                            <NumberInput
                                type="number"
                                min="350"
                                id="salary"
                                name="salary"
                                v-model="form.salary"
                                required
                                autocomplete="salary"
                                placeholder="699"
                            />
                            <InputError class="mt-2" :message="form.errors.salary"/>
                        </div>
                        <div class="w-full">
                            <InputLabel for="nrWorkers" class="mb-1" value="Nr. of Workers"/>
                            <NumberInput
                                type="number"
                                id="nrWorkers"
                                name="nrWorkers"
                                v-model="form.nrWorkers"
                                required
                                autocomplete="nrWorkers"
                                placeholder="3"
                                min="1"
                            />
                            <InputError class="mt-2" :message="form.errors.nrWorkers"/>
                        </div>
                        <div>
                            <InputLabel for="location_id" class="mb-1" value="Location"/>
                            <select
                                id="location_id"
                                name="location_id"
                                ref="input"
                                v-model="form.location_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2">
                                <option value="" disabled selected>Select city</option>
                                <option v-for="city in cities" :value="city.id" :key="city.id">{{city.name}}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.location_id"/>
                        </div>
                        <div class="w-full">
                            <InputLabel for="expiration_date" class="mb-1" value="Expiration Date"/>
                            <JobsTextInput
                                placeholder="Expiration Date"
                                id="expiration_date"
                                type="date"
                                class="mt-1 block w-full"
                                v-model="form.expiration_date"
                                required
                                autocomplete="expiration_date"
                            />
                            <InputError class="mt-2" :message="form.errors.expiration_date"/>
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-gradient-to-br from-blue-900 to-blue-500 hover:bg-gradient-to-bl rounded-lg">
                        Add Job
                    </button>
                </form>
            </div>
        </main>
    </AppLayout>
</template>
