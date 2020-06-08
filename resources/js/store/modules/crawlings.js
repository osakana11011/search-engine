import axios from 'axios';

const state = {
  form: {
    crawlingUrl: {
      value: '',
      errorMessage: '',
    },
  },
  displayData: {
    paging: {
      current: 1,
      last: 1,
    },
    crawlings: [],
  },
}

const getters = {
}

const actions = {
  async refreshCrawlings({ commit }) {
    try {
      const response = await axios.get('/api/crawlings');
      commit('updateCurrentPage', response.data[0].current_page);
      commit('updateLastPage', response.data[0].last_page);
      commit('updateCrawlings', response.data[0].data);
    } catch (e) {
      // TODO: クローリングデータの取得に失敗した時の処理
      console.log(e);
    }
  },
  onInputCrawlingUrl({ commit }, payload) {
    commit('updateCrawlingUrl', payload);
  },
  async submitCrawlingUrl({ commit, state, dispatch }) {
    try {
      const crawlingUrl = state.form.crawlingUrl.value;
      await axios.post('api/crawlings', {
        url: crawlingUrl,
      });
      commit('updateCrawlingUrl', '');
      dispatch('refreshCrawlings');
    } catch (e) {
      // TODO: クローリングデータの登録に失敗した時の処理
      console.log(e);
    }
  },
}

const mutations = {
  updateCurrentPage (state, currentPage) {
    state.displayData.paging.current = currentPage;
  },
  updateLastPage (state, lastPage) {
    state.displayData.paging.last = lastPage;
  },
  updateCrawlings (state, crawlings) {
    state.displayData.crawlings = crawlings;
  },
  updateCrawlingUrl (state, crawlingUrl) {
    state.form.crawlingUrl.value = crawlingUrl;
  },
}

export default {
  state,
  getters,
  actions,
  mutations
}
