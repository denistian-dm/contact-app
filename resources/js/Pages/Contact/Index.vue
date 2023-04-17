<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Message from 'primevue/message';
import DataTable from './DataTable.vue';

const props = defineProps({
    contacts: Array
})
</script>

<template>
    <AppLayout title="Contacts">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Contacts
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Message :severity="$page.props.flash.severity" v-if="$page.props.flash.message">
                    {{ $page.props.flash.message }}
                </Message>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <DataTable :data="contacts" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
