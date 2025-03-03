<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import { useForm } from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


   
// Initialize the form
const form = useForm({
    name: null,
});

// Submit function

const submitForm = () => {
    form.post('/positions', {
        onSuccess: () => {
            console.log('Form submitted successfully!');
        },
        onError: (errors) => {
            console.error('Form errors:', errors);
        },
    });
};




</script>

<template>
    
    <!--<Head title="- New Position" />-->
  
    <div class="flex items-center justify-center mx-auto">
        <h1 class="mx-auto text-4xl font-bold text-blue-600 mb-6">Create Post</h1>
    </div>
    <div class="flex items-center justify-center mx-auto">
        <!--<ErrorMessages :errors="form.errors" />-->
        <div id="second" class="flex flex-col space-y-6">
            <form
            @submit.prevent="form.post(route('positions.store'))"

                    class="grid grid-cols-2 gap-6"
                >
                <div class="flex flex-col space-y-6">
                    <div>
                        <InputField
                            label="Name"
                            icon="heading"
                            placeholder="Name of Post"
                            v-model="form.name"
                        />
                    </div>

                    <div>
                        <button
                            @click="submitForm"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</template>


<style></style>