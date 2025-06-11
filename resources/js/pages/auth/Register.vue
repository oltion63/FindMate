<script setup>
import AuthBase from '@/layouts/AuthLayout.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import {ref} from "vue";
import ImgInput from "@/components/ImgInput.vue";

defineProps({
    cities: {
        type: Array,
    }
})

const input = ref('')
const form = useForm({
    name: '',
    lastname: '',
    email: '',
    birthday: '',
    city_id: '',
    gender: '',
    role: '',
    phone: '',
    image: null,
    password: '',
    password_confirmation: '',
});
const isFocused = ref(false);
console.log(form);
const submit = () => {
    console.log(form)
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
const imageSrc = ref('');
const previewImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imageSrc.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        imageSrc.value = '';
    }
};
</script>

<template>
    <AuthBase>
        <Head title="Register" />
        <div class="lg:flex lg:justify-between lg:space-x-60 mb-4">
        <div class="w-[30rem] my-auto hidden lg:block">
            <span class="text-6xl text-[#FFCB74] text-center font-bold flex justify-center mb-6">Join Us Today</span>
            <p class="text-center text-lg text-gray-100 mb-6">Create an account to start your journey with us.</p>
        </div>
        <div class="z-20 mt-6 w-full overflow-hidden bg-gradient-to-b from-[#FFCB74] via-gray-100 to-gray-300 px-6 pb-4 shadow-lg sm:max-w-md sm:rounded-lg">
            <img src="/storage/images/logo.png" width="150px" height="150px" class="mx-auto" alt="logo">
            <form @submit.prevent="submit">
            <div class="flex justify-between mt-4 h-full items-center">
                <div class="w-1/2 h-full space-y-12">
                    <div>
                        <ImgInput
                            id="image"
                            accept="image/*"
                            class="hidden"
                            name="image"
                            v-model="form.image"
                            @change="previewImage"
                            autocomplete="image"
                        />
                        <InputError class="mt-2" :message="form.errors.image"/>
                    </div>
                    <div>
                        <label for="image"
                               class="text-black bg-[#FFCB74] hover:bg-[#2f2f2f] hover:text-white  font-medium rounded-lg text-sm px-2 py-2.5 hover:cursor-pointer dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            Choose Image
                        </label>
                    </div>

                </div>

                <div class="w-1/2">
                    <div v-if="imageSrc" class="items-center flex justify-center">
                        <img :src="imageSrc" alt="Image Preview"
                             class="w-28 h-28 object-cover rounded-full border-2 border-[#FFCB74]"/>
                    </div>
                </div>
            </div>

            <div class="flex justify-between space-x-1 mt-4">
                <div class="w-1/2">

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full pl-3"
                        placeholder="Name"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="w-1/2">

                    <TextInput
                        id="lastname"
                        type="text"
                        class="mt-1 block w-full pl-3"
                        placeholder="Last Name"
                        v-model="form.lastname"
                        autocomplete="lastname"
                    />

                    <InputError class="mt-2" :message="form.errors.lastname"/>
                </div>
            </div>
            <div class="mt-4">

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full pl-3"
                    placeholder="Email"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <TextInput
                    id="birthday"
                    type="date"
                    class="mt-1 block w-full pl-3"
                    placeholder="Birthday"
                    v-model="form.birthday"
                    autocomplete="birthday"
                />

                <InputError class="mt-2" :message="form.errors.birthday"/>
            </div>

            <div class="flex justify-between space-x-1 mt-4">
                <div class="w-1/2">
                    <select
                        name="city_id"
                        id="city_id"
                        ref="input"
                        v-model="form.city_id"
                        class="rounded-md border-gray-300 p-1 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 pl-3 block w-full"
                        :class="{'text-gray-500' : !form.city_id}">
                        <option disabled value="">City</option>
                        <option class="text-gray-800" v-for="city in cities" :key="city.id" :value="city.id">{{city.name}}</option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.city_id"/>
                </div>
                <div class="w-1/2">
                    <select
                        name="role"
                        id="role"
                        ref="input"
                        v-model="form.role"
                        class="rounded-md border-gray-300 p-1 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full pl-3"
                        :class="{'text-gray-500' : !form.role}">
                        <option disabled value="">Role</option>
                        <option class="text-gray-800" value="employer">Employer</option>
                        <option class="text-gray-800" value="employee">Employee</option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.role"/>
                </div>
            </div>

            <div class="flex justify-between space-x-1 mt-4">
                <div class="w-1/2">
                    <TextInput
                        id="phone"
                        type="text"
                        class="mt-1 block w-full pl-3"
                        placeholder="Phone"
                        v-model="form.phone"
                        autocomplete="phone"
                    />

                    <InputError class="mt-2" :message="form.errors.phone"/>
                </div>
                <div class="w-1/2">
                    <select
                        name="gender"
                        id="gender"
                        ref="input"
                        v-model="form.gender"
                        class="rounded-md border-gray-300 p-1 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full pl-3"
                        :class="{'text-gray-500' : !form.gender}">
                        <option disabled value="">Gender</option>
                        <option class="text-gray-800" value="female">Female</option>
                        <option class="text-gray-800" value="male">Male</option>
                    </select>

                    <InputError class="mt-2" :message="form.errors.gender"/>
                </div>
            </div>

            <div class="flex justify-between space-x-1 mt-4">
                <div class="w-1/2">
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full pl-3"
                        placeholder="Password"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="w-1/2">
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full pl-3"
                        placeholder="Confirm Password"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>
            </div>



            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4 bg-[#2f2f2f] hover:bg-[#FFCB74] hover:text-[#111111]"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
        </div>
        </div>
    </AuthBase>
</template>
