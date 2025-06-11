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
    <div id="table1">
        <div class="mx-auto max-w-screen-xl mt-9">
            <div class="bg-[#F6F6F6] relative shadow-md sm:rounded-lg overflow-x-auto w-full rounded-lg scroll-smooth">
                <div class="flex justify-center p-4">
                    <span class="font-semibold text-[#111111] text-base">Applications</span>
                </div>
                <div class="overflow-x-auto max-h-96 min-h-60 scroll-smooth">
                    <table class="w-full text-sm text-left text-[#2F2F2F] capitalize">
                        <thead class="text-xs uppercase bg-[#2F2F2F] text-white sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-3">Position</th>
                            <th scope="col" class="px-4 py-3">Applicant</th>
                            <th scope="col" class="px-4 py-3">Application Date</th>
                            <th scope="col" class="px-4 py-3">Applicant CV</th>
                            <th scope="col" class="px-4 py-3">Accept</th>
                            <th scope="col" class="px-4 py-3">Reject</th>
                            <th scope="col" class="px-4 py-3">Chat</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="applications.length === 0" class="h-48">
                            <td colspan="7" class="px-4 py-3 text-center text-[#2F2F2F] align-middle">
                                No applications yet
                            </td>
                        </tr>
                        <tr
                            v-for="application in applications"
                            :key="application.id"
                            class="border-b border-[#D4D4D4]"
                        >
                            <th
                                scope="row"
                                class="px-4 py-3 font-medium text-[#111111] max-w-60 break-words whitespace-normal"
                            >
                                {{ application.post.tittle }}
                            </th>
                            <td class="px-4 py-3">{{ application.user.name }}</td>
                            <td class="px-4 py-3">{{ formatDate(application.created_at) }}</td>
                            <td class="px-4 py-3">
                                <button
                                    v-if="application.user.cv?.file"
                                    @click="openModal(application.user.cv.file, true)"
                                    class="text-[#FFCB74] underline"
                                >
                                    View CV
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <form
                                    :id="'accept-' + application.id"
                                    @submit.prevent="form.post(route('application.accept', { id: application.id }))"
                                ></form>
                                <button
                                    v-if="application.status === 'pending' || application.status === 'rejected'"
                                    type="submit"
                                    :form="'accept-' + application.id"
                                    class="text-[#2F2F2F] underline"
                                >
                                    Accept
                                </button>
                                <span v-if="application.status === 'accepted'" class="text-emerald-600 font-medium">
                    Accepted
                  </span>
                            </td>
                            <td class="px-4 py-3">
                                <form
                                    :id="'reject-' + application.id"
                                    @submit.prevent="form.post(route('application.reject', { id: application.id }))"
                                ></form>
                                <button
                                    v-if="application.status === 'pending' || application.status === 'accepted'"
                                    type="submit"
                                    :form="'reject-' + application.id"
                                    class="text-red-600 underline"
                                >
                                    Reject
                                </button>
                                <span v-if="application.status === 'rejected'" class="text-red-600 font-medium">
                    Rejected
                  </span>
                            </td>
                            <td class="px-4 py-3">
                                <a
                                    v-if="application.room_id"
                                    :href="`/chat/room/${application.room_id}`"
                                    class="text-blue-500 underline"
                                >
                                    Open Chat
                                </a>
                                <span v-else class="text-gray-500">Not available</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

