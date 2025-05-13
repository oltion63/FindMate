<script setup>
import { useForm } from "@inertiajs/vue3";
import ConfirmationModal from "@/components/ConfirmationModal.vue";
import {ref} from "vue";

const props = defineProps({
    Users: Array,
});
const form = useForm({
    id: '',
});

const showDeleteModal = ref(false);
const selectedUserId = ref(null);
const confirmDelete = () => {
    if (selectedUserId.value !== null) {
        form.delete(route('user.delete', { id: selectedUserId.value }));
        showDeleteModal.value = false;
        selectedUserId.value = null;
    }
};
const openDeleteModal = (id) => {
    selectedUserId.value = id;
    showDeleteModal.value = true;
};
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString("en-GB");
}
</script>

<template>
    <div id="table1" class="">
        <div class="">
            <div class="bg-white dark:bg-gray-800 overflow-hidden">
                <div class="overflow-x-auto max-h-96">
                    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                        <thead class="text-xs text-gray-100 uppercase bg-gray-700 sticky top-0 z-10">
                        <tr>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Surname</th>
                            <th scope="col" class="px-6 py-3">City</th>
                            <th scope="col" class="px-6 py-3">Address</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Phone</th>
                            <th scope="col" class="px-6 py-3">Birthday</th>
                            <th scope="col" class="px-6 py-3">Joined At</th>
                            <th scope="col" class="px-6 py-3 text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="Users.length === 0">
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No Users Yet
                            </td>
                        </tr>
                        <tr v-for="user in Users.filter(u => u.id !== $page.props.auth.user.id)" :key="user.id" class="border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ user.name }}</td>
                            <td class="px-6 py-4">{{ user.lastname }}</td>
                            <td class="px-6 py-4">{{ user.city?.name }}</td>
                            <td class="px-6 py-4">{{ user.address }}</td>
                            <td class="px-6 py-4">{{ user.email }}</td>
                            <td class="px-6 py-4">{{ user.phone }}</td>
                            <td class="px-6 py-4">{{ formatDate(user.birthday) }}</td>
                            <td class="px-6 py-4">{{ formatDate(user.created_at) }}</td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    type="button"
                                    @click="openDeleteModal(user.id)"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                                    Delete
                                </button>

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
        message="Are you sure you want to delete this user?"
        @close="showDeleteModal = false"
        @confirm="confirmDelete"
    />
</template>
