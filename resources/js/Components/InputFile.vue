<script setup>

const model = defineModel({
    required: true,
});

const onFileChanged = ($event) => {
    const target = $event.target;
    if (target && target.files) {
        model.value = target.files[0];
    }
};

</script>

<template>
    <input
        type="file" 
        @change="onFileChanged($event)"
        accept="image/*"
        capture
    />
</template>
