<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import CreateTask from './Partials/CreateTask.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, useAttrs, computed } from 'vue';

const attrs = useAttrs()

const confirmingUserDeletion = ref(false);

const auth = computed(() => attrs.auth)

const displayTaskModal = (display) => {
    confirmingUserDeletion.value = display;
};

const loadTasks = async () => {
    const filters = {
        user_id: auth.value.user.id
    }

    const response = await axios.get('/api/task', { params: filters })

    console.log(response)
};

onMounted(() => {
    loadTasks()
})

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Task management system</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <button type="button" class="btn btn-secondary btn-md btn-block" @click="displayTaskModal(true)">
                        Add a task
                    </button>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Title</th>
                          <th scope="col">Content</th>
                          <th scope="col">Status</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">Fist task</th>
                          <td>This is a first task</td>
                          <td>Todo</td>
                          <td></td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Jacob</td>
                          <td>Thornton</td>
                          <td>@fat</td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>Larry</td>
                          <td>the Bird</td>
                          <td>@twitter</td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div>
        </div>

        <Modal :show="confirmingUserDeletion" @close="displayTaskModal(false)">
            <CreateTask @hide="displayTaskModal(false)" class="p-6"></CreateTask>
        </Modal>
    </AuthenticatedLayout>
</template>
