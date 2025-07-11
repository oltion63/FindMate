<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue'
import axios from 'axios'
import { format } from 'date-fns'
import echo from '@/echo.js'
import AppLayout from '@/layouts/AppLayout.vue'
import ChatRoomList from '@/components/chat/ChatRoomList.vue'
import { Head } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types/index.js';

const props = defineProps({
    room: Object,
    auth: Object,
    rooms: Array,
})

const messages = ref([])
const newMessage = ref('')
const loadingMessages = ref(true)

const formatTimestamp = (timestamp) => {
    return format(new Date(timestamp), 'HH:mm')
}

const scrollToBottom = () => {
    nextTick(() => {
        const container = document.getElementById('messages-container')
        if (container) {
            container.scrollTop = container.scrollHeight
        }
    })
}

const fetchMessages = async () => {
    loadingMessages.value = true
    try {
        const response = await axios.get('/chat/messages', {
            params: { room_id: props.room.id },
        })
        messages.value = response.data.messages.map((msg) => ({
            _id: msg.id.toString(),
            content: msg.text,
            senderId: msg.user.id.toString(),
            username: msg.user.name,
            avatar: msg.user.image || '',
            timestamp: msg.created_at,
        }))
        scrollToBottom()
    } catch (error) {
        console.error('Error fetching messages:', error)
    } finally {
        loadingMessages.value = false
    }
}

const handleSendMessage = async () => {
    if (!newMessage.value.trim()) return

    try {
        await axios.post('/chat/message', {
            room_id: props.room.id,
            text: newMessage.value,
        })
        newMessage.value = ''
    } catch (error) {
        console.error('Error sending message:', error)
    }
}

const currentRoomId = ref(props.room.id)

const handleRoomSwitch = (roomId) => {
    window.location.href = `/chat/room/${roomId}`
}

onMounted(() => {
    if (!props.room?.id) {
        console.error('props.room.id is not available')
        return
    }

    fetchMessages()

    echo.private(`chat.room.${props.room.id}`)
        .listen('MessageSent', (e) => {
            messages.value.push({
                _id: e.id.toString(),
                content: e.text,
                senderId: e.user.id.toString(),
                username: e.user.name,
                avatar: e.user.image || '',
                timestamp: e.created_at,
            })
            scrollToBottom()
        })
        .error((err) => {
            console.error('Error joining channel:', err)
        })
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: props.room.title,
        href: '/chats',
    },
];

</script>

<template>
    <Head :title="room.title"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="h-screen flex flex-col md:flex-row bg-gray-100">
            <div class="md:hidden bg-white px-4 py-3 border-b">
                <label for="mobile-room-select" class="block text-sm font-medium mb-1">Select Chat Room</label>
                <select
                    id="mobile-room-select"
                    class="w-full border border-gray-300 rounded px-3 py-2"
                    :value="currentRoomId"
                    @change="handleRoomSwitch($event.target.value)"
                >
                    <option
                        v-for="roomItem in props.rooms"
                        :key="roomItem.id"
                        :value="roomItem.id"
                    >
                        {{ roomItem.title }}
                    </option>
                </select>
            </div>
            <div class="hidden md:block w-64 border-r ">
                <ChatRoomList
                    :currentRoomId="currentRoomId"
                    @switchRoom="handleRoomSwitch"
                />
            </div>
            <div class="flex flex-col flex-1 h-full bg-gray-100">

                <div class="bg-white px-6 py-4 shadow flex items-center border-b">
                    <h2 class="text-xl font-semibold">{{ room.title }}</h2>
                </div>
                <div
                    id="messages-container"
                    class="flex-1 overflow-y-auto px-6 py-4 space-y-3 bg-gray-50 shrink-0"
                >
                    <div v-if="messages.length === 0" class="flex items-center justify-center h-full">
                        Start a conversation
                    </div>
                    <div
                        v-for="message in messages"
                        :key="message._id"
                        class="flex"
                        :class="{
              'justify-end': message.senderId === auth.user.id.toString(),
              'justify-start': message.senderId !== auth.user.id.toString(),
            }"
                    >
                        <img
                            v-if="message.avatar && message.senderId !== auth.user.id.toString()"
                            :src="`/storage/${message.avatar}`"
                            alt="Profile"
                            class="w-8 h-8 rounded-full mr-2"
                        />
                        <div
                            class="max-w-xs md:max-w-md lg:max-w-lg rounded-2xl px-4 py-2 text-sm shadow-md"
                            :class="{
                'bg-blue-500 text-white': message.senderId === auth.user.id.toString(),
                'bg-white text-gray-800': message.senderId !== auth.user.id.toString(),
              }"
                        >
                            <div class="font-medium text-xs mb-1">{{ message.username }}</div>
                            <div>{{ message.content }}</div>
                            <div class="text-[10px] text-gray-400 mt-1 text-right">{{ formatTimestamp(message.timestamp) }}</div>
                        </div>
                        <img
                            v-if="message.avatar && message.senderId === auth.user.id.toString()"
                            :src="`/storage/${message.avatar}`"
                            alt="Profile"
                            class="w-8 h-8 rounded-full ml-2"
                        />
                    </div>
                </div>
                <form @submit.prevent="handleSendMessage" class="sticky bottom-0 z-10 bg-white p-4 border-t flex gap-2">
                    <input
                        v-model="newMessage"
                        type="text"
                        placeholder="Type a message..."
                        class="flex-1 border border-gray-300 rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    />
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
