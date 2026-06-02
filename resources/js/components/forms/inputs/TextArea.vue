
<template>
    <div>

        <editor
        :id="props.id"
        api-key="2kt6chg3ryst2ladx50270zwagol01mxc2wqn03pdl08boj6"
        :init="{
            menubar: false,
            plugins: 'lists',
            toolbar: 'undo redo | styles | bold italic underline | bullist numlist',
            height: 500,
        }"
        :v-model="props.modelValue"
        />

    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    modelValue: {
        type: String,
        default: '',
    },
})

const form = ref({
    text: props.modelValue,
})
</script>
