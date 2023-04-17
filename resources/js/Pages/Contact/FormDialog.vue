<template>
    <Dialog
        v-model:visible="visible"
        :modal="true"
        :style="{ width: '50vw' }"
        :breakpoints="{ '960px': '75vw', '641px': '100vw' }"
        :draggable="false"
        header="Add Contact"
        position="top"
        @hide="onHide"
    >
        <div class="mb-6 flex flex-col gap-2">
            <label for="name">Name</label>
            <InputText id="name" v-model="form.name" aria-describedby="name-help" />
            <InputError :message="form.errors.name" />
        </div>

        <div class="mb-6 flex flex-col gap-2">
            <label for="email">Email</label>
            <InputText id="email" v-model="form.email" aria-describedby="email-help" />
            <InputError :message="form.errors.email" />
        </div>

        <div class="flex flex-col gap-2">
            <label for="phone">Phone Number</label>
            <InputText id="phone" v-model="form.phone" aria-describedby="phone-help" />
            <InputError :message="form.errors.phone" />
        </div>

        <template #footer>
            <Button label="Cancel" @click="visible = false" text />
            <Button label="Save" @click="submit" autofocus />
        </template>
    </Dialog>
</template>

<script setup>
import { computed } from "@vue/reactivity";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    modelValue: Boolean,
    form: Object
});

const emits = defineEmits(["update:modelValue", "hide"]);

const visible = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emits("update:modelValue", false);
    },
});

const submit = () => {
    const url = props.form.id ? route('contact.update', props.form.id) : route('contact.store')
    props.form.post(url, {
        preserveScroll: true,
        onSuccess: () => {
            visible.value = false
        }
    })
}

const onHide = (e) => {
    emits("hide", e)
}
</script>
