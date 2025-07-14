<script setup lang="ts">
import {FileUser, FileHeart, FileCheck, Building2, LayoutList} from "lucide-vue-next"

const emit = defineEmits(['update:isModalVisible', 'update:isCvVisible']);
const props = defineProps({
    isModalVisible: {
        type: Boolean,
        default: false,
    },
    countApplied:{
        type:Number,
    },
    isCvVisible: {
        type: Boolean,
        default: true,
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
});

const openModal = () => {
    console.log('Modal open triggered');
    emit('update:isModalVisible', true); // Emit event for parent to handle
};
const openCv = () =>{
    emit('update:isCvVisible', true);
}
</script>

<template>
    <div
        id="stats"
        class="space-y-4 lg:space-y-0 max-w-72 sm:max-w-full lg:flex justify-evenly bg-[#2F2F2F] rounded-lg p-6 text-[#F6F6F6] text-sm"
    >
        <button
            v-if="$page.props.auth.user.role === 'employee'"
            class="flex space-x-2 text-start items-center"
            @click="openCv"
        >
            <FileUser class="w-10 h-10 text-[#FFCB74]" />
            <span class="grid items-center">
        <span>CV</span>
        <span
            v-if="!$page.props.auth.user.cv"
            class="font-semibold text-[#FFCB74]"
        >
          No CV Added
        </span>
        <span
            v-if="$page.props.auth.user.cv"
            class="font-semibold underline text-[#FFCB74]"
        >
          View your CV
        </span>
      </span>
        </button>

        <button
            v-if="$page.props.auth.user.role === 'employer'"
            class="flex space-x-2 items-center text-start"
            @click="openModal"
        >
            <Building2 class="w-10 h-10 text-[#FFCB74]" />
            <span class="grid items-center">
        <span>Company</span>
        <span
            v-if="$page.props.auth.user.company === null"
            class="font-semibold underline text-[#FFCB74]"
        >
          No Company Added
        </span>
        <span
            v-if="$page.props.auth.user.company !== null"
            class="font-semibold underline text-[#FFCB74]"
        >
          View your company
        </span>
      </span>
        </button>

        <span
            v-if="$page.props.auth.user.role === 'employee'"
            class="flex space-x-2 items-center"
        >
      <FileHeart class="w-10 h-10 text-[#FFCB74]" />
      <span class="grid items-center">
        <span>Saved Applications</span>
        <span class="font-semibold text-[#FFCB74]">
          {{ props.countSaved }}
        </span>
      </span>
    </span>

        <span
            v-if="$page.props.auth.user.role === 'employer'"
            class="flex space-x-2 items-center"
        >
      <FileUser class="w-10 h-10 text-[#FFCB74]" />
      <span class="grid items-center">
        <span>Applications</span>
        <span class="font-semibold text-[#FFCB74]">
          {{ props.countApplications }}
        </span>
      </span>
    </span>

        <span
            v-if="$page.props.auth.user.role === 'employee'"
            class="flex space-x-2 items-center"
        >
      <FileCheck class="w-10 h-10 text-[#FFCB74]" />
      <span class="grid items-center">
        <span>Applied</span>
        <span class="font-semibold text-[#FFCB74]">
          {{ props.countApplied }}
        </span>
      </span>
    </span>

        <span
            v-if="$page.props.auth.user.role === 'employer'"
            class="flex space-x-2 items-center"
        >
      <LayoutList class="w-10 h-10 text-[#FFCB74]" />
      <span class="grid items-center">
        <span>Posts</span>
        <span class="font-semibold text-[#FFCB74]">
          {{ props.countPosts }}
        </span>
      </span>
    </span>
    </div>
</template>
