<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


const props = defineProps({ departments: Object,positions: Object });

const form = useForm({

    name: '',
    email: '',
    ecNumber:'',
    phoneNumber: '',
    officeExtePhone: '',
    ecNumber:'',
    department_id:'',
    position_id:'',


    //isSuspended:false
    password: '',
    password_confirmation: '',

    // Additional fields
    



});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />
        <form @submit.prevent="submit">
            <div class="space-y-4">
                <InputLabel for="name" value="Full Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4 mb-3">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="ecNumber" value="EC Number" />
                <TextInput
                    id="ecNumber"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.ecNumber"
                    required
                    autofocus
                    autocomplete="ecNumber"
                />

                <InputError class="mt-2" :message="form.errors.ecNumber" />
            </div>
            <div class="space-y-6">
                <select
                id="department"
                v-model="form.department_id"
                class="mt-4 mb-4 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
            >
                <option value="" disabled>Select your Department</option>
                <option
                    v-for="(department, id) in departments"
                    :key="id"
                    :value="department.id"
                >
                    {{ department.name }}
                </option>
            </select>
            </div>


            <div class="space-y-6">
                <select
                id="position"
                v-model="form.position_id"
                class="mt-4 mb-4 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
            >
                <option value="" disabled>Select your Post</option>
                <option
                    v-for="(position, id) in positions"
                    :key="id"
                    :value="position.id"
                >
                    {{ position.name }}
                </option>
            </select>
            </div>
            
            <div class="mt-4">
                <InputLabel for="phoneNumber" value="Phone Number" />

                <TextInput
                    id="phoneNumber"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.phoneNumber"
                    required
                    autofocus
                    autocomplete="phoneNumber"
                />

                <InputError class="mt-2" :message="form.errors.phoneNumber" />
            </div>

            <div class="mt-4">
            <InputLabel for="officeExtePhone" value="Extension Phone Number " />

            <TextInput
                id="officeExtePhone"
                type="text"
                class="mt-1 block w-full"
                v-model="form.officeExtePhone"
                required
                autofocus
                autocomplete="officeExtePhone"
            />

            <InputError class="mt-2" :message="form.errors.officeExtePhone" />
            </div>
            


            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
