<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    post: {
        type: Object,
    },
});
const emit = defineEmits(['close'])

const form = useForm({
    post_id: props.post.id,
    description: ''
})

const submitReport = () => {
    form.post(route('storeReport'), {
        onSuccess: () => {
            emit('close')
        }
    })
}

</script>
<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-2xl w-full max-w-md shadow-xl transition-transform transform scale-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Report This Post</h2>
            <p class="text-gray-600 text-sm mb-5 leading-relaxed">
                If you believe this post violates our guidelines or contains inappropriate content, please let us know.
                <span class="font-medium">Your feedback helps keep our community safe and respectful.</span>
            </p>

            <textarea
                v-model="form.description"
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400 transition"
                rows="4"
                placeholder="Describe why you are reporting this post..."
            ></textarea>

            <div v-if="form.errors.description" class="text-red-500 text-sm mt-2">
                {{ form.errors.description }}
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button
                    @click="emit('close')"
                    class="px-5 py-2 text-sm font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition"
                >
                    Cancel
                </button>
                <button
                    @click="submitReport"
                    class="px-5 py-2 text-sm font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 transition"
                    :disabled="form.processing"
                >
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>
