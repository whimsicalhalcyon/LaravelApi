<script>
import NewMessageComponent from "./NewMessageComponent.vue";
import FilterComponent from "./FilterComponent.vue";

export default {
    components: {
        NewMessageComponent,
        FilterComponent
    },
    props: {
        messages: Array,
        search: String,
        sort: String
    },
    emits: ['update:search', 'update:sort', 'message:delete', 'message-selected']
}
</script>

<template>
    <div>
        <filter-component
            :search="search"
            :sort="sort"
            @update:search="$emit('update:search', $event)"
            @update:sort="$emit('update:sort', $event)"
        />

        <new-message-component
            :messages="messages"
            :search="search"
            :sort="sort"
            @message:delete="$emit('message:delete', $event)"
            @message-selected="$emit('message-selected', $event)"
        />
    </div>
</template>
