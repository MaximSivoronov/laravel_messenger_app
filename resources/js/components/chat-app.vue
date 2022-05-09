<template>
    <div class="chat-app">
        <Conversation :contact="selectedContact" :messages="messages" :user_id="user.id" @new="saveNewMessage"/>
        <ContactsList :contacts="contacts" @selected="startConversationWith"/>
    </div>
</template>

<script>
import Conversation from "./Conversation";
import ContactsList from "./ContactsList";
export default {
    name: "chat-app",

    props: {
        user: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            selectedContact: null,
            messages: [],
            contacts: [],
        }
    },

    mounted() {
        axios.get('/api/contacts')
            .then((response) => {
                this.contacts = response.data;
            });
    },

    methods: {
        startConversationWith(contact) {
            axios.get(`/api/conversation/${contact.id}`)
                .then((response) => {
                    this.messages = response.data;
                    this.selectedContact = contact;
                });
        },
        saveNewMessage(message) {
            this.messages.push(message);
        },
    },

    components: {
        Conversation,
        ContactsList,
    },
}
</script>

<style lang="scss" scoped>
    .chat-app {
        display: flex;
    }
</style>
