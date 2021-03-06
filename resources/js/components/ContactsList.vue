<template>
    <div class="contacts-list">
        <ul>
            <li v-for="contact in sortedContacts"
                @click="selectContact(contact)"
                :class="{ 'selected': contact === selected}"
                :key="contact.id"
            >
                <div class="avatar">
                    <img :src="contact.profile_image" :alt="contact.name">
                </div>
                <div class="contact">
                    <p class="name">{{ contact.name }}</p>
                    <p class="email">{{ contact.email }}</p>
                </div>
                <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "ContactsList",

    data() {
        return {
            selected: this.contacts.length ? this.contacts[0] : null,
        }
    },

    props: {
        contacts: {
            type: Array,
            default: [],
        },
    },

    methods: {
        selectContact(contact) {
            this.selected = contact;
            this.$emit('selected', contact);
        }
    },

    computed: {
        // Sorting contacts by count of unread messages.
        sortedContacts() {
            return _.sortBy(this.contacts, [(contact) => {
                // If this contact selected, he will be on the top.
                if (contact === this.selected) {
                    return Infinity;
                }
                return contact.unread;
            }]).reverse();
        }
    }
}
</script>

<style lang="scss" scoped>
    .contacts-list {
        flex: 2;
        max-height: 600px;
        overflow: scroll;
        border-left: 1px solid #a6a6a6;
        min-width: 290px;

        ul {
            list-style-type: none;
            padding-left: 0;

            li {
                display: flex;
                padding: 2px;
                border-bottom: 1px solid #aaaaaa;
                height: 80px;
                position: relative;
                cursor: pointer;

                &.selected {
                    background: #dfdfdf;
                }

                span.unread {
                    position: absolute;
                    right: 33px;
                    top: 34px;
                    display: flex;
                    font-weight: 800;
                    min-width: 20px;
                    justify-content: center;
                    align-items: center;
                    line-height: 20px;
                    font-size: 12px;
                    padding: 0 4px;
                    border-radius: 50%;
                    background-color: #40a6e2;
                    color: #f7f9fb;
                }

                .avatar {
                    flex: 1;
                    display: flex;
                    align-items: center;

                    img {
                        width: 35px;
                        border-radius: 50%;
                        margin: 0 auto;
                    }
                }

                .contact {
                    flex: 3;
                    font-size: 10px;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;

                    p {
                        margin: 0;

                        &.name {
                            font-weight: bold;
                        }
                    }
                }
            }
        }
    }
</style>
