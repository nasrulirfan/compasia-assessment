
<template>
    <div class="card flex justify-content-center" style="margin: 20px;">
        <Toast />
        <FileUpload mode="basic" name="file" :url="APISettings.baseURL + '/product/upload'" accept=".xlsx" :maxFileSize="2048000" @error="onError" @upload="onUpload" chooseLabel="Browse" />
    </div>
</template>

<script setup>
import Toast from 'primevue/toast';
import FileUpload from 'primevue/fileupload';
import { APISettings } from '@/api/config.js';

import { useToast } from "primevue/usetoast";
const toast = useToast();

const onUpload = () => {
    toast.add({ severity: 'success', summary: 'Success', detail: 'File Uploaded', life: 3000 });
};

const onError = () => {
    toast.add({ severity: 'error', summary: 'Error', detail: 'Error on uploading file!', life: 3000 });
};
</script>
