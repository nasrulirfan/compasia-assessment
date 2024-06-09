<template>
  <div class="card">
    <DataTable :value="products" lazy paginator :rows="10" sortMode="multiple" tableStyle="min-width: 50rem"
      :first="first" @page="onPage($event)" :loading="loading" :totalRecords="totalRecords">
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
  loading.value = true;

  lazyParams.value = {
    first: 0,
    rows: 10,
    sortField: null,
    sortOrder: null,
  };

  loadData();
});

const loading = ref(false);
const totalRecords = ref(0);
const products = ref();
const first = ref(0);
const lazyParams = ref({});

const loadData = async (event) => {
  loading.value = true;
  lazyParams.value = { ...lazyParams.value, first: event?.first || first.value };

  try {
    const response = await fetch(`http://localhost:8080/api/product?page=${lazyParams.value.page + 1}`);
    const data = await response.json();
    products.value = data.data;
    totalRecords.value = data.total;
  } catch (error) {
    console.error('Error fetching product data:', error);
  }

  loading.value = false;
};

const onPage = (event) => {
  lazyParams.value = event;
  loadData(event);
};
</script>