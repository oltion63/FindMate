<script setup>

defineProps({
    post:{
        type:Object,
    },
    isACModalVisible:{
        type:Boolean,
        default:true,
    },
})
const emit = defineEmits(['update:isACModalVisible']);
const openACModal = () =>{
    emit('update:isACModalVisible', true);
}

</script>

<template>
    <section id="right" class="w-full lg:w-1/3 px-4">
                    <span class="text-3xl font-semibold leading-tight text-gray-800">
                        Company
                    </span>
        <div class="w-full flex justify-center py-8">
            <div class="mx-auto">
                <img :src="'/storage/'+ post.company.image" class="w-24 h-24 rounded-full object-cover mx-auto mb-6 border border-gray-500" alt="">
                <span class="font-bold text-lg mx-auto ">{{post.company.name}}</span>
            </div>
        </div>
        <div class="mx-auto w-fit">
            <button type="button" @click="openACModal" class="bg-gray-400 bg-opacity-30 px-4 py-2 rounded-lg hover:bg-gray-500 hover:bg-opacity-30">
                Learn More
            </button>
        </div>
    </section>
</template>
