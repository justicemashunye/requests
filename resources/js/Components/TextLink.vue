<template>
    <Link
        :href="route(routeName)"
        class="text-indigo-500 hover:text-indigo-600 font-medium underline dark:text-indigo-400 dark:hover:text-indigo-500"
        >{{ label }}</Link
    >
</template>

<script setup>
defineProps({
    routeName: String,
    label: String,
});
</script>


<style>
  /* empty style block */
</style>