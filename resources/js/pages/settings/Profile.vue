<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

import DeleteUser from '@/components/DeleteUser.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem } from '@/types';
import { ref } from 'vue';

const props = defineProps({
    cities:{
        type:Object,
    },
    mustVerifyEmail:{
        type:Boolean,
    },
    status:{
        type:String,
    },
})

// Get the authenticated user
const user = usePage().props.auth.user;

// Form setup for image upload
const imgform = useForm({
    image: null, // Initialize the form with an empty image field
});

// Ref for image preview
const imagePreview = ref(user.image.startsWith('http') ? user.image : '/storage/' + user.image || ''); // Assuming `user.profile_image_url` contains the current image URL

// Method to handle file input change
const handleFileChange = (event) => {
    const file = event.target.files[0];
    imgform.image = file;

    // Generate a preview URL for the selected file
    if (file) {
        imagePreview.value = URL.createObjectURL(file);
    } else {
        imagePreview.value = user.image || ''; // Reset to the current profile image if no file is selected
    }
};


console.log(user.city?.name)

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const form = useForm({
    name: user.name,
    lastname: user.lastname,
    email: user.email,
    city_id: user.city_id,
    address: user.address,
    birthday: user.birthday,
    phone: user.phone,
    gender: user.gender,
    role: user.role,
});

const submit = () => {
    console.log(form)
    form.patch(route('profile.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Profile settings" />

        <SettingsLayout>
            <div class="md:flex justify-between md:space-x-6 space-y-4">
                <div class="flex flex-col space-y-6 pb-4 border-b border-gray-300 md:pb-0 md:border-b-0">
                    <HeadingSmall title="Profile information" description="Update your personal information" />

                    <form @submit.prevent="submit" class="space-y-6">
                        <div id="row1" class="flex justify-between space-x-2">
                            <div class="grid gap-2 w-1/2">
                                <Label for="name">Name</Label>
                                <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" placeholder="Full name" />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="grid gap-2 w-1/2">
                                <Label for="lastname">Lastname</Label>
                                <Input id="lastname" class="mt-1 block w-full" v-model="form.lastname" required autocomplete="lastname" placeholder="Last name" />
                                <InputError class="mt-2" :message="form.errors.lastname" />
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <Label for="email">Email address</Label>
                            <Input
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="username"
                                placeholder="Email address"
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div id="row2" class="flex justify-between space-x-2">
                            <div class="grid gap-2 w-1/2">
                                <Label for="city_id">City</Label>
                                <select
                                    name="city_id"
                                    id="city_id"
                                    ref="input"
                                    v-model="form.city_id"
                                    class="rounded-md border border-gray-200 p-2 shadow-sm  mt-1 block w-full">
                                    <option disabled :value="user.city_id" selected>{{user.city?.name}}</option>
                                    <option v-for="city in props.cities" :key="city.id" :value="city.id">{{city.name}}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.city_id" />
                            </div>

                            <div class="grid gap-2 w-1/2">
                                <Label for="address">Address</Label>
                                <Input id="address" class="mt-1 block w-full" v-model="form.address" required autocomplete="address" placeholder="Address" />
                                <InputError class="mt-2" :message="form.errors.address" />
                            </div>
                        </div>

                            <div class="grid gap-2">
                                <Label for="birthday">Birthday</Label>
                                <Input id="birthday" class="mt-1 block w-full" v-model="form.birthday" required autocomplete="birthday" placeholder="Birthday" type="date" />
                                <InputError class="mt-2" :message="form.errors.birthday" />
                            </div>

                        <div id="row4" class="flex justify-between space-x-2">
                            <div class="grid gap-2 w-1/2">
                                <Label for="phone">Phone</Label>
                                <Input id="phone" class="mt-1 block w-full" v-model="form.phone" required autocomplete="phone" placeholder="Phone" />
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>

                            <div class="grid gap-2 w-1/2">
                                <Label for="gender">Gender</Label>
                                <select
                                    name="gender"
                                    id="gender"
                                    ref="input"
                                    v-model="form.gender"
                                    class="rounded-md border border-gray-200 p-2 shadow-sm  mt-1 block w-full">
                                    <option disabled value="">gender</option>
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.birthday" />
                            </div>
                        </div>

                        <div v-if="mustVerifyEmail && !user.email_verified_at">
                            <p class="-mt-4 text-sm text-muted-foreground">
                                Your email address is unverified.
                                <Link
                                    :href="route('verification.send')"
                                    method="post"
                                    as="button"
                                    class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:!decoration-current dark:decoration-neutral-500"
                                >
                                    Click here to resend the verification email.
                                </Link>
                            </p>

                            <div v-if="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                                A new verification link has been sent to your email address.
                            </div>
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

                <div class="w-px bg-gray-300 mx-2"></div>

                <div class="w-full md:w-1/2 mx-auto">
                    <form
                        @submit.prevent="imgform.post(route('updateUserImage'))"
                        enctype="multipart/form-data"
                        class="border-b border-gray-300 pb-4"
                    >
                        <div class="flex flex-col justify-center items-center">
                            <!-- Preview of the current or selected image -->
                            <div  v-if="imagePreview" class="mt-2">
                                <img :src="imagePreview" alt="Profile Preview" class="w-36 h-36 object-cover rounded-full border-2 border-gray-500" />
                            </div>

                            <input
                                id="image_profile"
                                name="image"
                                type="file"
                                class="hidden"
                                @change="handleFileChange"
                                accept="image/*"
                            />

                            <InputError class="mt-2" :message="imgform.errors.image" />
                        </div>

                        <div class="flex justify-center space-x-4">
                            <label
                                for="image_profile"
                                class="inline-flex items-center px-3 py-2 md:px-5 md:py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center  bg-[#FFCB74] rounded-lg hover:bg-[#e6b55f]"
                            >
                                Choose File
                            </label>
                            <button
                                type="submit"
                                class="inline-flex items-center px-3 py-2 md:px-5 md:py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800"
                            >
                                Update Image
                            </button>
                        </div>
                    </form>
                    <DeleteUser class="md:w-3/4 mx-auto mt-8" />
                </div>

            </div>

        </SettingsLayout>
    </AppLayout>
</template>
