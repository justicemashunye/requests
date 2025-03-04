<template>
    <div v-if="requisitions.length >0" class="m-20">
        <h2>{{ $page.props.auth.user.name  }} Today's Requisitions</h2>
      <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
        <thead>
          <tr>
            <th>Type of Product</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Purpose</th>
            <th>Status</th>
            <th>Urgency</th>
            <th>Track</th>
            <th>Created At</th>
            <th>Edit</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="requisition in requisitions" :key="requisition.id">
            <td>{{ requisition.typeOfProduct }}</td>
            <td>{{ requisition.nameOfProduct }}</td>
            <td>{{ requisition.description }}</td>
            <td>{{ requisition.quantity }}</td>
            <td>{{ requisition.purpose }}</td>
            <td>{{ requisition.status }}</td>
            <td>{{ requisition.urgency}}</td>
            <td> Track</td>
            <td>{{ requisition.created_at }}</td>
            <td>edit</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-else class="mx-10 my-10">
        <p>You do not have any requisitions today</p>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  
  const props = defineProps({
    requisitions: Array,
  });
  </script>