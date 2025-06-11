<script setup lang="ts">
import EmployeeApplications from '@/components/profile/EmployeeApplications.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import {Head} from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

const props = defineProps({
    employeeApplications:{
        type:Array,
    },
})
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'My Applications',
        href: '/employeeApplications',
    },
];
</script>

<template>
    <Head title="My Applications"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-6xl mx-auto w-full">
            <EmployeeApplications v-if="$page.props.auth.user.role === 'employee'" :employeeApplications="employeeApplications"  />

        </div>
    </AppLayout>

</template>
