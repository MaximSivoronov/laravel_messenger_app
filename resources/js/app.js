import Vue from 'vue'
import chatApp from "./components/chat-app";

require('./bootstrap')

const app = new Vue({
    el: '#app',
    components: {
        chatApp
    }
});
