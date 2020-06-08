<template>
  <app>
    <div class="container">
      <!-- クローリング対象を登録するフォーム -->
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="form-group">
            <label class="control-label">クローリングURL</label>
            <input type="text" class="form-control" :value="crawlingUrl" @input="onInputCrawlingUrl" />
            <div class="invalid-feedback">エラーメッセージ</div>
          </div>
          <div class="form-group text-right">
            <button type="button" class="btn btn-primary" @click="submitCrawlingUrl">登録</button>
          </div>
        </div>
      </div>

      <!-- クローリング対象を表示するテーブル -->
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>URL</th>
            <th>ステータス</th>
            <th>作成日時</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="crawling in crawlings">
            <td>{{ crawling.id }}</td>
            <td>{{ crawling.url }}</td>
            <td>{{ convertStatus(crawling.status) }}</td>
            <td>{{ crawling.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </app>
</template>

<script>
  import { mapState } from "vuex";

  export default {
    created() {
      this.$store.dispatch('refreshCrawlings');
    },
    computed: {
      ...mapState({
        crawlingUrl: state => state.crawlings.form.crawlingUrl.value,
        crawlings: state => state.crawlings.displayData.crawlings,
        isExistError: state => state.crawlings.crawlingForm.isExistError,
        crawlingErrorMessage: state => state.crawlings.crawlingForm.errorMessage,
      }),
      convertStatus: () => (status) => {
        switch (status) {
          case 0:
            return 'クローリング前';
          case 1:
            return 'クローリング中';
          case 2:
            return 'クローリング後';
          case 3:
            return 'キャンセル';
          default:
            return '未定義';
        }
      }
    },
    methods: {
      onInputCrawlingUrl (e) {
        this.$store.dispatch('onInputCrawlingUrl', e.target.value);
      },
      submitCrawlingUrl (e) {
        this.$store.dispatch('submitCrawlingUrl');
      },
    },
  }
</script>

<style scoped>
</style>
