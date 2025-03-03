<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import InputField from "../../Components/InputField.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import { useForm } from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";


const props = defineProps({
    department: Object,
    programs: Object,
});


// Initialize the form with the current department data
const form = useForm({
    name: props.department.name,
    program_id: props.department.program?.program_id || '', // Pre-select the current program
    _method: "PUT",
});

</script>


<template>
  <Head title="- Edit Department" />

  <div  class="flex flex-col space-y-6">
    <div id="first" class="flex items-center justify-center mx-auto">
        <h1 class="mx-auto text-4xl font-bold text-blue-600 mb-6">Edit Department</h1>
    </div>
    <div id="second" class="max-w-lg mx-auto flex flex-col space-y-6"> 
      <form @submit.prevent="form.post(route('departments.update',department.id))" class="flex flex-col space-y-6">
        <InputField label="Name" icon="heading" placeholder="Department" v-model="form.name" />
        <div id="mainDiv">
          <label for="program_id">Program</label>
          <select 
            id="program_id" 
            v-model="form.program_id" 
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          >
            <option value="">Select a program</option>
            <option v-for="program in programs" :key="program.id" :value="program.id">
              {{ program.program_number }}
            </option>
          </select>
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
