<script setup>
import {useForm, Link} from "@inertiajs/vue3";
import {ref} from "vue";
import ConfirmationModal from "@/components/ConfirmationModal.vue";

const props = defineProps({
    Posts:Array,
});
const form = useForm({
    id:''
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
    <div id="table1" >
        <div class="mx-auto w-full ">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">

                <div class="overflow-x-auto max-h-96">
                    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                        <thead class="text-xs text-gray-100 uppercase bg-gray-700 sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-6 py-3">Titulli</th>
                            <th scope="col" class="px-6 py-3">Kompania</th>
                            <th scope="col" class="px-6 py-3">Expiration</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th colspan="5" class="px-6 py-3 text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="Posts.length === 0">
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No Posts Yet
                            </td>
                        </tr>
                        <tr v-for="post in Posts" :key="post.id" class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ post.tittle }}</td>
                            <td class="px-6 py-4">{{ post.company.name}}</td>
                            <td class="px-6 py-4">{{ post.expiration_date }}</td>
                            <td class="px-6 py-4">{{ post.user.email }}</td>

                            <td class=" py-4 text-center">
                                <button
                                    type="button"
                                    @click="openDeleteModal(post.id)"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                    Delete
                                </button>

                            </td>
                            <td class="px-6 py-4 text-center">
                                <Link
                                    :href="route('jobs.show', {id: post.id})"
                                    class="text-blue-500 underline "
                                >
                                    Details
                                </Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
</template>
