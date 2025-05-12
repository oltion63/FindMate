<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import {Head, Link} from "@inertiajs/vue3";
import UserInfo from "@/components/profile/UserInfo.vue";
import UserStats from "@/components/profile/UserStats.vue";
import UserApplications from "@/components/profile/UserApplications.vue";
import {ref} from "vue";
import EmployeeApplications from "@/components/profile/EmployeeApplications.vue";
import SavedPosts from "@/components/profile/SavedPosts.vue";
import EmployerPosts from "@/components/profile/EmployerPosts.vue";
import type { BreadcrumbItem } from '@/types';



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
            <div class="flex justify-end items-end py-8">
                <Link
                    v-if="(!company || company.length === 0) && $page.props.auth.user.role === 'employer'"
                    :href="route('createCompany')"
                    class="text-white bg-gradient-to-br from-gray-800 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    Add Company
                </Link>
                <Link
                    v-if="company && company.length !== 0 && $page.props.auth.user.role === 'employer'"
                    :href="route('profile.edit')+'#companyImg'"
                    class="text-white bg-gradient-to-br from-gray-800 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    Edit Company
                </Link>
                <button
                    v-if="$page.props.auth.user.role === 'employee' && !$page.props.auth.user.cv?.file"
                    @click = "openModal"
                    class="text-white bg-gradient-to-br from-gray-800 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    Add CV
                </button>
                <button
                    v-if="$page.props.auth.user.role === 'employee' && $page.props.auth.user.cv?.file"
                    @click = "openEditModal"
                    class="text-white bg-gradient-to-br from-gray-800 to-blue-500 hover:bg-gradient-to-bl hover:scale-105 transition font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                >
                    Edit CV
                </button>
            </div>
            <div class="lg:flex justify-center gap-9">
                <UserInfo :user="user"/>
                <div class="w-full" id="right-side">
                    <UserStats :isModalVisible="isModalVisible" @update:isModalVisible="updateModalVisibility" :countApplications="countApplications" :countSaved="countSaved" :countApplied="countApplied" :countPosts="countPosts" :isCvVisible="isCvVisible" @update:isCvVisible="updateCvVisibility"/>
                    <UserApplications v-if="$page.props.auth.user.role === 'employer'" :applications="applications" :isEmCvVisible="isEmCvVisible" @update:isEmCvVisible="updateEmCvVisibility"/>
                    <EmployeeApplications v-if="$page.props.auth.user.role === 'employee'" :employeeApplications="employeeApplications"  />
                    <SavedPosts v-if="$page.props.auth.user.role === 'employee'" :savedPosts="savedPosts"/>
                    <EmployerPosts v-if="$page.props.auth.user.role === 'employer'" :employerPosts="employerPosts"/>
                </div>
            </div>
        </main>
    </AppLayout>

</template>
