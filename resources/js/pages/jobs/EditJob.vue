<script setup>
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/components/InputLabel.vue";
import NumberInput from "@/components/jobs/NumberInput.vue";
import JobsTextInput from "@/components/jobs/JobsTextInput.vue";
import InputError from "@/components/InputError.vue";
import TextArea from "@/components/jobs/TextArea.vue";
import AppLayout from "@/layouts/AppLayout.vue";
import ConfirmationModal from "@/components/ConfirmationModal.vue";
import {ref} from "vue";

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
</script>

<template>
    <Head title="Edit"/>
    <AppLayout>
        <template #header>
            <div class="absolute hidden lg:block top-20 justify-between items-end">
                <Link
                    :href="route('jobs.show', {id: post.id})"
                    class="w-fit flex"
                >
                    <!-- SVG icon here unchanged -->
                    <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 869.959 869.958" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M146.838,484.584c10.271,10.395,23.804,15.6,37.347,15.6c13.329,0,26.667-5.046,36.897-15.155 c20.625-20.379,20.825-53.62,0.445-74.245l-41.688-42.191h423.78c88.963,0,161.34,72.376,161.34,161.339v4.32 c0,43.096-16.782,83.61-47.255,114.084c-20.503,20.502-20.503,53.744,0,74.246c10.251,10.251,23.688,15.377,37.123,15.377 c13.435,0,26.872-5.125,37.123-15.377c50.305-50.306,78.009-117.188,78.009-188.331v-4.32c0-71.142-27.704-138.026-78.009-188.331 c-50.306-50.305-117.189-78.009-188.331-78.009h-424.99l42.25-41.747c20.625-20.379,20.825-53.62,0.445-74.245 c-20.376-20.624-53.618-20.825-74.244-0.445L15.601,277.068c-9.905,9.787-15.517,23.107-15.6,37.03 c-0.084,13.924,5.367,27.31,15.154,37.215L146.838,484.584z"></path> </g> </g></svg>
                </Link>
            </div>
        </template>
        <div class="p-6 bg-[#F6F6F6] min-h-screen">
            <div class="mx-auto max-w-3xl bg-white rounded-xl shadow-lg border border-gray-200 p-8 mt-16">
                <h2 class="mb-6 text-3xl font-extrabold text-[#111111]">Edit Your Post</h2>
                <form id="editForm" @submit.prevent="form.patch(route('jobs.update', {id: post.id} ))">
                    <input type="hidden" name="user_id" v-model="form.user_id" />
                    <div class="space-y-10">
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
                        class="inline-flex items-center px-6 py-3 text-white bg-[#FFCB74] rounded-lg font-semibold hover:bg-yellow-400 focus:ring-4 focus:ring-yellow-300"
                    >
                        Update
                    </button>
                    <button
                        type="button"
                        @click="showDeleteModal = true"
                        class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 focus:ring-4 focus:ring-yellow-300"
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

