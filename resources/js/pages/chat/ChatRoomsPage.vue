<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {Link, Head} from '@inertiajs/vue3'

const props = defineProps({
    rooms: Array,
    auth: Object,
    default: () => []
});

</script>

<template>
    <Head title="Chats"/>
    <AppLayout>
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">My Chat Rooms</h1>
            <div v-if="rooms.length === 0" class="text-gray-500">
                You have no chat rooms yet.
            </div>
            <ul v-else class="space-y-2">
                <li
                    v-for="room in rooms"
                    :key="room.id"
                    class="p-0"
                >
                    <Link
                        :href="route('room', { id: room.id })"
                        class="block p-4 border rounded hover:bg-gray-100 transition"
                    >
                        {{ room.title || `Room #${room.id}` }}
                    </Link>
                </li>
            </ul>
        </div>
    </AppLayout>
</template>
