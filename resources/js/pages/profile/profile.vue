<script setup lang="ts">
import EmployerPosts from '@/components/profile/EmployerPosts.vue';
import SavedPosts from '@/components/profile/SavedPosts.vue';
import UserInfo from '@/components/profile/UserInfo.vue';
import UserStats from '@/components/profile/UserStats.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import CompanyModal from '@/pages/jobs/CompanyModal.vue';
import EditCVModal from '@/pages/profile/EditCVModal.vue';
import ShowCVModal from '@/pages/profile/ShowCVModal.vue';
import UploadCVModal from '@/pages/profile/UploadCVModal.vue';
import type { BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref } from 'vue';

defineProps({
    user: {
        type: Object,
    },
    company: {
        type: Object,
    },
    applications: {
        type: Array,
    },
    employeeApplications: {
        type: Array,
    },
    countApplied: {
        type: Number,
    },
    currentCV: {
        type: String,
    },
    countPosts: {
        type: Number,
    },
    countSaved: {
        type: Number,
    },
    countApplications: {
        type: Number,
    },
    savedPosts: {
        type: Array,
    },
    employerPosts: {
        type: Array,
    },
});
const showModal = ref(false); // State to control modal visibility
const openModal = () => {
    showModal.value = true; // Set modal visibility to true
};
const isModalVisible = ref(false);
const updateModalVisibility = (value) => {
    isModalVisible.value = value;
};
const closeModal = () => {
    isModalVisible.value = false;
};

const isCvVisible = ref(false);
const updateCvVisibility = (value) => {
    isCvVisible.value = value;
};
const closeCv = () => {
    isCvVisible.value = false;
};

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

const showEditModal = ref(false);
const isEditModalVisible = ref(false);

const openEditModal = () => {
    showEditModal.value = true;
};
const closeEditModal = () => {
    isEditModalVisible.value = false;
};
const employees = ref([]);
const selectedReceiverId = ref('');

// Fetch accepted employees when component mounts (only for employer)
onMounted(async () => {
    if ($page.props.auth.user.role === 'employer') {
        try {
            const response = await axios.get('/employer/accepted-employees');
            employees.value = response.data;
        } catch (error) {
            console.error('Failed to fetch accepted employees:', error);
        }
    }
});
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
        <main class=" mx-auto sm:w-[90%] md:max-w-6xl ">
            <CompanyModal :company="company" v-if="isModalVisible" @close="closeModal" />
            <UploadCVModal v-if="showModal" :show="showModal" @close="showModal = false" />
            <EditCVModal :currentCV="currentCV" v-if="showEditModal" :show="showEditModal" @close="showEditModal = false"></EditCVModal>
            <ShowCVModal :user="user" v-if="isCvVisible" @close="closeCv" />

            <section class="flex justify-end py-8">
                <Link
                    v-if="(!company || company.length === 0) && $page.props.auth.user.role === 'employer'"
                    :href="route('createCompany')"
                    class="inline-block rounded-lg bg-[#2F2F2F] px-5 py-2.5 text-center text-sm font-medium text-white transition hover:bg-[#f0b24b]"
                >
                    Add Company
                </Link>

                <Link
                    v-if="company && company.length !== 0 && $page.props.auth.user.role === 'employer'"
                    :href="route('editCompany')"
                    class="inline-block rounded-lg bg-[#2F2F2F] px-5 py-2.5 text-center text-sm font-medium text-white transition hover:bg-[#f0b24b]"
                >
                    Edit Company
                </Link>

                <button
                    v-if="$page.props.auth.user.role === 'employee' && !$page.props.auth.user.cv?.file"
                    @click="openModal"
                    class="rounded-lg bg-[#2F2F2F] px-5 py-2.5 text-center text-sm font-medium text-white transition hover:bg-[#f0b24b]"
                >
                    Add CV
                </button>

                <button
                    v-if="$page.props.auth.user.role === 'employee' && $page.props.auth.user.cv?.file"
                    @click="openEditModal"
                    class="rounded-lg bg-[#2F2F2F] px-5 py-2.5 text-center text-sm font-medium text-white transition hover:bg-[#f0b24b]"
                >
                    Edit CV
                </button>
            </section>

            <div class="justify-center gap-9 lg:flex">
                <UserInfo :user="user" />
                <div class="w-full" id="right-side">
                    <UserStats
                        :isModalVisible="isModalVisible"
                        @update:isModalVisible="updateModalVisibility"
                        :countApplications="countApplications"
                        :countSaved="countSaved"
                        :countApplied="countApplied"
                        :countPosts="countPosts"
                        :isCvVisible="isCvVisible"
                        @update:isCvVisible="updateCvVisibility"
                    />
                    <SavedPosts v-if="$page.props.auth.user.role === 'employee'" :savedPosts="savedPosts" />
                    <EmployerPosts v-if="$page.props.auth.user.role === 'employer'" :employerPosts="employerPosts" />
                </div>
            </div>
        </main>
    </AppLayout>
</template>
