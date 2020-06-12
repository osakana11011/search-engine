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
  alert: {
    isShow: true,
    type: '',
    message: '',
  },
}

const getters = {
  getAlertClass(state) {
    switch (state.alert.type) {
      case 'success':
        return {'alert-success': true};
      case 'failed':
        return {'alert-danger': true};
      default:
        return {'d-none': true};
    }
  },
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
      commit('setAlert', {type: 'success', message: 'クローリング情報の登録に成功しました。'});
      dispatch('getCrawlings', 1);
    } catch (e) {
      // TODO: クローリングデータの登録に失敗した時の処理
      console.log(e);
      commit('setAlert', {type: 'failed', message: 'クローリング情報の登録に失敗しました。'});
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
  setAlert (state, payload) {
    state.alert.isShow = true;
    state.alert.type = payload.type;
    state.alert.message = payload.message;
  },
}

export default {
  state,
  getters,
  actions,
  mutations
}
