<script setup lang="ts">
import { Head, useForm,  } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem } from '@/types';
import TextArea from '@/components/jobs/TextArea.vue';
import ImgInput from "@/components/ImgInput.vue";
import {ref} from "vue";
import ConfirmationModal from '@/components/ConfirmationModal.vue';


const props = defineProps({
    company:{
        type:Object,
    }
});
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Company settings',
        href: '/settings/company',
    },
];


const form = useForm({
    name: props.company?.name,
    description: props.company?.description,
    phone: props.company?.phone,
    address: props.company?.address,
    website: props.company?.website,
    email: props.company?.email,
});

const Imgform = useForm({image: ""});
const imageSrc = ref(props.company?.image ? `/storage/${props.company?.image}` : "");
const updateImage = () => {
    Imgform.post(route("updateCompanyImage", props.company.id), {
        preserveScroll: true,
        onSuccess: () => {
            imageSrc.value = Imgform.image ? URL.createObjectURL(Imgform.image) : `/storage/${props.company.image}`;
            Imgform.image = "";
            document.getElementById("image").value = "";
        },
    });
};
const previewImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        Imgform.image = file;
        imageSrc.value = URL.createObjectURL(file);
    }
};
const showDeleteModal = ref(false);
const confirmDelete = () => {
    form.delete(route('deleteCompany', { id: props.company.id }));
    showDeleteModal.value = false;
};

const submit = () => {
    form.patch(route('updateCompany', {id: props.company.id}, { forceFormData: true }), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Company settings" />

            <SettingsLayout>

                <div v-if="!company">
                    No company added
                </div>

                <div v-else class="flex justify-between space-x-10">
                    <div class="flex w-full flex-col space-y-6">
                        <HeadingSmall title="Company information" description="Update your company information" />

                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid gap-2">
                                <Label for="name">Name</Label>
                                <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" placeholder="Full name" />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="description">Description</Label>
                                <TextArea
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full h-auto bg-white "
                                    v-model="form.description"
                                    required
                                    autocomplete="description"
                                />
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="phone">Phone</Label>
                                <Input id="phone" class="mt-1 block w-full" v-model="form.phone" required autocomplete="phone" placeholder="Phone" />
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="address">Address</Label>
                                <Input id="address" class="mt-1 block w-full" v-model="form.address" required autocomplete="address" placeholder="Address" />
                                <InputError class="mt-2" :message="form.errors.address" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="website">Website</Label>
                                <Input id="website" class="mt-1 block w-full" v-model="form.website" required autocomplete="website" placeholder="Website" />
                                <InputError class="mt-2" :message="form.errors.website" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="email">Email</Label>
                                <Input id="email" class="mt-1 block w-full" v-model="form.email" required autocomplete="email" placeholder="Email" />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>


                            <div class="flex items-center gap-4">
                                <Button :disabled="form.processing">Save</Button>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                                </Transition>
                            </div>
                        </form>
                    </div>
                    <div class="w-3/4 mx-auto">
                        <form @submit.prevent="updateImage" >
                            <div class="flex flex-col justify-center items-center">
                                <div v-if="imageSrc" class="mt-2">
                                    <img
                                        :src="imageSrc"
                                        alt="Image Preview"
                                        class="w-36 h-36 object-cover rounded-full border-2 border-gray-500"
                                    />
                                </div>
                                <ImgInput
                                    id="image"
                                    accept="image/*"
                                    class="hidden"
                                    name="image"
                                    @change="previewImage"
                                />
                                <InputError class="mt-2" :message="Imgform.errors.image"/>
                            </div>


                            <div class="flex justify-center space-x-4">
                                <label
                                    for="image"
                                    class="inline-flex items-center px-3 py-2 md:px-5 md:py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-gray-400 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800"
                                >
                                    Choose File
                                </label>
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-3 py-2 md:px-5 md:py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary rounded-lg "
                                >
                                    Update Image
                                </button>
                            </div>
                        </form>
                        <form id="deleteCompany" @submit.prevent="form.delete(route('deleteCompany', {id: props.company.id}))"></form>
                        <div class="flex justify-center items-center">
                            <button
                                @click="showDeleteModal=true"
                                class="inline-flex items-center px-3 py-2 md:px-5 md:py-2.5 mt-4 sm:mt-6  text-sm font-medium text-center text-white bg-red-600 rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                                Delete Company
                            </button>
                        </div>
                    </div>
                </div>
                <ConfirmationModal
                    :show="showDeleteModal"
                    title="Confirm Deletion"
                    message="Are you sure you want to delete your Company?"
                    @close="showDeleteModal = false"
                    @confirm="confirmDelete"
                />
            </SettingsLayout>
    </AppLayout>
</template>
