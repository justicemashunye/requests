<template>
    <h1 class="text-3xl font-bold mb-4 text-center">Requisition Details</h1>
    <div class="max-w-4xl mx-auto p-4 flex">
    <div id="left" class="w-3/4">
        <table class="table-auto w-full border border-gray-400">
        <tbody>
          <tr>
            <th class="px-4 py-2 border border-gray-300">User ID</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.user.name }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 border border-gray-300">Department ID</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.department.name }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 border border-gray-300">Type of Product</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.typeOfProduct }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 border border-gray-300">Name of Product</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.nameOfProduct }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 border border-gray-300">Description</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.description }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 border border-gray-300">Quantity</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.quantity }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 border border-gray-300">Purpose</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.purpose }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 border border-gray-300">Estimated Cost</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.estimatedCost }}</td>
          </tr>
          <tr>
            <th class="px-4 py-2 border border-gray-300">Status</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.status }}</td>

            <div id="acceptorreject" v-if="requisition.status==='supervisor'">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-5" @click="showApproveModalState = true">Approve/Reject for Procurement</button>
            </div>

            <div id="acceptorreject" v-if="requisition.status==='procurement'">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-5" @click="showApproveModalState = true">Approve/Reject for Finance</button>
            </div>
            <div id="acceptorreject" v-if="requisition.status==='fulfilled'">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-5" @click="showApproveModalState = true">Please close your request</button>
            </div>

            <div id="acceptorreject" v-if="requisition.status==='finance'">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-5" @click="showApproveModalState = true">Approve/Reject for Fulfilled</button>
            </div>

            <div id="acceptorreject" v-if="requisition.status==='administration'">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-5" @click="showApproveModalState = true">Approve/Reject for Perm Secretary</button>
            </div>
    
          </tr>
          <tr>
            <th class="px-4 py-2 border border-gray-300">Urgency</th>
            <td class="px-4 py-2 border border-gray-300">{{ requisition.urgency }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="right" class="w-1/4">
    <button @click="openApproveModal">Approve Requisition</button>


  <div v-if="showApproveModalState" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
  <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
    <h3 class="text-lg font-medium mb-4">Approve/Reject Requisition</h3>
    
    <textarea 
      v-model="comments"
      placeholder="Enter comments..."
      class="w-full p-2 border rounded mb-4"
      required
    ></textarea>

    <div class="flex justify-end space-x-3">
      <button
        @click="closeApproveModal"
        class="px-4 py-2 text-gray-600 hover:text-gray-800"
      >
        Cancel
      </button>
      <button
        @click="reject"
        :disabled="isCommentEmpty"
        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        Reject
      </button>
      <button
        @click="approve"
        :disabled="isCommentEmpty"
        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        Approve
      </button>
    </div>
  </div>
</div>






    </div> 
  </div>
  </template>
  


  <script setup>
  import { ref, computed } from 'vue'; // Add computed import
  import { router } from "@inertiajs/vue3";
  
  const { user, requisition, department } = defineProps({
    requisition: {
      type: Object,
      required: true,
    },
  });
  
  const showApproveModalState = ref(false);
  const comments = ref('');
  
  // Computed property to check if comments are empty
  const isCommentEmpty = computed(() => {
    return comments.value.trim() === '';
  });
  
  const closeApproveModal = () => {
    showApproveModalState.value = false;
    comments.value = '';
  };
  
  const submitApproval = (action) => {
    if (isCommentEmpty.value) {
      alert('Comments are required!');
      return;
    }
  
    const url = `/requisitions/${requisition.id}/${action}`;
    router.post(url, {
      comments: comments.value,
      user_id: requisition.user_id,
      department_id: requisition.department_id,
    }, {
      onSuccess: () => {
        console.log(`Requisition ${action}ed successfully!`);
        closeApproveModal();
        router.visit('/requisitions');
      },
      onError: (errors) => {
        console.error(`Failed to ${action} requisition:`, errors);
      }
    });
  };
  
  const approve = () => submitApproval('approve');
  const reject = () => submitApproval('reject');
  
  </script>



<style>
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
  max-width: 90%;
}

textarea {
  width: 100%;
  height: 100px;
  margin-bottom: 10px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}
</style>