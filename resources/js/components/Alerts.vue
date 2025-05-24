<script setup lang="ts">
import { ref, watchEffect } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const successMessage = ref(null);
const errorMessage = ref(null);
let timeoutId = null;

const startAutoDismiss = () => {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
        successMessage.value = null;
        errorMessage.value = null;
    }, 3000);
};

watchEffect(() => {
    if (page.props.flash.success) {
        successMessage.value = page.props.flash.success;
        startAutoDismiss();
    }
    if (page.props.flash.error) {
        errorMessage.value = page.props.flash.error;
        startAutoDismiss();
    }
});
const pauseDismiss = () => clearTimeout(timeoutId);
const resumeDismiss = () => startAutoDismiss();
</script>

<template>
    <transition name="fade-slide">
        <div
            v-if="successMessage"
            class="fixed bottom-4 right-4 sm:right-4 sm:bottom-4 left-1/2 transform sm:left-auto sm:transform-none -translate-x-1/2 sm:translate-x-0 z-40 bg-green-200 border-l-4 border-green-700
            w-60 sm:w-80 text-gray-800 p-3 sm:p-4 rounded-md shadow-lg hover:shadow-xl flex items-center space-x-3"
            @mouseover="pauseDismiss"
            @mouseleave="resumeDismiss"
        >
            <svg width="35px" height="35px" class="bg-green-50 p-1.5 rounded-full" viewBox="0 0 117 117" xmlns="http://www.w3.org/2000/svg">
                <g fill="none" fill-rule="evenodd">
                    <g fill-rule="nonzero">
                        <path d="M34.5,55.1 C32.9,53.5 30.3,53.5 28.7,55.1 C27.1,56.7 27.1,59.3 28.7,60.9 L47.6,79.8 C48.4,80.6 49.4,81 50.5,81 C50.6,81 50.6,81 50.7,81 C51.8,80.9 52.9,80.4 53.7,79.5 L101,22.8 C102.4,21.1 102.2,18.5 100.5,17 C98.8,15.6 96.2,15.8 94.7,17.5 L50.2,70.8 L34.5,55.1 Z" fill="#00f068"/>
                        <path d="M89.1,9.3 C66.1,-5.1 36.6,-1.7 17.4,17.5 C-5.2,40.1 -5.2,77 17.4,99.6 C28.7,110.9 43.6,116.6 58.4,116.6 C73.2,116.6 88.1,110.9 99.4,99.6 C118.7,80.3 122,50.7 107.5,27.7 C106.3,25.8 103.8,25.2 101.9,26.4 C100,27.6 99.4,30.1 100.6,32 C113.1,51.8 110.2,77.2 93.6,93.8 C74.2,113.2 42.5,113.2 23.1,93.8 C3.7,74.4 3.7,42.7 23.1,23.3 C39.7,6.8 65,3.9 84.8,16.2 C86.7,17.4 89.2,16.8 90.4,14.9 C91.6,13 91,10.5 89.1,9.3 Z" fill="#00f068"/>
                    </g>
                </g>
            </svg>
            <span class="text-sm sm:text-base font-medium">{{ successMessage }}</span>
        </div>
    </transition>

    <transition name="fade-slide">
        <div
            v-if="errorMessage"
            class="fixed bottom-4 right-4 sm:right-4 sm:bottom-4 left-1/2 transform -translate-x-1/2 sm:translate-x-0 z-40 bg-red-200 border-l-4 border-red-600
            max-w-xs sm:w-80 text-gray-800 p-3 sm:p-4 rounded-md shadow-lg hover:shadow-xl flex items-center space-x-3"
            @mouseover="pauseDismiss"
            @mouseleave="resumeDismiss"
        >
            <svg width="35px" height="35px" class="bg-white p-1.5 rounded-full" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <g fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.0619 4.4295C12.6213 3.54786 11.3636 3.54786 10.9229 4.4295L3.89008 18.5006C3.49256 19.2959 4.07069 20.2317 4.95957 20.2317H19.0253C19.9142 20.2317 20.4923 19.2959 20.0948 18.5006L13.0619 4.4295ZM9.34196 3.6387C10.434 1.45376 13.5508 1.45377 14.6429 3.63871L21.6758 17.7098C22.6609 19.6809 21.2282 22 19.0253 22H4.95957C2.75669 22 1.32395 19.6809 2.3091 17.7098L9.34196 3.6387Z" fill="#ff0000"/>
                    <path d="M12 8V13" stroke="#ff0000" stroke-width="1.7" stroke-linecap="round"/>
                    <path d="M12 16L12 16.5" stroke="#ff0000" stroke-width="1.7" stroke-linecap="round"/>
                </g>
            </svg>
            <span class="text-sm sm:text-base font-medium">{{ errorMessage }}</span>
        </div>
    </transition>
</template>


<style>
/* Fade and slide animation */
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: opacity 0.5s, transform 0.5s;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(20px);
}
</style>
