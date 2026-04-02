<script>
export default {
     props: {
         search: {
             type: String,
             default: ''
         },
         sort: {
             type: String,
             default: ''
         }
     },
     emits: ['update:search', 'update:sort']
 }
</script>

<template>
    <div class="navbar mt-5 mb-3 w-full">
        <input type="text" placeholder="Поиск" name="search" :value="search" @input="$emit('update:search', $event.target.value)" class="w-2xs border border-slate-100 p-2 rounded-md w-1/2"/>
        <select id="search" :value="sort" @change="$emit('update:sort', $event.target.value)" class="px-3 py-2.5 ms-3 bg-neutral-secondary-medium border border-slate-100 text-heading text-sm rounded-md focus:ring-brand focus:border-brand placeholder:text-body">
            <option value="">Cортировать по</option>
            <option value="created_at">Дате</option>
            <option value="title">Названию</option>
        </select>
    </div>
</template>

<style scoped>

</style>
