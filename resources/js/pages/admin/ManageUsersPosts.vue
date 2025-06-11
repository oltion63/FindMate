<script setup lang="ts">
import PostsTable from '@/components/dashboard/PostsTable.vue';
import UsersTable from '@/components/dashboard/UsersTable.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    Users: Array,
    Posts:Array,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Manage Users & Posts',
        href: '/admin/manageusers',
    },
];

</script>

<template>
    <Head title="Manage Users & Posts"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class=" rounded-lg text-white pt-2  max-w-6xl mx-auto space-y-10 ">
            <UsersTable :Users="Users"/>
            <PostsTable :Posts="Posts"/>
        </div>

    </AppLayout>
</template>
