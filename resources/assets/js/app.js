/**
 * Command Line -> Commands
 * 
 * npm install
 * npm install bulma -S 				[ SCSS StyleSheet ]
 * npm install vuejs-datepicker -S 		[ DatePicker ]
 *
 *
 * npm install vue-color
 * npm install vue-router
 */





/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */




require('./bootstrap');

// load all dependencies
import axios from 'axios';
window.Vue = require('vue');
window.axios = axios;

import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import tinymce from '@tinymce/tinymce-vue';
Vue.component('tinymce', tinymce);

import TaskIndex 	from './components/Task-list.vue';
import TaskEdit 	from './components/Task-edit.vue';
import TaskSingle 	from './components/Task-single.vue';

import VueTextareaAutosize from 'vue-textarea-autosize';
Vue.use(VueTextareaAutosize);

const routes = [
    {
        path: '/',
        components: {
            taskIndex: TaskIndex
        }
    },
    {path: '/edit/:id', component: TaskEdit, name: 'editTask'},
    {path: '/:id', component: TaskSingle, name: 'singleTask'},
]

const router = new VueRouter({ routes })
const app = new Vue({ router }).$mount('#app');
