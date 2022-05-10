<template>
    <div class="conversation">
        <h1>{{ contact ? contact.name : 'Select A Contact' }}</h1>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @send="sendMessage"/>
    </div>
</template>

<script>
import MessagesFeed from './MessagesFeed';
import MessageComposer from './MessageComposer';

export default {
    name: "Conversation",

    props: {
        contact: {
            type: Object,
            default: null,
        },
        messages: {
            type: Array,
            default: [],
        },
        user_id: {
            type: Number,
            require: true,
        }
    },

    methods: {
        sendMessage(text) {
            if (!this.contact) {
                return;
            }

            axios.post(`/conversation/send`, {
                user_id: this.user_id,
                contact_id: this.contact.id,
                message_text: text,
            }).then((response) => {
                this.$emit('new', response.data);
            });
        }
    },

    components: {
        MessagesFeed,
        MessageComposer,
    }
}
</script>

<style lang="scss" scoped>
.conversation {
    flex: 5;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    h1 {
        font-size: 20px;
        padding: 10px;
        margin: 0;
        border-bottom: 1px dashed lightgray;
    }
}
</style>
