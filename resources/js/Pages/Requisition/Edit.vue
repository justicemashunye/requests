<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import { useForm } from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


const props = defineProps({
    requisition: Object,
    urgencyOptions: Array 
});


const products = [
      { value: 'Item', label: 'Item' },
      { value: 'Service', label: 'Service' },
      { value: 'Fuel', label: 'Fuel' },
      { value: 'Cleaning Service', label: 'Cleaning Services' },
    ];


// Initialize the form with the current requisition data
const form = useForm({

    typeOfProduct:"",
    urgency:"",
    nameOfProduct: props.requisition.nameOfProduct,
    description: props.requisition.description,
    quantity: props.requisition.quantity,
    purpose: props.requisition.purpose,
    estimatedCost: props.requisition.estimatedCost,


    _method: "PUT",
});

</script>


<template>
  <Head title="- Edit Requisition" />

  <div  class="flex flex-col space-y-6">
    <div id="first" class="flex items-center justify-center mx-auto">
        <h1 class="mx-auto text-4xl font-bold text-blue-600 mb-6">Edit Requisition</h1>
    </div>
    <div id="second" class="max-w-lg mx-auto flex flex-col space-y-6"> 
      <form @submit.prevent="form.post(route('requisitions.update',requisition.id))" class="flex flex-col space-y-6">


        <div class="mb-6">
    <div class="flex items-center gap-4 mb-2">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Previously selected type:
        </label>
        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm">
            {{ requisition.typeOfProduct || 'Not specified' }}
        </span>
    </div>
    
    <div class="relative">
        <select 
            id="typeOfProduct" 
            v-model="form.typeOfProduct" 
            class="w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 
                   focus:ring-blue-500 focus:border-blue-500 
                   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                   dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        >
            <option value="">Select new type of product</option>
            <option 
                v-for="product in products" 
                :key="product.value" 
                :value="product.value"
            >
                {{ product.label }}
            </option>
        </select>
    </div>
</div>

        <InputField
            label="Name of Product"
            icon="heading"
            placeholder="Name of Product"
            v-model="form.nameOfProduct"
        />
        <InputField
            label="Quantity"
            icon="heading"
            placeholder="Quantity"
            v-model="form.quantity"
        />
        <InputField
            label="Purpose"
            icon="heading"
            placeholder="Purpose"
            v-model="form.purpose"
        />
        <InputField
            label="Estimated Cost"
            icon="heading"
            placeholder="Estimated Cost"
            v-model="form.estimatedCost"
        />


        <div class="mb-6">
    <div class="flex items-center gap-4 mb-2">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Current urgency level:
        </label>
        <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-lg text-sm capitalize">
            {{ requisition.urgency?.toLowerCase() || 'Not specified' }}
        </span>
    </div>

    <div class="relative">
        <select 
            id="urgency" 
            v-model="form.urgency" 
            class="w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 
                   focus:ring-blue-500 focus:border-blue-500 
                   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                   dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        >
            <option value="" disabled>Select new urgency level</option>
            <option 
                v-for="option in props.urgencyOptions" 
                :key="option" 
                :value="option"
                class="capitalize"
            >
                {{ option.toLowerCase() }}
            </option>
        </select>
    </div>
    
    <!-- Optional error message -->
    <div v-if="form.errors.urgency" class="mt-1 text-sm text-red-600 dark:text-red-400">
        {{ form.errors.urgency }}
    </div>
</div>

        <PrimaryBtn :disabled="form.processing">Update</PrimaryBtn>
      </form>
    </div>
    
      <div>
        <div v-if="form.errors.program_id" class="text-red-500">{{ form.errors.program_id }}</div>
      </div>

  </div>
  </template>

<style></style>
