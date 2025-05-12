<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    show: Boolean,
    message: String,
    title: String,
});

const emit = defineEmits(["close", "confirm"]);

const cancel = () => emit("close");
const confirm = () => emit("confirm");
</script>

<template>
    <div v-if="show" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 px-4">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-semibold text-gray-800">{{ title }}</h2>
            <p class="text-gray-600 mt-2">{{ message }}</p>

            <div class="flex justify-end space-x-3 mt-4">
                <button @click="cancel" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300">
                    Cancel
                </button>
                <button @click="confirm" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>
