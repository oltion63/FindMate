<script setup lang="ts">

</script>

<template>
    <div class="relative group max-w-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 ease-in-out hover:bg-[#FFCB74] hover:text-black dark:hover:text-black">

        <!-- Decorative top badge -->
        <div class="absolute -top-5 left-5 bg-black text-black px-4 py-1 rounded-full text-sm font-bold shadow group-hover:scale-105 transition">
            <slot name="numri"></slot>
        </div>

        <!-- Inner content container -->
        <div class="p-8 pt-12 text-center space-y-4">
            <h3 class="text-2xl font-extrabold tracking-tight group-hover:text-black transition">
                <slot name="heading"></slot>
            </h3>
            <p class="text-base italic text-gray-600 dark:text-gray-300 group-hover:text-black transition">
                <slot name="p"></slot>
            </p>

            <!-- Optional bottom content -->
            <div class="pt-4">
                <slot name="b"></slot>
            </div>
        </div>

        <!-- Decorative angled bottom bar -->
        <div class="absolute bottom-0 left-0 w-full h-3 bg-gradient-to-r from-black to-[#FFCB74] group-hover:opacity-100 opacity-75 transition" />
    </div>
</template>


<style scoped>

</style>
