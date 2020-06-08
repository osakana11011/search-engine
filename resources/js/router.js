import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import login from './components/pages/login.vue';
import dashboard from './components/pages/Dashboard.vue';
import crawlings from './components/pages/Crawlings.vue';

export default new VueRouter({
  // モードの設定
  mode: 'history',
  routes: [
      { path: '/', redirect: '/login' },
      {
          path: '/login',
          name: 'Login',
          component: login,
      },
      {
        path: '/dashboard',
        name: 'Dashboard',
        component: dashboard,
      },
      {
        path: '/crawlings',
        name: 'Crawlings',
        component: crawlings,
    },
  ],
});
