<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import echo from '@/echo.js'

const props = defineProps({
    currentRoomId: Number,
    room: Object,
})

const emit = defineEmits(['switchRoom'])

const rooms = ref([])
const unreadRooms = ref(new Set())

const fetchRooms = async () => {
    try {
        const response = await axios.get('/chat/list')
        rooms.value = response.data.rooms

        rooms.value.forEach((room) => {
            echo.private(`chat.room.${room.id}`)
                .listen('MessageSent', (e) => {
                    if (room.id !== props.currentRoomId) {
                        unreadRooms.value.add(room.id)
                    }
                })
        })
    } catch (error) {
        console.error('Failed to load rooms:', error)
    }
}

const switchRoom = (roomId) => {
    emit('switchRoom', roomId)
    unreadRooms.value.delete(roomId)
}

onMounted(fetchRooms)

watch(() => props.currentRoomId, () => {
    unreadRooms.value.delete(props.currentRoomId)
})
</script>

<template>
    <div class="w-64 bg-white border-r shadow-sm p-4">
        <h3 class="text-lg font-bold mb-4">My Rooms</h3>
        <ul class="space-y-2">
            <li
                v-for="room in rooms"
                :key="room.id"
                @click="switchRoom(room.id)"
                class="cursor-pointer flex items-center justify-between p-2 rounded hover:bg-gray-100"
                :class="{ 'bg-blue-100': room.id === currentRoomId }"
            >
                <span>{{ room.title }}</span>
                <span v-if="unreadRooms.has(room.id)" class="w-2 h-2 bg-red-500 rounded-full"></span>
            </li>
        </ul>
    </div>
</template>
