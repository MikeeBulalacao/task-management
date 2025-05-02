<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import CreateTask from './Partials/CreateTask.vue'
import DangerButton from '@/Components/DangerButton.vue'
import Modal from '@/Components/Modal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Service from '../../service.js'
import TextInput from '@/Components/TextInput.vue'
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, useAttrs, computed } from 'vue'

const attrs = useAttrs()

const displayCreateModal = ref(false);
const pagination = ref({
    per_page: 10,
    page: 1
})
const status = ref('to-do')
const search = ref('')
const tasks = ref([])

const auth = computed(() => attrs.auth)

const filterList = (data) => {
    status.value = data
    loadTasks()
}

const displayTaskModal = (display) => {
    displayCreateModal.value = display;
}

const destroy = async (id) => {
    await Service.deleteTask(id)
    reloadTasks()
}

const publishTask = async (task) => {
    await Service.publishTask(task.id, { published: !task.published })
    reloadTasks()
}

const reloadTasks = () => {
    loadTasks()
    displayTaskModal(false)
}

const loadTasks = async () => {
    tasks.value = await Service.listTask({
        user_id: auth.value.user.id,
        status: status.value,
        search: search.value,
        per_page: pagination.value.per_page,
        page: pagination.value.page
    })
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="mb-4">
                    <div class="btn-group btn-group-toggle mb-1" data-toggle="buttons">
                      <label class="btn btn-secondary active mr-1" @click="filterList('to-do')">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> To-do
                      </label>
                      <label class="btn btn-secondary mr-1" @click="filterList('in-progress')">
                        <input type="radio" name="options" id="option2" autocomplete="off"> In-progress
                      </label>
                      <label class="btn btn-secondary mr-1" @click="filterList('done')">
                        <input type="radio" name="options" id="option3" autocomplete="off"> Done
                      </label>
                      <label class="btn btn-secondary mr-1" @click="displayTaskModal(true)">
                        <input type="radio" name="options" id="option3" autocomplete="off"> Add a task
                      </label>
                    </div>

                    <div>
                        <TextInput
                            id="title"
                            type="text"
                            placeholder="Search for task title"
                            class="mt-1 block w-full"
                            v-model="search"
                            @keyup.enter="loadTasks"
                        />
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="task in tasks.data" :class="!task.published ? 'table-warning' : ''">
                                <th scope="row">{{ task.title }}</th>
                                <td>{{ task.content }}</td>
                                <td>{{ task.status }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link text-dark p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#" @click="publishTask(task)">
                                                {{ task.published ? 'Unpublish' : 'Publish' }}
                                            </a>
                                            <a class="dropdown-item" href="#" @click="destroy(task.id)">
                                                Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                      </tbody>
                    </table>
                </div>
            </div>

            <div>
                <form class="form-inline justify-center">
                  <select name="limit" id="limit" class="mr-2">
                    <option value="10">10</option>
                    <option value="25" >25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                  <nav>
                      <ul class="pagination mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#">Previous</a>
                        </li>
                        <li class="page-item active">
                          <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">Next</a>
                        </li>
                      </ul>
                    </nav>
                </form>
            </div>
        </div>

        <Modal :show="displayCreateModal" @close="displayTaskModal(false)">
            <CreateTask @hide="displayTaskModal(false)" @submit="reloadTasks" class="p-6"></CreateTask>
        </Modal>
    </AuthenticatedLayout>
</template>
