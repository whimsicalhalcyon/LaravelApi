<script>
    import InputComponent from "@/components/InputComponent.vue";

    export default {
        components: {InputComponent},
        props : {
            open_slide: {
                type: Boolean,
                default: false
            },
            message: {
                type: Object,
            },

        },
        emits: ['close', 'delete', 'reply-sent']
        ,
        data() {
            return {
                email_reply: this.message?.email_send || '',
                title: '',
                reply: '',
                user_id:1,
                message_id: this.message?.id || '',
            }
        },

        methods: {
            async deleteMessage() {
                if (!this.message?.id) return;

                try {
                    const res = await fetch(`http://restapi.local/api/messages/${this.message.id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    });

                    if (!res.ok) throw new Error('Не удалось удалить сообщение');

                    this.$emit('deleted', this.message.id);
                    this.$emit('close');
                } catch (error) {
                    console.error(error);
                    alert('Ошибка при удалении сообщения');
                }
            },
            async postReply() {
                if (!this.message?.id || !this.reply) return

                const replyData = {
                    title: this.title,
                    message: this.reply,
                    email_reply: this.email_reply,
                    message_id: this.message_id,
                    user_id: this.user_id
                }

                try {
                    const res = await fetch('http://restapi.local/api/replies', {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(replyData)
                    })

                    if (!res.ok) {
                        throw new Error('Ошибка сервера: ' + res.statusText);
                    }

                    const result = await res.json()
                    console.log('Ответ сервера', result)

                    this.$emit('reply-sent', result)
                    this.title = '';
                    this.reply = '';
                } catch (error) {
                    console.log(error)
                }
            }
        }
    }
</script>

<template>
    <div class="slide p-7 border-l border-slate-100 rounded-md">
        <div class="head-slide flex items-center justify-between mb-5">
            <p class="text-lg text-bold">Ответ на сообщение</p>
            <div class="btn-close flex items-end justify-end">
                <button class="close-btn cursor-pointer" @click="$emit('close')">✕</button>
            </div>
        </div>

        <form  @submit.prevent="postReply">
            <div class="head-email">
                <div class="send-email flex w-full flex-col gap-4">
                    <label for="email_send">Кому</label>
                    <input type="text" placeholder="Кому" class="border border-slate-100 rounded-md p-3 w-full" :value="message?.email_send">
                </div>
            </div>
            <div class="user-mail mt-5">
                <label class="" for="message">Текст сообщения</label>
                <div class="user-message bg-slate-100 p-2 rounded-md">
                    {{message?.message}}
                </div>
            </div>
            <div class="body-email mt-12 gap-4">
                <label class="" for="message">Введите текст сообщения</label>
                <input type="text" v-model="title" placeholder="Текст ответа" class="border border-slate-100 rounded-md p-3 w-full">
                <textarea class="w-full border border-slate-100 rounded-md p-3 mt-3" name="message" v-model="reply"></textarea>
            </div>
            <div class="btn flex">
                <button class="p-2 text-white bg-slate-400 rounded-md cursor-pointer" type="submit">Отправить</button>
                <div class="flex-shrink-0 ms-3">
                    <button @click="deleteMessage" type="submit" class="p-3 rounded-lg border border-gray-200 bg-white transition-all duration-200 cursor-pointer  ">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>

        </form>
    </div>
</template>

<style scoped>

</style>
