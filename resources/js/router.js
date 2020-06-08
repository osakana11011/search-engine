import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import login from './components/pages/login.vue';
import crawlings from './components/pages/Crawlings.vue';

export default new VueRouter({
  // モードの設定
  mode: 'history',
  routes: [
      {
          path: '/',
          name: login,
          component: login,
      },
      {
        path: '/crawlings',
        name: crawlings,
        component: crawlings,
    },
  ]
});
