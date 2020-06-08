import Vue from 'vue'
import Vuex from 'vuex'

import login from './modules/login'
import crawlings from './modules/crawlings'

Vue.use(Vuex)

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  modules: {
    login,
    crawlings,
  },
  state: {

  },
  mutations: {

  },
  actions: {

  }
})
