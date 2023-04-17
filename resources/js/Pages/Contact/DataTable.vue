<template>
    <DataTable
        :value="data"
        v-model:filters="filters"
        stripedRows
        dataKey="id"
        :globalFilterFields="['name', 'email', 'phone']"
    >
        <template #header>
            <div class="flex flex-col sm:flex-row justify-between gap-2">
                <Button
                    type="button"
                    icon="pi pi-plus"
                    label="Add Contact"
                    @click="createContact()"
                />

                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="filters['global'].value" placeholder="Keyword Search" />
                </span>
            </div>
        </template>
        <template #empty> No contacts found. </template>

        <Column field="name" header="Name"></Column>
        <Column field="email" header="Email"></Column>
        <Column field="phone" header="Phone"></Column>

        <Column>
            <template #body="{ data }">
                <div class="flex gap-2">
                    <Button
                        label="Edit"
                        severity="warning"
                        text
                        @click="handleEdit(data)"
                    />
                    <Button
                        label="Delete"
                        severity="danger"
                        text
                        @click="handleDelete(data.id)"
                    />
                </div>
            </template>
        </Column>
    </DataTable>

    <FormDialog v-model="visible" :form="form" @hide="reset()" />
</template>

<script setup>
import { FilterMatchMode } from "primevue/api";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";

import FormDialog from "./FormDialog.vue";
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";

defineProps({
    data: Array,
});

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});

const visible = ref(false);
const form = useForm({
    _method: "POST",
    name: "",
    email: "",
    phone: "",
});

const createContact = () => {
    visible.value = true;
};

const handleEdit = (value) => {
    visible.value = true;

    form._method = "PUT";
    form.name = value.name;
    form.email = value.email;
    form.phone = value.phone;
    form.id = value.id;
};

const reset = () => {
    form._method = "POST";
    form.name = "";
    form.email = "";
    form.phone = "";
    form.id = "";
    form.errors = {};
};

const handleDelete = (id) => {
    router.visit(route("contact.destroy", id), {
        method: "delete",
        preserveScroll: true,
    });
};
</script>
