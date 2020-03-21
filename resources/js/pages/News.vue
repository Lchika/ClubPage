<template>
  <div class="news_index">
    <h2>活動履歴・予定</h2>
    <News :items="news" :isDisplayLinkToIndex="false" />
  </div>
</template>

<script>
import { OK } from '../util'
import News from '../components/News.vue'
import { metatag } from '../utils/metatag.js'

export default {
  components: {
    News
  },
  data () {
    return {
      news: []
    }
  },
  methods: {
    async fetchNews () {
      const response_news = await axios.get(`/api/news`,
      {
        params: {
          quantity: 0
        }
      })

      if (response_news.status !== OK) {
        this.$store.commit('error/setCode', response_news.status)
        return false
      }

      this.news = response_news.data.data
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchNews()
      },
      immediate: true
    }
  },
  metaInfo () {
    return metatag("NEWS", "電子工作サークル メカトロ同好会エルチカの活動履歴および活動予定を掲載しています。",
      location.protocol + '//' + location.host + "/storage/upload/images/favicon.png",
      location.protocol + '//' + location.host + "/storage/upload/images/favicon.png");
  }
}
</script>

<style scoped>
h2 {
     text-align: center;
     position: relative;
     padding: 30px 0 16px;
}

h2::after{
     position: absolute;
     content: "";
     left: 0;
     right: 0;
     bottom: 0;
     width: 60px;
     margin: auto;
     border-bottom: 2px solid #000;
}
</style>