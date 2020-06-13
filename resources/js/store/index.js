import Vue from 'vue'
import Vuex from 'vuex'

import auth from './modules/auth'
import crawlings from './modules/crawlings'

Vue.use(Vuex)

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  modules: {
    auth,
    crawlings,
  },
  state: {
  },
  actions: {
  },
  mutations: {
  },
})
