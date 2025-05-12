<script setup>
import { ref } from 'vue';

const model = defineModel({
    type: Number,
    required: true,
});
const input = ref(null);

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2"
        v-model="model"
        ref="input"
    />
</template>
