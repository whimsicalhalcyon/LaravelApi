<!-- ModalWindowComponent.vue -->
<script>
export default {
    name: 'ModalWindow',

    props: {
        modelValue: {
            type: Boolean,  // ← меняем с String на Boolean
            default: false
        },
        title: {
            type: String,
            default: 'Модальное окно'
        },
        width: {
            type: String,
            default: 'max-w-md'
        }
    },

    emits: ['update:modelValue', 'close'],

    computed: {
        show: {
            get() {
                return this.modelValue
            },
            set(value) {
                this.$emit('update:modelValue', value)
                if (!value) {
                    this.$emit('close')
                }
            }
        }
    },

    methods: {
        closeModal() {
            this.show = false
        },

        handleOverlayClick(e) {
            if (e.target === e.currentTarget) {
                this.closeModal()
            }
        }
    },

    watch: {
        modelValue(val) {
            if (val) {
                document.body.style.overflow = 'hidden'
            } else {
                document.body.style.overflow = ''
            }
        }
    },

    beforeDestroy() {
        document.body.style.overflow = ''
    }
}
</script>

<template>
    <transition name="modal">
        <div v-if="modelValue" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click="handleOverlayClick">
            <div class="bg-white rounded-md w-full mx-4 overflow-hidden" :class="width" @click.stop>
                <div class="flex items-center justify-between px-5 py-3 border-b border-slate-200">
                    <h3 class="text-base font-medium text-slate-800">
                        {{title}}
                    </h3>
                    <button @click="closeModal" class="text-slate-400 hover:text-slate-600 p-1 rounded transition-colors" aria-label="Закрыть">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="px-5 py-4">
                    <slot>
                        <div class="text-center py-8">
                            <p class="text-slate-600">Контент модального окна</p>
                        </div>
                    </slot>
                </div>

                <div v-if="$slots.footer" class="px-5 py-3 bg-slate-50 border-t border-slate-200 flex justify-end gap-2 rounded-b-lg">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>

</style>
