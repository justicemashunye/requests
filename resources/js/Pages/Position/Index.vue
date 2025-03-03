<template>
  <div v-if="positions">
    <div class="mt-6 ml-5 text-center">
    <h1 class="text-4xl font-bold text-blue-600 mb-6 py-4">MoFEDIP Posts</h1>
    <table class="w-3/4 mx-auto  border-gray-300 border-collapse overflow-hidden rounded-md text-base ring-1 ring-slate-300 dark:ring-slate-600 bg-white shadow-lg">
        <thead class="bg-slate-300 text-xs uppercase text-slate-600 dark:text-slate-400 dark:bg-slate-900">
        <tr>
            <th class="p-3 border border-gray-300">Position ID</th>
            <th class="p-3 border border-gray-300">Position Name</th>
            <th class="p-3 border border-gray-300">Edit</th>
            <th class="p-3 border border-gray-300">Delete</th>
        </tr>
        </thead>
        <tbody>
        <tr
        v-for="position in positions"
                                :key="position.id"
                                class="border-b border-slate-200 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-600 dark:border-slate-600"
        
        >
            <td class="p-3 border border-gray-300">{{ position.id }}</td>
            <td class="p-3 border border-gray-300">{{ position.name }}</td>
            <td
                class="py-3 pr-3 text-indigo-500"
                            >
                                <Link :href="route('positions.edit', position.id)"
                                    >Edit</Link
                                >
                            </td>
            <td class="py-3 pr-3  text-red-500">
                <button type="button" @click="deleteposition(position.id)">
                                    Delete
                </button>
            </td>     
        </tr>
        </tbody>
    </table>
    </div>
</div>

</template>


<script setup>
    //import Title from "../Components/Title.vue";
    //import PaginationLinks from "../Components/PaginationLinks.vue";
    //import SessionMessages from "../Components/SessionMessages.vue";
    import { router,Link } from "@inertiajs/vue3";
 

    defineProps({
        positions: Object,
        status: String
    });

    const deleteposition = (id) => {
        if (confirm("Are you sure?")) {
            router.delete(route('positions.destroy', id))
        };
    };

</script>




<style>

</style>