import Vue from 'vue'
import VueRouter from 'vue-router'

import store from './store'
import login from './components/pages/login.vue';
import dashboard from './components/pages/Dashboard.vue';
import crawlings from './components/pages/Crawlings.vue';

Vue.use(VueRouter);

const router = new VueRouter({
  // モードの設定
  mode: 'history',
  routes: [
      {
          path: '/',
          name: 'Root',
      },
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

router.beforeEach((to, from, next) => {
  if (isLoggedIn()) {
    // ログイン状態の時の処理
    // 「ルート」「ログイン」 => 「ダッシュボード」
    if ((to.name === 'Root') || (to.name === 'Login')) {
      next({name: 'Dashboard'});
    } else {
      next();
    }
  } else {
    store.dispatch('refreshToken');
    // ログイン状態で無い時の処理
    // 「ログイン」以外 => 「ログイン」
    if (store.state.loging === false && to.name !== 'Login') {
      next({name: 'Login'});
    }
  }

  next();
});

function isLoggedIn () {
  return store.state.auth.loggedIn;
}

export default router;
