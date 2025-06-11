<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    employeeApplications: {
        type: Array,
    },
})

const form = useForm({
    id:'',
})

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-GB");
}
</script>

<template>
    <div id="table1">
        <div class="mx-auto max-w-screen-xl mt-9">
            <div class="bg-[#F6F6F6] relative shadow-md sm:rounded-lg overflow-x-auto w-full rounded-lg border border-[#E0E0E0]">
                <div class="flex justify-center p-4">
                    <span class="font-semibold text-[#111111] text-base">Your Applications</span>
                </div>
                <div class="overflow-x-auto max-h-60">
                    <table class="w-full text-sm text-left text-[#2F2F2F] capitalize">
                        <thead class="text-xs uppercase bg-[#2F2F2F] text-white sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-3">Position</th>
                            <th scope="col" class="px-4 py-3">Company</th>
                            <th scope="col" class="px-4 py-3">Application Date</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3"></th>
                            <th scope="col" class="px-4 py-3">Chat</th>
                        </tr>
                        </thead>
                        <tbody class="overflow-y-auto max-h-96 divide-y divide-[#E0E0E0]">
                        <tr v-if="employeeApplications.length === 0">
                            <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                                NO APPLICATIONS YET
                            </td>
                        </tr>
                        <tr v-for="application in employeeApplications" class="bg-white hover:bg-[#FFF8ED] transition">
                            <th
                                scope="row"
                                class="px-4 py-3 font-medium text-[#111111] max-w-60 break-words whitespace-normal"
                            >
                                {{ application.post.tittle }}
                            </th>
                            <td class="px-4 py-3">{{ application.post.company?.name }}</td>
                            <td class="px-4 py-3">{{ formatDate(application.created_at) }}</td>
                            <td
                                :class="{
                    'text-green-600': application.status === 'accepted',
                    'text-red-600': application.status === 'rejected',
                    'text-[#2F2F2F]': application.status !== 'accepted' && application.status !== 'rejected'
                  }"
                                class="px-4 py-3"
                            >
                                {{ application.status }}
                            </td>
                            <td class="px-4 py-3">
                                <form
                                    :id="'delete-' + application.id"
                                    class="hidden"
                                    @submit.prevent="form.delete(route('application.delete', { id: application.id }))"
                                ></form>
                                <button
                                    type="submit"
                                    :form="'delete-' + application.id"
                                    class="bg-[#FFCB74] text-[#111111] hover:bg-[#F6F6F6] hover:underline transition rounded-lg text-sm px-4 py-2"
                                >
                                    Cancel
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <a
                                    v-if="application.room_id"
                                    :href="`/chat/room/${application.room_id}`"
                                    class="text-blue-600 underline hover:text-blue-800"
                                >
                                    Open Chat
                                </a>
                                <span v-else class="text-gray-400">Not available</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
