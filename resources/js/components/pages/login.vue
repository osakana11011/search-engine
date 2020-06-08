<template>
  <app>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              ログイン
            </div>
            <div class="card-body">
              <div class="form-group">
                <label class="control-label">Email</label>
                <input type="text" class="form-control" v-model="email" />
              </div>
              <div class="form-group">
                <label class="control-label">パスワード</label>
                <input type="text" class="form-control" v-model="password" />
              </div>
              <div class="form-group text-right">
                <button class="btn btn-primary" @click="login">ログイン</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app>
</template>

<script>
  export default {
    data: function () {
      return {
        email: '',
        password: '',
      }
    },
    methods: {
      login: function () {
        // TODO: 「ログイン」ボタンを非活性化
        const credentials = {
          email: this.email,
          password: this.password,
        };
        this.$store.dispatch('login', credentials);
      }
    }
  }
</script>

<style scoped>
</style>
