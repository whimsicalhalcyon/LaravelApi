<script>
    export default {
        props : {
            title: {
                type: String,
                required: true
            },
            url: {
                type: String
            }
        }
    }
</script>

<template>
    <a :href="url">{{title}}</a>
</template>

<style scoped>

</style>
