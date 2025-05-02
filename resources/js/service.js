async function deleteTask (id) {
  return await axios.delete(`/api/task/${id}`)
}

async function publishTask(id, config) {
  return await axios.patch(`/api/task/${id}`, config)
}

async function listTask(filters) {
  const { data } = await axios.get('/api/task', { params: filters })
  
  return data
}

async function createTask(filters) {
  await axios.post(
    '/api/task',
    filters,
    {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    }
  )
}

export default {
  deleteTask,
  publishTask,
  listTask,
  createTask
}
