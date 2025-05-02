<script setup>
import { ref, computed } from 'vue'

const emit = defineEmits(['update:page'])

const selectedPerPage = ref(5)
const selectedPage = ref(1)

const perPage = ref([
	5, 10, 20, 30
])

const props = defineProps({
	total: {
		type: Number,
		default: 1
	},
	currentPage: {
		type: Number,
		default: 1
	},
	lastPage: {
		type: Number,
		default: 1
	}
})

const pages = computed(() => {
	const result = []

	for (let i = 1; i <= props.lastPage; i++) {
		result.push(i)
	}

	return result
})

const emitChanges = () => {
	emit('update:page', {
		page: selectedPage.value,
		per_page: selectedPerPage.value
	})
}

const updatePage = (data) => {
	selectedPage.value = data
	emitChanges()
}

const updatePerPage = (event) => {
	selectedPerPage.value = event.target.value
	selectedPage.value = 1
	emitChanges()
}

</script>

<template>
	<div class="form-inline justify-center">
		<select name="limit" id="limit" class="mr-2" @change="updatePerPage($event)" v-model="selectedPerPage">
			<option v-for="item in perPage" :value="item">{{ item }}</option>
		</select>
		<nav aria-label="pagination" class="pagination">
			<ul class="pagination mb-0">
				<li class="page-item" :class="currentPage === page ? 'active' : ''" @click="updatePage(page)" v-for="page in pages">
	             	<a class="page-link" href="#">{{ page }}</a>
	            </li>
			</ul>
		</nav>
	</div>
</template>
