<script setup lang="ts">
import {Link} from "@inertiajs/vue3";
import {useForm} from "@inertiajs/vue3";

import {ref} from "vue";

const props = defineProps({
    savedPosts: {
        type: Array,
    },
})
const form = useForm({
    savedPost_id: "",
})
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-GB");
}
const showDeleteModal = ref(false);
const selectedPostId = ref(null);
const confirmDelete = () => {
    if (selectedPostId.value !== null) {
        form.delete(route('jobs.deleteSaved', { id: selectedPostId.value }));
        showDeleteModal.value = false;
        selectedPostId.value = null;
    }
};
const openDeleteModal = (id) => {
    selectedPostId.value = id;
    showDeleteModal.value = true;
};

</script>

<template>
    <div id="table1" class="mb-6">
        <div class="mx-auto max-w-screen-xl mt-9">
            <div class="bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden rounded-lg">
                <div
                    class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <span class="font-bold text-white text-xl">Saved Posts</span>
                </div>
                <div class="overflow-x-auto max-h-60">
                    <table class="w-full text-sm text-left text-gray-400 capitalize">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400 sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-4 py-3">Position</th>
                            <th scope="col" class="px-4 py-3">Company</th>
                            <th scope="col" class="px-4 py-3">Expires At</th>
                            <th scope="col" class="px-4 py-3">Remaining Slots</th>
                            <th scope="col" class="px-4 py-3"></th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                        </thead>
                        <tbody class="overflow-y-auto max-h-96">
                        <tr v-if="savedPosts.length === 0">
                            <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                                NO SAVED POSTS
                            </td>
                        </tr>
                        <tr v-for="savedPost in savedPosts" class="border-b border-gray-700">
                            <th scope="row"
                                class="px-4 py-3 font-medium text-white max-w-60 break-words whitespace-normal">
                                {{ savedPost.post.tittle }}
                            </th>
                            <td class="px-4 py-3">{{ savedPost.post.company?.name }}</td>
                            <td class="px-4 py-3">{{ formatDate(savedPost.post.expiration_date) }}</td>
                            <td class="px-4 py-3">{{savedPost.post.nrWorkers}}</td>
                            <td class="px-4 py-3 flex items-center justify-start">
                                <Link
                                    :href="route('jobs.show', { id: savedPost.post.id })"
                                    class="underline text-blue-500"
                                >
                                    See More
                                </Link>
                            </td>
                            <td class="px-4 py-3">
                                <form class="hidden" id="unsavePost"  @submit.prevent="">
                                </form>
                                <button type="button"
                                        @click="openDeleteModal(savedPost.id)">
                                    <svg width="18px" height="18px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 11V17" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>
