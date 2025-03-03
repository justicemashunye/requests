<template>
  <div class="container mx-auto max-w-2xl px-4 py-8">
    <!-- Requisition Details -->
    <div class="mb-8 text-center">
      <h2 class="text-3xl font-bold mb-4">{{ requisition.nameOfProduct }}</h2>
      <p class="text-lg font-semibold bg-gray-100 rounded-lg p-3 inline-block">
        Current Stage: {{ requisition.status }}
        <span 
            class="ml-2 px-2 py-1 rounded text-xs font-semibold"
            :class="{
                'bg-red-800 text-white': requisition.current_status_duration > 72,
                'bg-red-600 text-white': requisition.current_status_duration > 48 && requisition.current_status_duration <= 72,
                'bg-red-400 text-white': requisition.current_status_duration > 24 && requisition.current_status_duration <= 48,
                'bg-green-400 text-gray-700': requisition.current_status_duration <= 24
            }"
        >
            {{ Math.round(requisition.current_status_duration) }}h
        </span>
      </p>
    </div>

    <!-- Approval Timeline -->
    <div class="space-y-8">
      <div v-if="approvalHistory.length === 0" class="text-center text-gray-500">
        No approval history found
      </div>
      
      <div 
        v-for="approval in approvalHistory"  
        :key="approval.id" 
        class="flex items-start gap-6"
      >
        <div class="w-32 flex-shrink-0">
          <div class="text-right pr-4">
            <span 
              class="inline-block font-semibold px-3 py-1 rounded-full text-sm"
              :class="{
                'bg-green-100 text-green-800': approval.status === 'approved',
                'bg-red-100 text-red-800': approval.status === 'rejected'
              }"
            >
              {{ approval.status }}
            </span>
          </div>
        </div>
        
        <div class="flex-1 pl-4 border-l-2 border-gray-200 space-y-2">
          <p class="font-medium text-gray-900">
            {{ approval.stage }} stage
            <span v-if="approval.approver">
              • By {{ approval.approver.name }}
            </span>
          </p>
          <p class="text-gray-600" v-if="approval.comments">
            Comments: {{ approval.comments }}
          </p>
          <p class="text-sm text-gray-500">
            {{ formatDate(approval.created_at) }}
            <span class="ml-2 px-2 py-1 rounded text-xs font-semibold bg-green-400">
              {{ calculateDuration(approval.created_at) }}h
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  requisition: {
    type: Object,
    required: true
  },
  approvalHistory: {
    type: Array,
    default: () => []
  }
});

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

const calculateDuration = (dateString) => {
  const now = new Date();
  const createdAt = new Date(dateString);
  return Math.floor((now - createdAt) / (1000 * 60 * 60)); // Duration in hours
};
</script>