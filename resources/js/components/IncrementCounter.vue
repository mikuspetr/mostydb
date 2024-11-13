<template>
    <div>
    <button
        type="button"
        @click="counter++"
        class="p-2 text-white bg-gray-500 rounded"
    >
        Counter is: {{ counter }}
    </button>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const counter = ref(0)
</script>
