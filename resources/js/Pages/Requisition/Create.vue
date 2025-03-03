<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


const props = defineProps({ urgencyOptions: Array });
const user = usePage().props.auth.user;

const products = [
      { value: 'item', label: 'Item' },
      { value: 'service', label: 'Service' },
      { value: 'fuel', label: 'Fuel' },
      { value: 'cleaningService', label: 'Cleaning Services' },
    ];
  
// Initialize the form
const form = useForm({
    typeOfProduct: '',
    nameOfProduct: '',
    description: '',
    quantity: '',
    purpose: '',
    estimatedCost: '',
    urgency: '',
    //program_id: '', // Selected program ID
});

</script>


<template>
    
    <!--<Head title="- New Requisition" />-->
  
    <div class="flex items-center justify-center mx-auto">
        <h1 class="mx-auto text-4xl font-bold text-blue-600 mb-6">Create Requisition</h1>
    </div>
    <div class="flex items-center justify-center mx-auto">
        <!--<ErrorMessages :errors="form.errors" />-->
        <div id="second" class="flex flex-col space-y-6">
            <form
            @submit.prevent="form.post(route('requisitions.store'))"

                class="grid grid-cols-2 gap-6"
                >
                <div class="flex flex-col space-y-6">

                    <label for="typeOfProduct">Type of Product</label>
                    <select 
                        id="typeOfProduct" 
                        v-model="form.typeOfProduct" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                        <option value="">Select type of product</option>
                        <option v-for="product in products" :key="product.value" :value="product.value">
                            {{ product.label }}
                        </option>
                    </select>
                    <!--
                        <div>
                            <InputField
                                label="Type of Product"
                                icon="heading"
                                placeholder="Type of Product"
                                v-model="form.typeOfProduct"
                            />
                        </div>
                    -->
                    <div>
                        <InputField
                            label="Name of Product"
                            icon="heading"
                            placeholder="Name of Product"
                            v-model="form.nameOfProduct"
                        />
                    </div>

                    <div>
                        <InputField
                            label="Description"
                            icon="heading"
                            placeholder="Briefly describe your Product"
                            v-model="form.description"
                        />
                    </div>

                    <div>
                        <InputField
                            label="Quantity"
                            icon="heading"
                            placeholder="Quantity"
                            v-model="form.quantity"
                        />
                    </div>

                    <div>
                        <InputField
                            label="Purpose"
                            icon="heading"
                            placeholder="Purpose"
                            v-model="form.purpose"
                        />
                    </div>

                    <div>
                        <InputField
                            label="Estimated cost"
                            icon="heading"
                            placeholder="Estimated cost"
                            v-model="form.estimatedCost"
                        />
                    </div>

                    <select 
                        id="urgency" 
                        v-model="form.urgency" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                        <option value="" disabled>Select Urgency</option>
                        <option v-for="option in urgencyOptions" :key="option" :value="option">
                            {{ option }}
                        </option>
                    </select>




                    <!--
                    <label for="program_id">Program</label>
                    <select 
                    id="program_id" 
                    v-model="form.program_id" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                    <option value="">Select a program</option>
                    <option v-for="program in programs" :key="program.id" :value="program.id">
                        {{ program.name }}
                    </option>
                    </select>
                    -->

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