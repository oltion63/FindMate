<script setup>
import {formatDistanceToNow} from "date-fns";
import {useForm, usePage} from "@inertiajs/vue3";

const props = defineProps({
    post: {
        type: Object,
    },
    savedPost:{
        type: Number,
    },
    isApplyModalVisible: {
        type: Boolean,
        default: false,
    },
})
const emit = defineEmits(['update:isApplyModalVisible']);
const openApplyModal = () => {
    console.log('Modal open triggered');
    emit('update:isApplyModalVisible', true); // Emit event for parent to handle
};
const form = useForm({
    user_id: usePage().props.auth.user.id,
    post_id: props.post.id,
})
const submitSaved = () => {
    form.post(route('jobs.storeSaved'))
};

function formatTime(date){
    return formatDistanceToNow(new Date(date), { addSuffix: true });
}
</script>

<template>
    <section id="left" class="min-h-80 w-full border-b lg:border-b-0 pb-4 lg:border-r border-gray-500 px-4 ">
        <div class="flex justify-between mb-6 w-full items-center">
            <h2 class="text-2xl md:text-3xl font-semibold leading-tight text-gray-800">
                {{ post.tittle }}
            </h2>
            <div v-if="$page.props.auth.user.role === 'employee'" class="space-y-4 flex flex-col justify-end md:space-y-0 md:flex-row md:space-x-4 md:items-center">
                <button type="button" @click="openApplyModal" class="text-white bg-gradient-to-br from-blue-900 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Apply
                </button>
                <form class="hidden" id="savePost"  @submit.prevent="submitSaved">
                    <input type="text" name="post_id" v-model="form.post_id">
                    <input type="text" name="user_id" v-model="form.user_id">
                </form>
                <form class="hidden" id="unsavePost"  @submit.prevent="form.delete(route('jobs.deleteSaved', {id: props.savedPost}))">
                </form>
                <button v-if="savedPost === null" form="savePost" type="submit" class="transition hover:scale-105 flex justify-end">
                    <svg width="40px" height="40px" class="border-indigo-950 border rounded-lg"
                         viewBox="-4.8 -4.8 33.60 33.60" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0">
                            <rect x="-4.8" y="-4.8" width="33.60" height="33.60" rx="3.36" fill=""
                                  strokewidth="0"></rect>
                        </g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M19 19.2674V7.84496C19 5.64147 17.4253 3.74489 15.2391 3.31522C13.1006 2.89493 10.8994 2.89493 8.76089 3.31522C6.57467 3.74489 5 5.64147 5 7.84496V19.2674C5 20.6038 6.46752 21.4355 7.63416 20.7604L10.8211 18.9159C11.5492 18.4945 12.4508 18.4945 13.1789 18.9159L16.3658 20.7604C17.5325 21.4355 19 20.6038 19 19.2674Z"
                                stroke="#4B0082" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </g>
                    </svg>
                </button>
                <button  v-if="savedPost !== null" form="unsavePost" type="submit" class="transition hover:scale-105 flex justify-end">
                    <svg width="40px" height="40px" class="border-gray-500 border rounded-lg" viewBox="-4.8 -4.8 33.60 33.60" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0">
                            <rect x="-4.8" y="-4.8" width="33.60" height="33.60" rx="3.36" fill=""
                                  strokewidth="0"></rect>
                        </g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#FFB81C"
                           stroke-width="0.9600000000000002">
                            <path
                                d="M15.0309 3.30271C13.0299 2.8991 10.9701 2.8991 8.96913 3.30271C6.66186 3.76809 5 5.82231 5 8.20894V18.6292C5 20.4579 6.9567 21.596 8.51221 20.6721L11.3451 18.9895C11.7496 18.7492 12.2504 18.7492 12.6549 18.9895L15.4878 20.6721C17.0433 21.596 19 20.4579 19 18.6292V8.20894C19 5.82231 17.3381 3.76809 15.0309 3.30271Z"
                                fill="#FFB81C"></path>
                        </g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M15.0309 3.30271C13.0299 2.8991 10.9701 2.8991 8.96913 3.30271C6.66186 3.76809 5 5.82231 5 8.20894V18.6292C5 20.4579 6.9567 21.596 8.51221 20.6721L11.3451 18.9895C11.7496 18.7492 12.2504 18.7492 12.6549 18.9895L15.4878 20.6721C17.0433 21.596 19 20.4579 19 18.6292V8.20894C19 5.82231 17.3381 3.76809 15.0309 3.30271Z"
                                fill="#FFB81C"></path>
                        </g>
                    </svg>
                </button>
            </div>
        </div>
        <div class="lg:flex justify-start lg:space-x-8">
            <img :src="'/storage/'+post.company.image" class="w-20 h-20 border border-gray-500 rounded-lg" alt="">
            <div class="py-2 space-y-4 w-full text-sm md:text-base">
                <section class="flex items-center">
                    <span class="font-bold text-blue-600 text-lg">{{post.company.name}}</span>
                    <span class="ml-4"><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg></span>
                    <span> {{post.location.name}}</span>
                </section>
                <section class="md:flex justify-between space-y-2 lg:space-y-0">
                    <div class="flex space-x-4 items-center">
                        <span class="px-2 bg-emerald-300 bg-opacity-50 rounded-lg text-emerald-900 text-center">{{post.type}}</span>
                        <span class="px-2 bg-emerald-300 bg-opacity-50 rounded-lg text-emerald-900 text-center">{{post.category.name}}</span>
                        <span class="px-2 bg-emerald-300 bg-opacity-50 rounded-lg text-emerald-900 text-center">${{post.salary}}</span>
                    </div>
                    <div class="w-full  md:w-1/2 flex justify-end">
                        <span>{{ new Date(post.expiration_date) > new Date() ? 'Expires' : 'Expired' }} {{formatTime(post.expiration_date)}}</span>
                    </div>
                </section>
            </div>
        </div>
        <div class="w-full my-6">
            <span class="text-xl font-bold">Description:</span>
            <p>{{post.description}}</p>
        </div>
        <div class="w-full h-24 flex justify-end items-end">
            <span class="text-gray-500">{{ formatTime(post.created_at) }}</span>
        </div>
    </section>
</template>
