<script setup>
import InputError from '@/Components/InputError.vue';
import InputFile from '@/Components/InputFile.vue';
import InputLabel from '@/Components/InputLabel.vue';
import MultiTextInput from '@/Components/MultiTextInput.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Service from '../../../service.js'
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'

const emit = defineEmits(['hide', 'submit'])

const form = useForm({
    title: '',
    content: '',
    published: false,
    status: 'to-do',
    attachment: ''
});

const statuses = ref([
    {
        name: 'To-do',
        value: 'to-do',
    },
    {
        name: 'In-progress',
        value: 'in-progress'
    },
    {
        name: 'Done',
        value: 'done'
    }
])

const cancelDisplay = () => {
    emit('hide');
};

const submit = async () => {
    await Service.createTask({
        title: form.title,
        content: form.content,
        status: form.status,
        published: form.published,
        attachment: form.attachment
    })

    form.reset('title', 'content')
    emit('submit')
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Tasks Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Create a task that will be monited on the dashboard page.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="title" value="Title *" />
                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    maxlength="100"
                    v-model="form.title"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div>
                <InputLabel for="content" value="Content *" />
                <MultiTextInput
                    id="content"
                    maxlength="255"
                    class="mt-1 block w-full"
                    v-model="form.content"
                    required
                />
                <InputError class="mt-2" :message="form.errors.content" />
            </div>

            <div>
                <InputLabel for="attachment" value="Attachment" />
                <InputFile for="attachment" v-model="form.attachment"/>
                <InputError class="mt-2" :message="form.errors.content" />
            </div>

            <div>
                <InputLabel for="status" value="Status *" />
                <div class="form-check" v-for="(status, index) in statuses">
                    <input
                        class="form-check-input"
                        type="radio"
                        id="status"
                        v-model="form.status"
                        :name="`status-${index}`"
                        :value="status.value"
                    >
                    <label class="form-check-label" for="`status-${index}`">
                        {{ status.name }}
                    </label>
                </div>
                <InputError class="mt-2" :message="form.errors.status" />
            </div>

            <div class="flex items-center gap-4 justify-end">
                <SecondaryButton @click="cancelDisplay"> Cancel </SecondaryButton>
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            </div>
        </form>
    </section>
</template>
