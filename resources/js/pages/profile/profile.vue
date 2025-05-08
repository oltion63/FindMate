<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
import EmployerPosts from '@/components/profile/EmployerPosts.vue';
import UserApplications from '@/components/profile/UserApplications.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import UserInfo from '@/components/profile/UserInfo.vue';
import type { BreadcrumbItem } from '@/types';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile',
        href: '/profile',
    },
];

</script>
<template>
    <Head title="Profile" />
    <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex justify-end space-x-4 items-end p-6">
<!--        <Link-->
<!--            class="text-white bg-gradient-to-br from-gray-800 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center"-->
<!--        >-->
<!--            Add Company-->
<!--        </Link>-->
        <Link
            class="text-white bg-gradient-to-br from-gray-800 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center"
        >
            Edit Company
        </Link>

    </div>
    <main class=" ">
        <div class="lg:flex justify-center gap-9 px-6">
            <UserInfo/>
            <div class="w-full" id="right-side">
                <UserApplications/>
                <EmployerPosts />
            </div>
        </div>
    </main>
    </AppLayout>
</template>
