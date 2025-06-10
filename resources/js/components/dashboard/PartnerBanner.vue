<script setup lang="ts">
</script>

<template>
    <div
        class="grid gap-4 md:flex justify-around items-center bg-white rounded-lg p-6
           backdrop-blur-sm shadow-inner shadow-black/30"
    >
    <span>
      <img
          class="h-32 w-28 object-scale-down hover:scale-x-105 transition-transform duration-300"
          :src="'storage/images/prlogo.png'"
      />
    </span>
        <span>
      <img
          class="h-32 w-28 object-scale-down hover:scale-x-105 transition-transform duration-300"
          :src="'storage/images/speexx_logo.png'"
      />
    </span>
        <span>
      <img
          class="h-32 w-28 object-scale-down hover:scale-x-105 transition-transform duration-300"
          :src="'storage/images/binni.png'"
      />
    </span>
        <span>
      <img
          class="h-32 w-28 object-scale-down hover:scale-x-105 transition-transform duration-300"
          :src="'storage/images/starlabs.png'"
      />
    </span>
        <span>
      <img
          class="h-32 w-28 object-scale-down hover:scale-x-105 transition-transform duration-300"
          :src="'storage/images/ipko.png'"
      />
    </span>
    </div>
</template>


<script setup>
const logos = [
    { src: 'storage/images/prlogo.png', alt: 'PR Logo' },
    { src: 'storage/images/speexx_logo.png', alt: 'Speexx Logo' },
    { src: 'storage/images/binni.png', alt: 'Binni Logo' },
    { src: 'storage/images/starlabs.png', alt: 'StarLabs Logo' },
    { src: 'storage/images/ipko.png', alt: 'Ipko Logo' },
]
</script>

<style scoped>
@keyframes fadeIn {
    to {
        opacity: 1;
        transform: none;
    }
}
.animate-fadeIn {
    animation: fadeIn 0.6s ease forwards;
    transform: translateY(10px);
}
</style>
