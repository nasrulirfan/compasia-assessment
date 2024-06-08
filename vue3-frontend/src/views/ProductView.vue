<template>
    <div>
      <FileUploadComponent />
      <ProductListTable />
    </div>
  </template>
  
  <script>
  import FileUploadComponent from '../components/FileUploadComponent.vue';
  import ProductListTable from '../components/ProductListTable.vue';
  
  export default {
    components: {
      ProductListTable,
      FileUploadComponent
    }
  };
  </script>
