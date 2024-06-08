<template>
  <div class="card">
      <DataTable :value="products" sortMode="multiple" tableStyle="min-width: 50rem">
          <Column field="product_id" header="Product ID" sortable style="width: 25%"></Column>
          <Column field="type" header="Types" sortable style="width: 25%"></Column>
          <Column field="brand" header="Brand" sortable style="width: 25%"></Column>
          <Column field="model" header="Model" sortable style="width: 25%"></Column>
          <Column field="capacity" header="Capacity" sortable style="width: 25%"></Column>
          <Column field="quantity" header="Quantity" sortable style="width: 25%"></Column>
      </DataTable>
  </div>
</template>

<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref, onMounted } from 'vue';

onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8080/api/product');
    const data = await response.json();
    products.value = data;
  } catch (error) {
    console.error('Error fetching product data:', error);
  }
});

const products = ref();
</script>