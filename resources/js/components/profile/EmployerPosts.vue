<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
const props = defineProps({
    employerPosts: {
        type: Array,
    },
})

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-GB");
}
</script>

<template>
    <div id="table1" class="mb-6">
        <div class="mx-auto max-w-screen-xl mt-9">
            <div class="bg-[#F6F6F6] relative shadow-md sm:rounded-lg overflow-x-auto w-full rounded-lg">
                <div class="flex justify-center p-4">
                    <span class="font-semibold text-[#111111] text-base">Your Posts</span>
                </div>
                <div class="overflow-x-auto max-h-60">
                    <table class="w-full text-sm text-left text-[#2F2F2F] capitalize">
                        <thead class="text-xs uppercase bg-[#2F2F2F] text-white sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-3">Position</th>
                            <th scope="col" class="px-4 py-3">Type</th>
                            <th scope="col" class="px-4 py-3">Expires At</th>
                            <th scope="col" class="px-4 py-3">Available Slots</th>
                            <th scope="col" class="px-4 py-3">Salary</th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="employerPosts.length === 0">
                            <td colspan="6" class="px-4 py-3 text-center text-[#2F2F2F]">No saved posts</td>
                        </tr>
                        <tr
                            v-for="employerPost in employerPosts"
                            :key="employerPost.id"
                            class="border-b border-[#D4D4D4]"
                        >
                            <th
                                scope="row"
                                class="px-4 py-3 font-medium text-[#111111] max-w-60 break-words whitespace-normal"
                            >
                                {{ employerPost.tittle }}
                            </th>
                            <td class="px-4 py-3">{{ employerPost.type }}</td>
                            <td class="px-4 py-3">{{ formatDate(employerPost.expiration_date) }}</td>
                            <td class="px-4 py-3">{{ employerPost.nrWorkers }}</td>
                            <td class="px-4 py-3">{{ employerPost.salary }}</td>
                            <td class="px-4 py-3">
                                <Link
                                    :href="route('jobs.show', { id: employerPost.id })"
                                    class="text-[#111111] underline hover:text-red-600"
                                >
                                    See More
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

