import axios from 'axios';

const state = {
  paging: {
    current: 1,
    last: 1,
  },
  data: [],
  form: {
    crawlingUrl: {
      value: '',
      errorMessage: '',
    },
  },
}

const getters = {
}

const actions = {
  async getCrawlings({commit}, page) {
    try {
      const response = await axios.get('/api/crawlings', {
        params: {
          page,
        },
      });
      commit('updatePage', {
        current: response.data[0].current_page,
        last: response.data[0].last_page,
      });
      commit('updateCrawlings', response.data[0].data);
    } catch (e) {
      // TODO: クローリングデータの取得に失敗した時の処理
      console.log(e);
    }
  },
  onInputCrawlingUrl({commit}, payload) {
    commit('updateCrawlingUrl', payload);
  },
  async submitCrawlingUrl({ commit, state, dispatch }) {
    try {
      const crawlingUrl = state.form.crawlingUrl.value;
      await axios.post('api/crawlings', {
        url: crawlingUrl,
      });
      commit('updateCrawlingUrl', '');
    } catch (e) {
      // TODO: クローリングデータの登録に失敗した時の処理
      console.log(e);
    }
  },
}

const mutations = {
  updatePage (state, page) {
    state.paging = page;
  },
  updateCrawlings (state, crawlings) {
    state.data = crawlings;
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
