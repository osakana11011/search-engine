import axios from 'axios';
import router from './../../router'

const state = {
};

const getters = {
};

const actions = {
  async login ({commit}, credentials) {
    try {
      // ログイン処理
      const response = await axios.post('api/auth/login', credentials);
      // TODO: ローカルストレージは危険らしいので、別場所にトークンを保存させる
      localStorage.token = response.data.access_token;
      // TODO: ログイン後の遷移先をダッシュボードへ
      router.push({path: '/crawlings'});
    } catch (e) {
      // TODO: ログインできなかった旨のエラーメッセージを表示する
      console.log(e);
    }
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
