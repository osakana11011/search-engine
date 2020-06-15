<template>
  <app>
    <div class="container">
      <!-- クローリング対象を登録するフォーム -->
      <div class="m-4">
        <div class="panel-body">
          <div class="form-group textbox-wrapper">
            <input type="text" class="form-control textbox-input" :value="crawlingUrl" @input="onInputCrawlingUrl" spellcheck="false" />
            <span class="textbox-label">https://</span>
            <div class="invalid-feedback active">エラーメッセージ</div>
          </div>
          <div class="form-group text-right">
            <button type="button" class="btn btn-primary" @click="submitCrawlingUrl">登録</button>
          </div>
        </div>
      </div>
      <hr>

      <!-- 操作に対するアラートメッセージ -->
      <div class="m-2 alert" :class="[getAlertClass]" role="alert">{{ alertMessage }}</div>

      <!-- ページング -->
      <nav aria-label="ページング">
        <ul class="pagination justify-content-end">
          <li class="page-item" :class="{disabled: !isExistPrev}"><button class="page-link" @click="movePage" :value="prevPage">前へ</button></li>
          <li class="page-item" :class="{active: isCurrentPage(i)}" v-for="i in lastPage"><button class="page-link" @click="movePage" :value="i">{{ i }}</button></li>
          <li class="page-item" :class="{disabled: !isExistNext}"><button class="page-link" @click="movePage" :value="nextPage">次へ</button></li>
        </ul>
      </nav>

      <!-- クローリング対象を表示するテーブル -->
      <div class="table-responsive">
        <table class="table">
          <thead class="thead-light">
            <tr class="d-flex">
              <th class="col-5">URL</th>
              <th class="col-4">ステータス</th>
              <th class="col-3">作成日時</th>
            </tr>
          </thead>
          <tbody>
            <tr class="d-flex" v-for="crawling in crawlings">
              <td class="col-5">{{ crawling.url }}</td>
              <td class="col-4">{{ convertStatus(crawling.status) }}</td>
              <td class="col-3">{{ crawling.created_at }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </app>
</template>

<script>
  import { mapState, mapGetters } from "vuex";

  export default {
    created() {
      const page = (this.$route.query.page !== undefined) ? this.$route.query.page : 1;
      this.$store.dispatch('getCrawlings', page);
    },
    computed: {
      ...mapState({
        isCurrentPage: state => i => (state.crawlings.paging.current === i),
        isExistPrev: state => (state.crawlings.paging.current > 1),
        isExistNext: state => (state.crawlings.paging.current < state.crawlings.paging.last),
        prevPage: state => (state.crawlings.paging.current - 1),
        nextPage: state => state.crawlings.paging.current + 1,
        currentPage: state => state.crawlings.paging.current,
        lastPage: state => state.crawlings.paging.last,
        crawlingUrl: state => state.crawlings.form.crawlingUrl.value,
        crawlings: state => state.crawlings.data,
        isExistError: state => state.crawlings.crawlingForm.isExistError,
        crawlingErrorMessage: state => state.crawlings.crawlingForm.errorMessage,
        alertMessage: state => state.crawlings.alert.message,
      }),
      ...mapGetters([
        'getAlertClass',
      ]),
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
      },
    },
    methods: {
      onInputCrawlingUrl (e) {
        this.$store.dispatch('onInputCrawlingUrl', e.target.value);
      },
      submitCrawlingUrl (e) {
        this.$store.dispatch('submitCrawlingUrl');
      },
      movePage (e) {
        this.$store.dispatch('getCrawlings', e.target.value);
        this.$router.push({path: 'crawlings', query: {page: e.target.value}});
      },
    },
  }
</script>

<style scoped>
  table {
    width: 100%;
    table-layout: fixed;
    word-break: break-all;
    word-wrap: break-all;
  }

  .textbox-wrapper {
    position: relative;
  }

  .textbox-input {
    padding: 0 0 0 60px;
  }

  .textbox-label {
    position: absolute;
    top: 0;
    left: 10px;
    height: calc(1.6em + 0.75rem + 2px);
    line-height: calc(1.6em + 0.75rem + 2px);
    width: 60px;
    font-weight: bold;
  }
</style>
