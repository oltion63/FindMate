<script setup>
import {Globe, MapPinHouse, Phone, Mail} from "lucide-vue-next"

const props = defineProps({
    company: {
        type: Object,
    },
    isModalVisible: {
        type: Boolean,
        default: true
    }
})
const emit = defineEmits();

const closeModal = () => {
    emit('close');
};

</script>

<template>
    <div v-if="isModalVisible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4"  @click="closeModal">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full max-h-[90%] overflow-y-auto" @click.stop>
            <div class="space-y-4 md:space-y-0 md:flex justify-between items-center">
                <div class="flex justify-start items-center space-x-8">
                    <img :src="'/storage/'+ company.image" class="w-24 h-24 rounded object-cover" alt="">
                    <h3 class="text-xl font-semibold mb-4">{{ company.name }}</h3>
                </div>
                <div class="flex space-x-2 items-center">
                    <span>
                        <Globe />
                    </span>
                    <a
                        class="text-blue-600"
                        :href="company.website.startsWith('http') ? company.website : `https://${company.website}`"
                        target="_blank" rel="noopener noreferrer">
                        www.{{ company.website }}
                    </a>
                </div>
            </div>
            <div class="mt-8">
                <span class="text-lg">Description:</span>
                <p class="mt-2 mb-8 ">{{ company.description }}</p>
            </div>
            <div class="space-y-4 md:space-y-10  justify-between items-center">
                <div class="md:flex justify-start md:space-x-4">
                    <span class="flex gap-2"><MapPinHouse/> {{ company.address }}</span>
                    <span class="flex gap-2"><Phone/> {{ company.phone }}</span>
                    <span class="flex gap-2"><Mail/> {{ company.email }}</span>
                </div>
                <div class="w-full  flex justify-end">
                    <button
                        @click="closeModal"
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                    >
                        Close
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>
