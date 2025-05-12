<script setup>
import { ref } from 'vue';

const modelValue  = defineModel({
    type: File,
    required: true,
});
const emit = defineEmits(['update:modelValue']);
const input = ref(null);

const handleFileChange = (event) => {
    const files = event.target.files;
    if (files && files.length > 0) {
        emit('update:modelValue', files[0]); // Emit the first selected file
    } else {
        emit('update:modelValue', null); // Emit null if no file selected
    }
};

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        type="file"
        @change="handleFileChange"
        ref="input"
    />
</template>
