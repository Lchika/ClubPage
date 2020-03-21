<template>
  <div class="news_list py-3">
    <div class="news_item mb-1">
      <div v-for="item in date_split_list[0]" :key="item.id">
        <b-row align-h="center">
          <b-col cols="12" sm="10" md="8" lg="5" class="news_body"><b-icon-circle-half class="mr-2"></b-icon-circle-half> {{item.date}}　<span v-html="item.body"></span></b-col>
        </b-row>
      </div>
      <div v-for="item in date_split_list[1]" :key="item.id">
        <b-row align-h="center">
          <b-col cols="12" sm="10" md="8" lg="5" class="news_body"><b-icon-circle-fill class="mr-2"></b-icon-circle-fill>{{item.date}}　<span v-html="item.body"></span></b-col>
        </b-row>
      </div>
    </div>
    <div v-if="isDisplayLinkToIndex">
      <b-row align-h="center">
        <b-col cols="12" sm="10" md="8" lg="5" class="news_link">
          <RouterLink
            :to="`/news`"
            :title="`活動履歴・予定一覧`"
          >
          活動履歴・予定一覧はこちら
          </RouterLink>
        </b-col>
      </b-row>
    </div>
  </div>
</template>

<script>
import {splitFutureAndPast} from '../utils/date.js'

export default {
  props: {
    items: {
      type: Array,
      required: true
    },
    isDisplayLinkToIndex: {
      type: Boolean,
      default: true,
    }
  },
  data () {
    return {
      date_split_list: [[],[]]
    }
  },
  methods: {
    get_date_split_list () {
      this.date_split_list = splitFutureAndPast(this.items)
    }
  },
  watch: {
    'items': {
      handler () {
        this.get_date_split_list()
      }
    }
  }
}
</script>

<style scoped>
.news_body {
  border-bottom: solid 1px #ccc;
}
.news_link {
  text-align: right;
}
</style>