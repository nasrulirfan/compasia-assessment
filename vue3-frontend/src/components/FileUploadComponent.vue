
<template>
    <div class="card flex justify-content-center">
        <Toast />
        <FileUpload mode="basic" name="file" url="http://localhost:8080/api/product/upload" accept=".xlsx" :maxFileSize="1000000" @upload="onUpload" :auto="true" chooseLabel="Browse" />
    </div>
</template>

<script setup>
import Toast from 'primevue/toast';
import FileUpload from 'primevue/fileupload';

import { useToast } from "primevue/usetoast";
const toast = useToast();

const onUpload = () => {
    toast.add({ severity: 'info', summary: 'Success', detail: 'File Uploaded', life: 3000 });
};
</script>
