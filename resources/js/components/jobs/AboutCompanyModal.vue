<script setup>

const props = defineProps({
    post: {
        type: Object,
    },
    isACModalVisible: {
        type: Boolean,
        default: true
    }
})
const emit = defineEmits();

const closeACModal = () => {
    emit('close');
};

</script>

<template>
    <div v-if="isACModalVisible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 px-4"  @click="closeACModal">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full max-h-[90%] overflow-y-auto lg:h-fit" @click.stop>
            <div class="md:flex justify-between items-center">
                <div class="flex justify-start items-center space-x-8">
                    <img :src="'/storage/'+ post.company.image" class="w-24 h-24 rounded object-cover" alt="">
                    <h3 class="text-xl font-semibold mb-4">{{ post.company.name }}</h3>
                </div>
                <div class="flex space-x-2 items-center">
                    <span>
                        <svg width="20px" height="20px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000000" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M39.93,55.72A24.86,24.86,0,1,1,56.86,32.15a37.24,37.24,0,0,1-.73,6"></path><path d="M37.86,51.1A47,47,0,0,1,32,56.7"></path><path d="M32,7A34.14,34.14,0,0,1,43.57,30a34.07,34.07,0,0,1,.09,4.85"></path><path d="M32,7A34.09,34.09,0,0,0,20.31,32.46c0,16.2,7.28,21,11.66,24.24"></path><line x1="10.37" y1="19.9" x2="53.75" y2="19.9"></line><line x1="32" y1="6.99" x2="32" y2="56.7"></line><line x1="11.05" y1="45.48" x2="37.04" y2="45.48"></line><line x1="7.14" y1="32.46" x2="56.86" y2="31.85"></line><path d="M53.57,57,58,52.56l-8-8,4.55-2.91a.38.38,0,0,0-.12-.7L39.14,37.37a.39.39,0,0,0-.46.46L42,53.41a.39.39,0,0,0,.71.13L45.57,49Z"></path></g></svg>
                    </span>
                    <a
                        class="text-blue-600"
                        :href="post.company.website.startsWith('http') ? post.company.website : `https://${post.company.website}`"
                        target="_blank" rel="noopener noreferrer">
                        www.{{ post.company.website }}
                    </a>
                </div>
            </div>
            <div class="mt-8 pb-8">
                <span class="text-lg font-bold">About Company:</span>
                <p class="mt-2 mb-8">{{ post.company.description }}</p>
            </div>
            <div class="space-y-4 lg:space-y-0 lg:flex justify-between items-center">
                <div class="space-y-2 lg:space-y-0 lg:flex justify-start lg:space-x-4">
                    <h1><strong>Address</strong>: {{ post.company.address }}</h1>
                    <h1><strong>Phone</strong>: {{ post.company.phone }}</h1>
                    <h1><strong>Email</strong>: {{ post.company.email }}</h1>
                </div>
                <div>
                    <button
                        @click="closeACModal"
                        class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                    >
                        Close
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>
