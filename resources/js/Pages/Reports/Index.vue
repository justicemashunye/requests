<template>
  <div  class="reports-container">
    <!-- Left Column: User Requisitions -->
    <div class="infor-wrapper">
        <div v-if="userData.labels.length > 0" class="chart-wrapper">
          <h2>{{ $page.props.auth.user.name  }} Requisitions Statuses</h2>
          <PieChart
            title="Requisition Status Distribution"
            :datasets="userData.datasets"
            :labels="userData.labels"
            :status-labels="statusLabels"
          />
        </div>
        <div v-else class="no-requisitions-message">
          {{ $page.props.auth.user.name + " "}}, you  do not have any requisitions.
        </div>

        <div class="user-table mt-20 mx-4">
          <h3 class="text-center mb-2">{{$page.props.auth.user.name}} Requsitions Numbers</h3>
          <div class="overflow-x-auto">
              <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gradient-to-r from-blue-300 to-purple-500 text-white">
                  <tr>
                    <th class="text-white uppercase px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider border-b border-gray-200">
                      Today
                    </th>
                    <th class="text-white uppercase px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
                      This Week
                    </th>
                    <th class="text-white uppercase px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
                      This Month
                    </th>
                    <th class="text-white uppercase px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
                      This Year
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr justify-content-center>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                      {{ userTimePeriodCounts.today }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                      {{ userTimePeriodCounts.this_week }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                      {{ userTimePeriodCounts.current_month }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                      {{ userTimePeriodCounts.current_year }}
                    </td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>
    </div>

    
    
    <!-- Right Column: Department Requisitions -->
    <div class="infor-wrapper">
        <div  v-if="departmentData.labels.length > 0" class="chart-wrapper">
          <h2>{{ $page.props.auth.user?.department?.name + " "   }}Department Requisitions Statuses</h2>
          <PieChart
            title="Department Requisitions"
            :datasets="departmentData.datasets"
            :labels="departmentData.labels"
            :status-labels="statusLabels"
          />
        </div>

        <div v-else class="no-requisitions-message">
          {{ $page.props.auth.user.department.name  + " "}} department  does not  have any requisitions.
        </div>
 
          <div class="user-table mt-20 mx-4">
          <h3 class="text-center mb-2">{{$page.props.auth.user?.department?.name + " "   }} Department Requsitions Numbers</h3>
          <div class="overflow-x-auto">
              <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead class="bg-gradient-to-r from-blue-300 to-purple-500 text-white">
                  <tr>
                    <th class="text-white uppercase px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider border-b border-gray-200">
                      Today
                    </th>
                    <th class="text-white uppercase px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
                      This Week
                    </th>
                    <th class="text-white uppercase px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
                      This Month
                    </th>
                    <th class="text-white uppercase px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">
                      This Year
                    </th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr justify-content-center>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                      {{ depTimePeriodCounts.dep_today}}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                      {{ depTimePeriodCounts.dep_this_week }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                      {{ depTimePeriodCounts.dep_current_month }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                      {{ depTimePeriodCounts.dep_current_year }}
                    </td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>
      
      
    </div>

   
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import PieChart from '@/Components/Charts/PieChart.vue';

const props = defineProps({
  userData: Object,
  departmentData: Object,
  statusLabels: Object,
  userTimePeriodCounts:Object,
  depTimePeriodCounts:Object
});
</script>

<style>
.reports-container {
  display: flex;
  gap: 20px; 
  padding: 20px;
  max-width: 1200px; 
  margin: 0 auto; 
}


.infor-wrapper {
  flex: 1;
  background-color: #fafafa; /* Slightly darker light gray background */
  padding: 40px;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: 35%;
}


h2 {
  margin-bottom: 16px;
  font-size: 1.25rem;
  color: #333;
  text-align: center;
}


@media (max-width: 768px) {
  .reports-container {
    flex-direction: column; 
  }

  .infor-wrapper {
    width: 100%; 
  }
}
</style>