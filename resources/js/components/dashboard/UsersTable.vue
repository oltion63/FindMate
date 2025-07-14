<script setup>
import { useForm } from "@inertiajs/vue3";
import ConfirmationModal from "@/components/ConfirmationModal.vue";
import {ref} from "vue";
import { Trash2 } from 'lucide-vue-next';

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
    <div class="mx-auto w-full max-w-72 sm:max-w-screen-sm md:max-w-screen-md lg:max-w-[90%] px-6 py-6">
        <div class="bg-[#F6F6F6] shadow-md sm:rounded-lg rounded-lg overflow-hidden">
            <div class="flex justify-center p-4">
                <span class="font-semibold text-[#111111] text-base">All Users</span>
            </div>

            <div class="overflow-x-auto max-h-96">
                <table class="w-full text-sm text-left text-[#2F2F2F]">
                    <thead class="text-xs uppercase bg-[#2F2F2F] text-white sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Surname</th>
                        <th class="px-4 py-3">City</th>
                        <th class="px-4 py-3">Address</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Birthday</th>
                        <th class="px-4 py-3">Joined</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E0E0E0]">
                    <tr v-if="Users.length === 0">
                        <td colspan="9" class="text-center px-4 py-3 text-gray-400">No Users Yet</td>
                    </tr>
                    <tr
                        v-for="user in Users.filter(u => u.id !== $page.props.auth.user.id)"
                        :key="user.id"
                        class="bg-white hover:bg-[#FFF8ED] transition"
                    >
                        <td class="px-4 py-3 font-medium text-[#111111]">{{ user.name }}</td>
                        <td class="px-4 py-3">{{ user.lastname }}</td>
                        <td class="px-4 py-3">{{ user.city?.name || '-' }}</td>
                        <td class="px-4 py-3">{{ user.address }}</td>
                        <td class="px-4 py-3">{{ user.email }}</td>
                        <td class="px-4 py-3">{{ user.phone }}</td>
                        <td class="px-4 py-3">{{ formatDate(user.birthday) }}</td>
                        <td class="px-4 py-3">{{ formatDate(user.created_at) }}</td>
                        <td class="px-4 py-3 text-center">
                            <button
                                @click="openDeleteModal(user.id)"
                                class="text-red-600 hover:text-red-800 transition"
                            >
                                <Trash2 class="w-5 h-5 inline" />
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <ConfirmationModal
            :show="showDeleteModal"
            title="Confirm Deletion"
            message="Are you sure you want to delete this user?"
            @close="showDeleteModal = false"
            @confirm="confirmDelete"
        />
    </div>
</template>

