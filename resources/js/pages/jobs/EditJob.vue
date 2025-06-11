<script setup lang="ts">
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/components/InputLabel.vue";
import NumberInput from "@/components/jobs/NumberInput.vue";
import JobsTextInput from "@/components/jobs/JobsTextInput.vue";
import InputError from "@/components/InputError.vue";
import TextArea from "@/components/jobs/TextArea.vue";
import AppLayout from "@/layouts/AppLayout.vue";
import ConfirmationModal from "@/components/ConfirmationModal.vue";
import {ref} from "vue";
import type { BreadcrumbItem } from '@/types/index.js';

const props = defineProps({
    authUser:{
        type:Number,
    },
    post: {
        type:Object,
    },
    cities:{
        type:Array,
    },
    categories:{
        type: Array,
    },
})
const form = useForm({
    user_id: props.authUser,
    tittle: props.post.tittle,
    description: props.post.description,
    category_id: props.post.category_id,
    company_id: props.post.company.id,
    type: props.post.type,
    salary: props.post.salary,
    nrWorkers: props.post.nrWorkers,
    location_id: props.post.location_id,
    expiration_date: props.post.expiration_date,
})
console.log(props.post);

const showDeleteModal = ref(false);

const confirmDelete = () => {
    form.delete(route('jobs.destroy', { id: props.post.id }));
    showDeleteModal.value = false;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit Job',
        href: '/jobs/edit',
    },
];

</script>

<template>
    <Head title="Edit"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-6 ">
            <div class="mx-auto max-w-3xl bg-white rounded-xl shadow-lg border border-gray-200 p-8 ">
                <h2 class="mb-6 text-3xl font-extrabold text-[#111111]">Edit Your Post</h2>
                <form id="editForm" @submit.prevent="form.patch(route('jobs.update', {id: post.id} ))">
                    <input type="hidden" name="user_id" v-model="form.user_id" />
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="tittle" class="mb-2 font-semibold text-gray-800" value="Title"/>
                                <JobsTextInput
                                    placeholder="Job title"
                                    id="tittle"
                                    type="text"
                                    name="tittle"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                    v-model="form.tittle"
                                    required
                                    autofocus
                                    autocomplete="Title"
                                />
                                <InputError class="mt-2 text-red-600 text-sm" :message="form.errors.tittle" />
                            </div>
                            <div>
                                <InputLabel for="company_id" class="mb-2 font-semibold text-gray-800" value="Company"/>
                                <JobsTextInput
                                    id="company_id"
                                    type="text"
                                    name="company_id"
                                    class="w-full rounded-md border border-gray-300 bg-gray-100 px-4 py-2 cursor-not-allowed"
                                    v-model="post.company.name"
                                    readonly
                                    autocomplete="company_id"
                                />
                                <InputError class="mt-2 text-red-600 text-sm" :message="form.errors.company_id"/>
                            </div>
                        </div>
                        <div>
                            <InputLabel for="description" class="mb-2 font-semibold text-gray-800" value="Description"/>
                            <TextArea
                                placeholder="Job description here"
                                v-model="form.description"
                                id="description"
                                name="description"
                                required
                                autocomplete="description"
                                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                            />
                            <InputError class="mt-2 text-red-600 text-sm" :message="form.errors.description"/>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <InputLabel for="category_id" class="mb-2 font-semibold text-gray-800" value="Category"/>
                                <select
                                    name="category_id"
                                    id="category_id"
                                    v-model="form.category_id"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                >
                                    <option :value="props.post.category_id" disabled selected>{{ post.category.name }}</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                </select>
                                <InputError class="mt-2 text-red-600 text-sm" :message="form.errors.category_id"/>
                            </div>
                            <div>
                                <InputLabel for="type" class="mb-2 font-semibold text-gray-800" value="Type"/>
                                <select
                                    name="type"
                                    id="type"
                                    v-model="form.type"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                >
                                    <option :value="props.post.type" disabled selected>{{ props.post.type }}</option>
                                    <option value="Full-Time">Full-Time</option>
                                    <option value="Part-time">Part-time</option>
                                    <option value="Remote">Remote</option>
                                </select>
                                <InputError class="mt-2 text-red-600 text-sm" :message="form.errors.type"/>
                            </div>
                            <div>
                                <InputLabel for="location_id" class="mb-2 font-semibold text-gray-800" value="Location"/>
                                <select
                                    id="location_id"
                                    name="location_id"
                                    v-model="form.location_id"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                >
                                    <option :value="props.post.location_id" disabled selected>{{ post.location.name }}</option>
                                    <option v-for="city in cities" :value="city.id" :key="city.id">{{ city.name }}</option>
                                </select>
                                <InputError class="mt-2 text-red-600 text-sm" :message="form.errors.location_id"/>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div>
                                <InputLabel for="salary" class="mb-2 font-semibold text-gray-800" value="Salary"/>
                                <NumberInput
                                    type="number"
                                    min="350"
                                    id="salary"
                                    name="salary"
                                    v-model="form.salary"
                                    required
                                    autocomplete="salary"
                                    placeholder="699"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                />
                                <InputError class="mt-2 text-red-600 text-sm" :message="form.errors.salary"/>
                            </div>
                            <div>
                                <InputLabel for="nrWorkers" class="mb-2 font-semibold text-gray-800" value="Nr. of Workers"/>
                                <NumberInput
                                    type="number"
                                    id="nrWorkers"
                                    name="nrWorkers"
                                    v-model="form.nrWorkers"
                                    required
                                    autocomplete="nrWorkers"
                                    placeholder="3"
                                    min="1"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                />
                                <InputError class="mt-2 text-red-600 text-sm" :message="form.errors.nrWorkers"/>
                            </div>
                            <div>
                                <InputLabel for="expiration_date" class="mb-2 font-semibold text-gray-800" value="Expiration Date"/>
                                <JobsTextInput
                                    placeholder="Expiration Date"
                                    id="expiration_date"
                                    type="date"
                                    v-model="form.expiration_date"
                                    required
                                    autocomplete="expiration_date"
                                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FFCB74]"
                                />
                                <InputError class="mt-2 text-red-600 text-sm" :message="form.errors.expiration_date"/>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="flex space-x-4 mt-8">
                    <button
                        form="editForm"
                        type="submit"
                        class="inline-flex items-center px-4 py-2 text-white bg-[#FFCB74] rounded-lg font-semibold hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-300"
                    >
                        Update
                    </button>
                    <button
                        type="button"
                        @click="showDeleteModal = true"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 focus:ring-4 focus:ring-yellow-300"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <ConfirmationModal
            :show="showDeleteModal"
            title="Confirm Deletion"
            message="Are you sure you want to delete this post?"
            @close="showDeleteModal = false"
            @confirm="confirmDelete"
        />
    </AppLayout>
</template>

