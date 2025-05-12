<script setup lang="ts">

</script>

<template>
    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-700 dark:border-gray-700 hover:scale-x-105 transition text-white">
        <div class="self-start font-extrabold text-xl"><slot name="numri"></slot></div>
        <div class="py-8 font-semibold italic text-center">
            <h3><slot name="heading"></slot></h3>
            <p><slot name="p"></slot></p>
        </div>
        <div><slot name="b"></slot></div>
    </div>
</template>

<style scoped>

</style>
