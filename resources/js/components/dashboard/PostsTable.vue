<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import ConfirmationModal from "@/components/ConfirmationModal.vue";
import { Trash2 } from 'lucide-vue-next';

const props = defineProps({
    Posts: Array,
});

const form = useForm({
    id: ''
});

const showDeleteModal = ref(false);
const selectedPostId = ref(null);

const confirmDelete = () => {
    if (selectedPostId.value !== null) {
        form.delete(route('post.delete', { id: selectedPostId.value }));
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
    <div class="my-6 pb-6 mx-auto w-full max-w-72 sm:max-w-screen-sm md:max-w-screen-md lg:max-w-[90%] px-6">
        <div class="bg-[#F6F6F6] shadow-md sm:rounded-lg rounded-lg overflow-hidden">
            <div class="flex justify-center p-4">
                <span class="font-semibold text-[#111111] text-base">Posted Jobs</span>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto max-h-96">
                <table class="w-full text-sm text-left text-[#2F2F2F]">
                    <thead class="text-xs uppercase bg-[#2F2F2F] text-white sticky top-0 z-10">
                    <tr>
                        <th scope="col" class="px-4 py-3">Title</th>
                        <th scope="col" class="px-4 py-3">Company</th>
                        <th scope="col" class="px-4 py-3">Expiration</th>
                        <th scope="col" class="px-4 py-3">Email</th>
                        <th scope="col" class="px-4 py-3 text-center" colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E0E0E0]">
                    <tr v-if="Posts.length === 0">
                        <td colspan="6" class="px-4 py-3 text-center text-gray-400">
                            No Posts Yet
                        </td>
                    </tr>
                    <tr v-for="post in Posts" :key="post.id" class="bg-white hover:bg-[#FFF8ED] transition">
                        <td class="px-4 py-3 font-medium text-[#111111] max-w-60 break-words whitespace-normal">
                            {{ post.tittle }}
                        </td>
                        <td class="px-4 py-3">{{ post.company.name }}</td>
                        <td class="px-4 py-3">{{ post.expiration_date }}</td>
                        <td class="px-4 py-3">{{ post.user.email }}</td>
                        <td class="px-4 py-3 text-center">
                            <button
                                type="button"
                                @click="openDeleteModal(post.id)"
                                class="hover:scale-110 transition"
                            >
                                <Trash2 class="w-5 h-5 text-red-600" />
                            </button>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <Link
                                :href="route('jobs.show', { id: post.id })"
                                class="underline text-blue-600 hover:text-blue-800"
                            >
                                Details
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <ConfirmationModal
            :show="showDeleteModal"
            title="Confirm Deletion"
            message="Are you sure you want to delete this post?"
            @close="showDeleteModal = false"
            @confirm="confirmDelete"
        />
    </div>
</template>
