<template>
    <div v-if="requisitions">
      <div class="mt-6 ml-5 text-center">
      <h1 class="text-4xl font-bold text-blue-600 mb-6 py-4">MoFEDIP Requisitions</h1>
      <table class="w-3/4 mx-auto  border-gray-300 border-collapse overflow-hidden rounded-md text-base ring-1 ring-slate-300 dark:ring-slate-600 bg-white shadow-lg">
          <thead class="bg-slate-300 text-xs uppercase text-slate-600 dark:text-slate-400 dark:bg-slate-900">
            <tr>
              <th class="p-3 border border-gray-400">By</th>
              <th class="p-3 border border-gray-400">Department</th>
              <th class="p-3 border border-gray-400">Type of Product</th>
              <th class="p-3 border border-gray-400">Name of Product</th>
              <th class="p-3 border border-gray-400">Quantity</th>
              <th class="p-3 border border-gray-400">Status/-Time in Hr</th>
              <th class="p-3 border border-gray-400">Urgency</th>
              <th class="p-3 border border-gray-400">Approve/Reject</th>
              <th class="p-3 border border-gray-400">Track Requisition</th>             
              <th  class="p-3 border border-gray-400">Edit</th>
          </tr>
          </thead>
          <tbody>
          <tr
          v-for="requisition in requisitions"
                                  :key="requisition.id"
                                  class="border-b border-slate-200 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-600 dark:border-slate-600"
          
          >
              <td class="p-3 border border-gray-300">{{ requisition.user.name }}</td>
              <td class="p-3 border border-gray-300">{{ requisition.department.name}} </td>
              <td class="p-3 border border-gray-300">{{ requisition.typeOfProduct }}</td>
              <td class="p-3 border border-gray-300">{{ requisition.nameOfProduct }}</td>
              <td class="p-3 border border-gray-300">{{ requisition.quantity }}</td>
              <td class="p-3 border border-gray-300">
                {{ requisition.status }}
                <span 
                    class="ml-2 px-2 py-1 rounded text-xs font-semibold"
                    :class="{
                        'bg-red-800 text-white': requisition.current_status_duration > 72,
                        'bg-red-600 text-white': requisition.current_status_duration > 48 && requisition.current_status_duration <= 72,
                        'bg-red-400 text-white': requisition.current_status_duration > 24 && requisition.current_status_duration <= 48,
                        'bg-green-400 text-gray-700': requisition.current_status_duration <= 24
                    }"
                  >
                  <span>
                    {{ Math.round(requisition.current_status_duration) }}h
</span>
                  </span>
              </td>
              <td class="p-3 border" :class="{
    'bg-red-100 border-red-300 text-red-700': requisition.urgency === 'very-urgent',
    'bg-yellow-100 border-yellow-300 text-yellow-700': requisition.urgency === 'urgent',
    'bg-green-100 border-green-300 text-green-700': requisition.urgency === 'normal'
}">
    {{ requisition.urgency }}
</td>


          <td class="p-3 border border-gray-300">

            <Link 
                :href="requisition.can_approve ? route('requisitions.show', requisition.id) : null" class="inline-flex items-center px-3 py-1.5 rounded-md text-sm transition-colors"
                :class="{
                    'bg-green-100 text-green-800 hover:bg-green-200': requisition.can_approve,
                    'bg-gray-100 text-gray-500 cursor-not-allowed': !requisition.can_approve
                }"
                :disabled="!requisition.can_approve"
                @click.prevent="requisition.can_approve ? null : $event.preventDefault()"
            >
                <span class="mr-1">✓✗</span>
                Review
            </Link>

</td>

<td class="p-3 border border-gray-300">
    <Link 
        :href="route('requisitions.track', requisition.id)"
        class="inline-flex items-center px-3 py-1.5 rounded-md text-sm transition-colors"
        :class="{
          'bg-blue-100 text-blue-800 hover:bg-blue-200': requisition.can_track,
          'bg-gray-100 text-gray-500 cursor-not-allowed': !requisition.can_track
        }"
      >
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
        </svg>
        Track
      </Link>
</td>

<td class="p-3 border border-gray-300">
    <Link 
        :href="requisition.can_edit ? route('requisitions.edit', requisition.id) : null"
        class="inline-flex items-center px-3 py-1.5 rounded-md text-sm transition-colors"
        :class="{
            'bg-red-800 text-white hover:bg-red-900': requisition.is_currently_rejected && requisition.can_edit,
            'bg-gray-100 text-gray-500 cursor-not-allowed': !requisition.can_edit
        }"
        :disabled="!requisition.can_edit"
    >
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
        </svg>
        {{ requisition.is_currently_rejected ? 'Revise' : 'Edit' }}
    </Link>
</td>

          </tr>
          </tbody>
      </table>
      </div>
  </div>
  
  </template>
  
  
  <script setup>
import { router, Link} from "@inertiajs/vue3";



  const props = defineProps({
      requisitions: Object,
      status: String,
    status_label: String,
  });



  const deleterequisition = (id) => {
      if (confirm("Are you sure?")) {
          router.delete(route('requisitions.destroy', id));
      }
  }
 
const reject = (requisitionId) => {
    router.post(`/requisitions/${requisitionId}/reject`);
}

const approve = (requisitionId) => {
  router.post(`/requisitions/${requisitionId}/approve`);
}



</script>
  
  
  
  
  <style>
  
  </style>