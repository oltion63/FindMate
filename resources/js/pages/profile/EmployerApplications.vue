<script setup lang="ts">
import UserApplications from '@/components/profile/UserApplications.vue';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import ShowCVEmployer from '@/pages/profile/ShowCVEmployer.vue';
import {Head} from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';

const props = defineProps({
    applications:{
        type:Array,
    },
})
const isEmCvVisible = ref(false);
const selectedCv = ref(null);

// Open modal with CV
const updateEmCvVisibility = ({ cvUrl, value }) => {
    selectedCv.value = cvUrl;
    isEmCvVisible.value = value;
};
const closeCvModal = () => {
    isEmCvVisible.value = false;
    selectedCv.value = null;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Applications',
        href: '/employerApplications',
    },
];
</script>

<template>
    <Head title="Applications"/>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="max-w-6xl mx-auto w-full">
            <UserApplications v-if="$page.props.auth.user.role === 'employer'" :applications="applications" :isEmCvVisible="isEmCvVisible" @update:isEmCvVisible="updateEmCvVisibility"/>
        </div>
        <ShowCVEmployer v-if="isEmCvVisible" :selectedCv="selectedCv" @close="closeCvModal"/>
    </AppLayout>
</template>
