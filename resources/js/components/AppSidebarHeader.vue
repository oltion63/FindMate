<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import { usePage, useForm } from '@inertiajs/vue3';
import { onMounted, ref, onBeforeUnmount } from 'vue';
import axios from 'axios'
import debounce from 'lodash/debounce'
import { useRoute } from 'ziggy-js';
import {Bell} from 'lucide-vue-next';

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
    <header class="flex h-16 items-center justify-between mx-4 space-x-2 border-b border-gray-300">
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
                    <Bell />
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
