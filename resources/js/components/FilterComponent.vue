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
        },
        category: {
            type: [String, Number],
            default: ''
        }
    },
    emits: ['update:search', 'update:sort', 'update:category'] // 👈 новый emit
}
</script>

<template>
    <div class="navbar mt-5 mb-3 w-full flex gap-3">
        <!-- Поиск -->
        <input
            type="text"
            placeholder="Поиск"
            name="search"
            :value="search"
            @input="$emit('update:search', $event.target.value)"
            class="border border-slate-100 p-2 rounded-md w-1/2"
        />

        <!-- Сортировка -->
        <select :value="sort" @change="$emit('update:sort', $event.target.value)" class="px-3 py-2.5 bg-neutral-secondary-medium border border-slate-100 text-sm rounded-md">
            <option value="">Сортировать по</option>
            <option value="created_at">Дате</option>
            <option value="title">Названию</option>
        </select>

<!--        фильтр-->
        <select :value="category" @change="$emit('update:category', $event.target.value)" class="px-3 py-2.5 bg-neutral-secondary-medium border border-slate-100 text-sm rounded-md">
            <option value="">Все категории</option>
            <option value="1">Ошибка</option>
            <option value="2">Обращение</option>
            <option value="3">Вопрос</option>
        </select>
    </div>
</template>

<style scoped>
</style>
