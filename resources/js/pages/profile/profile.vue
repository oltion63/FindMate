<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {Head, Link} from "@inertiajs/vue3";
import UserInfo from "@/components/profile/UserInfo.vue";
import UserStats from "@/components/profile/UserStats.vue";
import CompanyModal from "@/pages/jobs/CompanyModal.vue";
import UserApplications from "@/components/profile/UserApplications.vue";
import {ref, onMounted} from "vue";
import EmployeeApplications from "@/components/profile/EmployeeApplications.vue";
import UploadCVModal from "@/pages/profile/UploadCVModal.vue";
import ShowCVModal from "@/pages/profile/ShowCVModal.vue";
import ShowCVEmployer from "@/pages/profile/ShowCVEmployer.vue";
import EditCVModal from "@/pages/profile/EditCVModal.vue";
import SavedPosts from "@/components/profile/SavedPosts.vue";
import EmployerPosts from "@/components/profile/EmployerPosts.vue";
import type { BreadcrumbItem } from '@/types';
import axios from 'axios';



defineProps({
    user: {
        type: Object,
    },
    company:{
        type:Object,
    },
    applications:{
        type:Array,
    },
    employeeApplications:{
        type:Array,
    },
    countApplied:{
        type:Number,
    },
    currentCV:{
        type:String,
    },
    countPosts:{
        type:Number,
    },
    countSaved:{
        type:Number,
    },
    countApplications:{
        type:Number,
    },
    savedPosts:{
        type:Array,
    },
    employerPosts:{
        type:Array,
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
    <Head title="Profile"/>

    <AppLayout :breadcrumbs="breadcrumbs">
        <main class="mx-auto">
            <div class="flex justify-end items-end py-8 mx-4 xl:mx-0">
                <Link
                    v-if="(!company || company.length === 0) && $page.props.auth.user.role === 'employer'"
                    :href="route('createCompany')"
                    class="bg-[#2F2F2F] text-white hover:bg-[#f0b24b] transition font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-block"
                >
                    Add Company
                </Link>

                <Link
                    v-if="company && company.length !== 0 && $page.props.auth.user.role === 'employer'"
                    :href="route('editCompany')"
                    class="bg-[#2F2F2F] text-white hover:bg-[#f0b24b] transition font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-block"
                >
                    Edit Company
                </Link>

                <button
                    v-if="$page.props.auth.user.role === 'employee' && !$page.props.auth.user.cv?.file"
                    @click="openModal"
                    class="bg-[#2F2F2F] text-white hover:bg-[#f0b24b] transition font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    Add CV
                </button>

                <button
                    v-if="$page.props.auth.user.role === 'employee' && $page.props.auth.user.cv?.file"
                    @click="openEditModal"
                    class="bg-[#2F2F2F] text-white hover:bg-[#f0b24b] transition font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    Edit CV
                </button>

            </div>
            <CompanyModal :company="company" v-if="isModalVisible" @close="closeModal"/>
            <UploadCVModal  v-if="showModal" :show="showModal" @close="showModal = false" />
            <EditCVModal :currentCV="currentCV" v-if="showEditModal"  :show="showEditModal"  @close="showEditModal=false"></EditCVModal>
            <ShowCVModal :user="user" v-if="isCvVisible" @close="closeCv"/>


            <div class="lg:flex justify-center gap-9 mx-4 xl:mx-0 max-w-72 md:max-w-6xl">
                <UserInfo :user="user"/>
                <div class="w-full" id="right-side">
                    <UserStats :isModalVisible="isModalVisible" @update:isModalVisible="updateModalVisibility" :countApplications="countApplications" :countSaved="countSaved" :countApplied="countApplied" :countPosts="countPosts" :isCvVisible="isCvVisible" @update:isCvVisible="updateCvVisibility"/>
                    <SavedPosts v-if="$page.props.auth.user.role === 'employee'" :savedPosts="savedPosts"/>
                    <EmployerPosts v-if="$page.props.auth.user.role === 'employer'" :employerPosts="employerPosts"/>
                </div>
            </div>
        </main>
    </AppLayout>

</template>
