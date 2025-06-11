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
