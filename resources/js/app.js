import bootstrap from 'bootstrap'
import Vue from 'vue'
import router from './router'
import store from './store'

Vue.component('app', require('./components/globals/App.vue').default);
Vue.component('dashboard', require('./components/pages/Dashboard.vue').default);
Vue.component('crawlings', require('./components/pages/Crawlings.vue').default);

function authenticate () {
    const accessToken = localStorage.getItem('token');
    return (accessToken !== null);
}

router.beforeEach((to, from, next) => {
    if ((to.name === 'Login') && authenticate()) {
        next({name: 'Dashboard'});
    } else if ((to.name !== 'Login') && !authenticate()) {
        next({name: 'Login'});
    } else {
        next();
    }
});

const app = new Vue({
    el: '#app',
    router,
    store,
});

// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */

// require('./bootstrap');

// window.Vue = require('vue');

// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */

// // const files = require.context('./', true, /\.vue$/i)
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('sub-component', require('./components/SubComponent.vue').default);

// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */

// const app = new Vue({
//     el: '#app',
// });
