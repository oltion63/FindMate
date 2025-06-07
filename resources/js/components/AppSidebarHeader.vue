<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import { usePage, useForm } from '@inertiajs/vue3';
import { onMounted, ref, onBeforeUnmount } from 'vue';
import axios from 'axios'
import debounce from 'lodash/debounce'
import { useRoute } from 'ziggy-js';

const route = useRoute();

defineProps<{
    breadcrumbs?: BreadcrumbItemType[];
}>();

const showDropdown = ref(false);
const hasSearched = ref(false);
const dropdownRef = ref(null)
const toggleDropdown = () => {
    showDropdown.value = !showDropdown.value;
    if (showDropdown.value) {
        hasUnread.value = false;
        results.value = [];
        hasSearched.value = false;
    }
};
const handleClickOutside = (event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        showDropdown.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});

const page = usePage();
const initialNotifications = page.props.notifications || [];

const notifications = ref<{ id: number; message: string }[]>([...initialNotifications]);
const hasUnread = ref(false);

const userId = page.props.auth?.user?.id;

onMounted(() => {
    if (userId) {
        window.Echo.private(`notifications.${userId}`).listen('.notifications', (e: any) => {
            console.log('Notification received:', e);
            notifications.value.unshift({
                id: e.id,
                message: e.message,
            });
            hasUnread.value = true;
        });
    }
});

const searchQuery = ref('')
const results = ref([])

const fetchResults = async () => {
    if (searchQuery.value.length < 3) {
        results.value = []
        hasSearched.value = false;
        return
    }
    showDropdown.value = false;

    try {
        const response = await axios.get('/search', {
            params: { query: searchQuery.value }
        })
        results.value = response.data
        hasSearched.value = true;
    } catch (error) {
        results.value = [];
        hasSearched.value = true;
        console.error('Search failed:', error)
    }
}

const handleSearch = debounce(fetchResults, 300)

const form = useForm({
    is_read: page.props.notifications.is_read,
})


</script>

<template>
    <header class="flex h-16 items-center justify-between mx-4 space-x-2">
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>

        <div class="flex space-x-2 lg:space-x-10 xl:mr-16 items-center">
            <div  v-if="route().current('jobs.index')"
                  class="relative w-40 md:w-52 lg:w-64">
                <input
                    type="text"
                    v-model="searchQuery"
                    @input="handleSearch"
                    placeholder="Search..."
                    class="border border-gray-500 rounded p-1 lg:p-2 w-full"
                />
                <ul
                    v-if="results.length"
                    class="absolute left-1/2 z-50 mt-2 w-[420px] -translate-x-1/2 max-h-64 overflow-y-auto rounded-md border border-gray-300 bg-white shadow-lg"
                >
                    <li
                        v-for="result in results"
                        :key="result.id"
                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer border-b last:border-none"
                    >
                        <a
                            :href="`/jobs/${result.id}`"
                            class="block px-4 py-2 hover:bg-gray-100 text-left"
                        >
                        <div class="font-semibold text-sm text-gray-800">{{ result.tittle }}</div>
                        <div class="text-xs text-gray-600 line-clamp-2">{{ result.description }}</div>
                        <div class="text-xs text-gray-500 mt-1 space-x-4 flex">
                            <span>
                                {{ result.salary ?? 'N/A' }} €
                            </span>
                            <span class="flex w-fit"> <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="15px" height="15px" viewBox="0 0 24 24"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-opacity=".9" d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path></g></svg>
                                {{ result.type ?? 'N/A' }}
                            </span>
                            <span class="flex w-fit"> <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                {{ result.location.name ?? 'N/A' }}
                            </span>
                            <span class="flex w-fit gap-1">
                                <svg width="15px" height="15px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 10H7C9 10 10 9 10 7V5C10 3 9 2 7 2H5C3 2 2 3 2 5V7C2 9 3 10 5 10Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17 10H19C21 10 22 9 22 7V5C22 3 21 2 19 2H17C15 2 14 3 14 5V7C14 9 15 10 17 10Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M17 22H19C21 22 22 21 22 19V17C22 15 21 14 19 14H17C15 14 14 15 14 17V19C14 21 15 22 17 22Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M5 22H7C9 22 10 21 10 19V17C10 15 9 14 7 14H5C3 14 2 15 2 17V19C2 21 3 22 5 22Z" stroke="#292D32" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                {{result.category.name}}
                            </span>
                        </div>
                        </a>
                    </li>
                </ul>
                <ul  v-if="hasSearched && results.length === 0"
                class="absolute left-1/2 z-50 mt-2 w-96 -translate-x-1/2 max-h-64 overflow-y-auto rounded-md border border-gray-300 bg-white shadow-lg"
                >
                    <li class="px-4 py-4 border-b last:border-none">
                        <div class="font-semibold text-sm text-gray-800 text-center">No Results</div>
                    </li>
                </ul>

            </div>

            <div ref="dropdownRef" >
                <button @click="toggleDropdown" class="relative">
                    <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M8.04283 5.1757C8.59546 4.75121 9.24946 4.43224 10.0136 4.23441C10.0046 4.15752 10 4.0793 10 4C10 2.89543 10.8955 2 12 2C13.1046 2 14 2.89543 14 4C14 4.0793 13.9954 4.15752 13.9864 4.23441C14.7506 4.43224 15.4046 4.75121 15.9572 5.1757C16.933 5.92519 17.4981 6.93095 17.8325 7.93362C18.1644 8.92891 18.2842 9.96595 18.3426 10.8395C18.3663 11.1941 18.3806 11.5351 18.3932 11.8357L18.4018 12.0385C18.4175 12.3994 18.433 12.6684 18.4596 12.8673C18.6553 14.329 18.8982 15.3543 19.2438 16.1741C19.5816 16.9754 20.0345 17.6202 20.7071 18.2929C20.9931 18.5789 21.0787 19.009 20.9239 19.3827C20.7691 19.7564 20.4045 20 20 20H13.7325C13.9026 20.2942 14 20.6357 14 21C14 22.1046 13.1046 23 12 23C10.8955 23 10 22.1046 10 21C10 20.6357 10.0974 20.2942 10.2676 20H4.00003C3.59557 20 3.23093 19.7564 3.07615 19.3827C2.92137 19.009 3.00692 18.5789 3.29292 18.2929C3.96694 17.6189 4.4186 16.9787 4.75553 16.1809C5.1004 15.3642 5.3434 14.3395 5.54043 12.8673C5.56706 12.6684 5.58255 12.3994 5.59827 12.0385L5.60687 11.8357C5.61945 11.5351 5.63371 11.1941 5.65744 10.8395C5.7159 9.96595 5.83561 8.92891 6.16756 7.93362C6.50196 6.93095 7.06705 5.92519 8.04283 5.1757ZM6.06869 18C6.26568 17.6741 6.44135 17.3298 6.59797 16.959C7.04284 15.9056 7.31562 14.6803 7.52276 13.1327C7.56305 12.8316 7.58113 12.4756 7.59638 12.1255L7.60555 11.9095C7.61808 11.6105 7.63109 11.3002 7.65298 10.973C7.70745 10.159 7.81312 9.32109 8.06482 8.56638C8.31407 7.81905 8.6909 7.19981 9.26113 6.7618C9.82482 6.32883 10.6723 6 12 6C13.3278 6 14.1752 6.32883 14.7389 6.7618C15.3092 7.19981 15.686 7.81905 15.9352 8.56638C16.1869 9.32109 16.2926 10.159 16.3471 10.973C16.369 11.3002 16.382 11.6105 16.3945 11.9095L16.3945 11.9095L16.3945 11.9096L16.4037 12.1255C16.4189 12.4756 16.437 12.8316 16.4773 13.1327C16.6832 14.671 16.956 15.8957 17.4008 16.9509C17.5583 17.3244 17.735 17.6714 17.9334 18H6.06869Z"
                                fill="#000000"
                            ></path>
                        </g>
                    </svg>
                    <span v-if="hasUnread" class="absolute right-0 top-0 block h-3 w-3 rounded-full bg-red-500 ring-2 ring-white"> </span>
                </button>

                <transition name="fade">
                    <div v-if="showDropdown" class="absolute right-0 z-50 mt-2 w-64 rounded-lg mr-4 xl:mr-0 bg-white border border-gray-500">
                        <div class="border-b px-4 py-2 text-sm text-gray-700 flex justify-between">
                            <span>Notifications</span>
                            <form id="clearAll" @submit.prevent="form.patch(route('markAsRead'))" ></form>
                            <button type="submit" class="underline" form="clearAll">Clear All</button>
                        </div>
                        <ul class="max-h-60 overflow-auto">
                            <li
                                v-for="notification in notifications"
                                :key="notification.id"
                                class="cursor-pointer border-b border-gray-500 bg-gray-100 px-4 py-2"
                            >
                                {{ notification.message }}
                            </li>
                            <li v-if="notifications.length === 0" class="px-4 py-2 text-gray-500">No notifications yet.</li>
                        </ul>
                    </div>
                </transition>
            </div>
        </div>
    </header>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
