<script setup>
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({
    rooms: Array,
    auth: Object,
});

const handleRoomClick = (id) => {
    window.location.href = `/chat/room/${id}`;
};
</script>

<template>
    <AppLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">My Chat Rooms</h1>
            <ul class="space-y-2">
                <li
                    v-for="room in rooms"
                    :key="room.id"
                    class="cursor-pointer p-4 border rounded hover:bg-gray-100"
                    @click="handleRoomClick(room.id)"
                >
                    {{ room.title || `Room #${room.id}` }}
                </li>
            </ul>
        </div>
    </AppLayout>
</template>
