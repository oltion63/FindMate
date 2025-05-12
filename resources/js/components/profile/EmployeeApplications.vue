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
    <div id="table1" >
        <div class="mx-auto max-w-screen-xl mt-9">
            <div class="bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden rounded-lg">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <span class="font-bold text-white text-xl">Your Applications</span>
                </div>
                <div class="overflow-x-auto max-h-60">
                    <table class="w-full text-sm text-left text-gray-400 capitalize">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400 sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-3">Position</th>
                            <th scope="col" class="px-4 py-3">Company</th>
                            <th scope="col" class="px-4 py-3">Application Date</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                        </thead>
                        <tbody class="overflow-y-auto max-h-96">
                        <tr v-if="employeeApplications.length === 0">
                            <td colspan="5" class="px-4 py-3 text-center text-gray-400">
                                NO APPLICATIONS YET
                            </td>
                        </tr>
                        <tr v-for="application in employeeApplications" class="border-b border-gray-700">
                            <th scope="row"
                                class="px-4 py-3 font-medium text-white max-w-60 break-words whitespace-normal">
                                {{ application.post.tittle }}
                            </th>
                            <td class="px-4 py-3">{{ application.post.company?.name }}</td>
                            <td class="px-4 py-3">{{ formatDate(application.created_at) }}</td>
                            <td :class="{
                                'text-emerald-600': application.status === 'accepted',
                                'text-red-600': application.status === 'rejected'
                                }"
                                class="px-4 py-3">
                                {{application.status}}
                            </td>
                            <td class="px-4 py-3 text-blue-500">
                                <form id="delete" class="hidden" @submit.prevent="form.delete(route('application.delete', {id: application.id}))"></form>
                                <button
                                    type="submit"
                                    form="delete"
                                    class="text-blue-500 "
                                >
                                    Cancel
                                </button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
