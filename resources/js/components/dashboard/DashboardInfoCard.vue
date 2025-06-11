<script setup>

</script>

<template>
    <div class="max-w-sm p-6
                bg-gradient-to-br from-[#2F2F2F] to-[#111111]
                border border-[#FFCB74]
                rounded-2xl shadow-lg transition-transform transform
                hover:shadow-xl
                text-[#F6F6F6]">

        <!-- Title -->
        <h5 class="mb-3 text-base md:text-lg font-semibold text-center uppercase">
            <slot name="Information"></slot>
        </h5>

        <!-- Icon + Data -->
        <div class="flex items-center justify-center space-x-4">
            <div class="p-3 bg-[#111111] rounded-full shadow-md border border-[#FFCB74]">
                <slot name="icon"></slot>
            </div>
            <h5 class="text-2xl font-bold">
                <slot name="DbInfo"></slot>
            </h5>
        </div>
    </div>
</template>



<style scoped>

</style>
