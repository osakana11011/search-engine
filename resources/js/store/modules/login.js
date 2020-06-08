import axios from 'axios';

const state = {
};

const getters = {
};

const actions = {
  async login ({commit}, credentials) {
    // ログイン処理
    const response = await axios.post('api/auth/login', credentials);
    // TODO: ローカルストレージは危険らしいので、別場所にトークンを保存させる
    localStorage.token = response.data.access_token;
  },
};

const mutations = {

};

export default {
  state,
  getters,
  actions,
  mutations
};
