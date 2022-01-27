require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

import App from './components/App'
import Home from './components/Home'
import Booking from './components/Booking'
import History from "./components/History";

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/booking',
            name: 'Booking',
            component: Booking
        },
        {
            path: '/history',
            name: 'History',
            component: History
        },
    ]
})
const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
})
