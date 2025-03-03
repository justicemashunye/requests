
<script setup>
//import Container from "../../Components/Container.vue";
//import Title from "../../Components/Title.vue";
import InputField from "../../Components/InputField.vue";
//import TextArea from "../../Components/TextArea.vue";
//import ImageUpload from "../../Components/ImageUpload.vue";
//import ErrorMessages from "../../Components/ErrorMessages.vue";
import PrimaryBtn from "../../Components/PrimaryBtn.vue";
import { useForm,Link } from "@inertiajs/vue3";

const props = defineProps({ position: Object });

const form = useForm({
    name: props.position.name,
    _method: "PUT",
});
</script>

<template>
  <Head title="- Edit Position" />

    <div class="flex items-center justify-center mx-auto">
        <h1 class="mx-auto text-4xl font-bold text-blue-600 mb-6">Edit Post</h1>
    </div>
    <div class="flex items-center justify-center mx-auto">
        <!--<ErrorMessages :errors="form.errors" />-->
        <div  class="px-6 text-center">
            <form @submit.prevent="form.post(route('positions.update', position.id))" class="grid grid-cols-2 gap-6">
                <div class="mx-auto  space-y-6">
                <InputField label="Name" icon="heading" placeholder="Post" v-model="form.name" />

                <PrimaryBtn :disabled="form.processing">Update</PrimaryBtn>
                </div>
            </form>
        </div>
    </div>        
</template>
