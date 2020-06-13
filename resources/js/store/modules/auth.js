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
      router.push('Dashboard');
    } catch (e) {
      // TODO: ログインできなかった旨のエラーメッセージを表示する
      console.log(e);
      commit('updateLoggedIn', false);
    }
  },
  async logout ({commit}) {
    await axios.post('api/auth/logout');
    commit('updateLoggedIn', false);
    router.push('Login');
  },
  async refreshToken ({commit}) {
    try {
      await axios.post('api/auth/refresh');
    } catch (e) {

    }
    axios.post('api/auth/refresh').then(() => {
      commit('updateLoding', false);
      commit('updateLoggedIn', true);
      router.push('Dashboard');
    }).catch((e) => {
      console.log(e);
      commit('updateLoding', false);
      commit('updateLoggedIn', false);
      router.push('Login');
    });
  }
}

const mutations = {
  updateLoggedIn (state, payload) {
    state.loggedIn = payload;
  },
}

export default {
  state,
  getters,
  actions,
  mutations
}
