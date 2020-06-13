import axios from 'axios';
import router from './../../router'

const state = {
    loggedIn: false,
}

const getters = {
}

const actions = {
  async login ({commit}, credentials) {
    try {
      // ログイン処理
      await axios.post('api/auth/login', credentials);
      commit('updateLoggedIn', true);
      router.push({path: '/dashboard'});
    } catch (e) {
      // TODO: ログインできなかった旨のエラーメッセージを表示する
      console.log(e);
      commit('updateLoggedIn', false);
    }
  },
  async logout ({commit}) {
    commit('updateLoggedIn', false);
    router.push({path: '/'});
  },
  refreshToken ({commit}) {
    axios.post('api/auth/refresh').then(() => {
      commit('updateLoggedIn', true);
      router.push('Dashboard');
    }).catch((e) => {
      console.log(e);
      commit('updateLoggedIn', false);
    });
  }
}

const mutations = {
  async updateLoggedIn (state, payload) {
    state.loggedIn = payload;
  },
}

export default {
  state,
  getters,
  actions,
  mutations
}
