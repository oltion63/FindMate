<script setup>

</script>

<template>
    <div class="max-w-sm p-6 bg-gradient-to-br from-gray-100 to-gray-300 border border-gray-300
                rounded-2xl shadow-lg transition-transform transform
                hover:shadow-xl dark:bg-gray-800 dark:border-gray-700 dark:from-gray-700 dark:to-gray-900">

        <!-- Title -->
        <h5 class="mb-3 text-base md:text-lg font-semibold text-center text-gray-900 dark:text-white uppercase ">
            <slot name="Information"></slot>
        </h5>

        <!-- Icon + Data -->
        <div class="flex items-center justify-center space-x-4">
            <div class="p-3 bg-white rounded-full shadow-md dark:bg-gray-700">
                <slot name="icon"></slot>
            </div>
            <h5 class="text-2xl font-bold text-gray-900 dark:text-white">
                <slot name="DbInfo"></slot>
            </h5>
        </div>
    </div>
</template>


<style scoped>

</style>
