<template>
  <div class="card">
    <DataTable :value="products" lazy paginator :rows="10" removableSort tableStyle="min-width: 50rem" :first="first"
      @page="onPage($event)" @sort="onSort($event)" :loading="loading" :totalRecords="totalRecords">
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
const currentPage = ref(0);

const loadData = async (event) => {
  loading.value = true;

  if (event) {
    if ((event.page !== undefined && event.page !== null)) {
      currentPage.value = event.page;
    }
    lazyParams.value.rows = event.rows || lazyParams.value.rows;
    lazyParams.value.sortField = event.sortField || lazyParams.value.sortField;
    lazyParams.value.sortOrder = event.sortOrder || lazyParams.value.sortOrder;
  }

  // Determine the sort direction
  const sortDirection = lazyParams.value.sortOrder === -1 ? 'desc' : 'asc';

  // Provide a default value for sortField if it is null
  const sortField = lazyParams.value.sortField || 'product_id';

  try {
    const response = await fetch(`http://localhost:8080/api/product?page=${currentPage.value + 1}&sort_field=${sortField}&sort_order=${sortDirection}`);
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

const onSort = (event) => {
  lazyParams.value = event;
  loadData(event);
};

</script>