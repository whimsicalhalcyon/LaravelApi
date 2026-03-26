<script>
import {St} from "vite/dist/node/chunks/node.js";

export default {
    props: {
        type: {
            type: String
        },

        name: {
            type: String,
        },

        placeholder: {
            type: String,
            required: false
        },

        id: {
            type: String,
            required: false
        }
    }
}
</script>

<template>
    <input :type="type" :name="name" :placeholder="placeholder" class="border border-slate-100 p-2 rounded-md w-1/2">
</template>

<style scoped>

</style>
