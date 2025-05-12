<script setup lang="ts">

import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    applications:{
        type:Array,
    },
    isEmCvVisible:{
        type:Boolean,
        default:true,
    }
})

const form = useForm({
    status: '',
})
console.log(props.applications)
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-GB");
}
const emit = defineEmits(['update:isEmCvVisible']);

const openModal = (cvUrl, value) => {
    emit('update:isEmCvVisible', {cvUrl, value});
};



</script>

<template>
    <div id="table1" >
        <div class="mx-auto max-w-screen-xl mt-9">
            <div class="bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden rounded-lg">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <span class="font-bold text-white text-xl">Applications</span>
                </div>
                <div class="overflow-x-auto max-h-60">
                    <table class="w-full text-sm text-left text-gray-400 capitalize">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400 sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-3">Position</th>
                            <th scope="col" class="px-4 py-3">Applicant</th>
                            <th scope="col" class="px-4 py-3">Application Date</th>
                            <th scope="col" class="px-4 py-3">Applicant CV</th>
                            <th scope="col" class="px-4 py-3">Accept</th>
                            <th scope="col" class="px-4 py-3">Reject</th>
                        </tr>
                        </thead>
                        <tbody class="max-h-96 overflow-y-auto">
                        <tr v-if="applications.length === 0">
                            <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                                NO APPLICATIONS YET
                            </td>
                        </tr>
                        <tr v-for="application in applications" class="border-b border-gray-700">
                            <th scope="row" class="px-4 py-3 font-medium text-white max-w-60 break-words whitespace-normal">
                                {{ application.post.tittle }}</th>
                            <td class="px-4 py-3">{{application.user.name}}</td>
                            <td class="px-4 py-3">{{formatDate(application.created_at)}}</td>
                            <td class="px-4 py-3">
                                <button
                                    v-if="application.user.cv?.file"
                                    @click="openModal(application.user.cv.file, true)"
                                    class="text-blue-500 underline"
                                >
                                    View CV
                                </button></td>
                            <td class="px-4 py-3">
                                <form :id="'accept-' + application.id" @submit.prevent="form.post(route('application.accept', {id: application.id}))"></form>
                                <button
                                    v-if="application.status === 'pending' || application.status === 'rejected'"
                                    type="submit"
                                    :form="'accept-' + application.id"
                                    class="text-emerald-600 underline"
                                >
                                    Accept
                                </button>
                                <span v-if="application.status === 'accepted'" class="text-emerald-600">
                                    Accepted
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <form :id="'reject-' + application.id" @submit.prevent="form.post(route('application.reject', {id: application.id}))"></form>
                                <button
                                    v-if="application.status === 'pending' || application.status === 'accepted'"
                                    type="submit"
                                    :form="'reject-' + application.id"
                                    class="text-red-600 underline"
                                >
                                    Reject
                                </button>
                                <span v-if="application.status === 'rejected'" class="text-red-500">
                                    Rejected
                                </span>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</template>
