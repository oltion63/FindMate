<script setup>
import { ref, onMounted, nextTick } from 'vue'
import axios from 'axios'
import { format } from 'date-fns'
import echo from '@/echo.js'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps({
    room: Object,
    auth: Object,
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
</script>

<template>
    <AppLayout>
        <div class="h-screen flex flex-col bg-gray-100">
            <div class="p-4 bg-white shadow-md">
                <h2 class="text-lg font-semibold">Room #{{ room.id }}</h2>
            </div>

            <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-2">
                <div
                    v-for="message in messages"
                    :key="message._id"
                    class="flex"
                    :class="{
            'justify-end': message.senderId === auth.user.id.toString(),
            'justify-start': message.senderId !== auth.user.id.toString(),
          }"
                >
                    <div
                        class="max-w-xs rounded-2xl px-4 py-2 text-sm shadow-md"
                        :class="{
              'bg-blue-500 text-white': message.senderId === auth.user.id.toString(),
              'bg-white text-gray-800': message.senderId !== auth.user.id.toString(),
            }"
                    >
                        <div class="font-medium text-xs mb-1">{{ message.username }}</div>
                        <div>{{ message.content }}</div>
                        <div class="text-[10px] text-gray-400 mt-1 text-right">{{ formatTimestamp(message.timestamp) }}</div>
                    </div>
                </div>
            </div>

            <form @submit.prevent="handleSendMessage" class="p-4 bg-white flex gap-2 border-t">
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
    </AppLayout>
</template>
