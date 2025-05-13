<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <img
        src="/storage/images/logo.png"
        width="150px"
        height="150px"
        class="mx-auto"
        alt="logo"
        :class="className"  />
</template>
