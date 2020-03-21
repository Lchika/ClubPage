<template>
  <div class="index">
    <div class="top_image">
      <b-img rounded src="/storage/images/IoTIMGL3537_TP_V.jpg" fluid alt="Responsive image"></b-img>
      <div class="top_content">
        <h1 class="mb-4">メカトロ同好会LCHIKA</h1>
        <RouterLink 
          :to="`/about`"
          :title="`本団体について`"
        >
          本団体について...
        </RouterLink>
      </div>
    </div>
    <h2>活動履歴・予定</h2>
    <News :items="news" />
    <h2>作品紹介</h2>
    <Post :items="works" />
    <div class="works_link">
      <RouterLink 
        :to="`/works`"
        :title="`作品紹介一覧`"
      >
        作品を全部見たい人はこちら
      </RouterLink>
    </div>
    <h2>コラム</h2>
    <Post :items="columns" />
    <div class="works_link">
      <RouterLink 
        :to="`/columns`"
        :title="`コラム一覧`"
      >
        コラム一覧はこちら
      </RouterLink>
    </div>
    <h2>タグ一覧</h2>
    <div class="index_taglist p-4">
      <span v-for="tag in tags" :key="tag.text" class="mx-1">
        <RouterLink :to="`/tag/${tag.text}`">
          <b-button variant="tag"><b-icon-tag></b-icon-tag>{{ tag.text }}</b-button>
        </RouterLink>
      </span>
    </div>
  </div>
</template>

<script>
import { OK } from '../util'
import News from '../components/News.vue'
import Post from '../components/Post.vue'
import { metatag } from '../utils/metatag.js'

export default {
  components: {
    Post,
    News
  },
  data () {
    return {
      works: [],
      columns: [],
      news: [],
      tags: []
    }
  },
  methods: {
    async fetchPosts () {
      const response_news = await axios.get(`/api/news`,
      {
        params: {
          quantity: 5
        }
      })

      if (response_news.status !== OK) {
        this.$store.commit('error/setCode', response_news.status)
        return false
      }

      this.news = response_news.data.data

      const response_works = await axios.get(`/api/posts`,
      {
        params: {
          category: 1
        }
      })

      if (response_works.status !== OK) {
        this.$store.commit('error/setCode', response_works.status)
        return false
      }

      this.works = response_works.data.data
      
      const response_columns = await axios.get(`/api/posts`,
      {
        params: {
          category: 2
        }
      })

      if (response_columns.status !== OK) {
        this.$store.commit('error/setCode', response_columns.status)
        return false
      }

      this.columns = response_columns.data.data
      
      const response = await axios.get(`/api/tags`)
      
      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.tags = response.data.data
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchPosts()
      },
      immediate: true
    }
  },
  metaInfo () {
    return metatag("TOP", "電子工作サークル メカトロ同好会エルチカのホームページです。",
      location.protocol + '//' + location.host + "/storage/upload/images/favicon.png",
      location.protocol + '//' + location.host + "/storage/upload/images/favicon.png");
  }
}
</script>

<style scoped>
.top_image {
  position: relative;
}

.top_image .top_content {
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%,-50%);
  -webkit-transform: translate(-50%,-50%);
  transform: translate(-50%,-50%);
  margin:0;
  padding:0;
  color: #FFFFFF;
  text-align: center;
}

.top_content h1 {
  font-weight: bold;
  font-size: calc(24px + ((1vw - 0.2rem) * 2.3));
}
@media (min-width: 1200px) {/* 1200px以上*/
  .top_content h1 {
    font-size: 50px;/* 36px*/
  }
}
@media screen and (max-width: 640px) {/* 640px以下*/
  .top_content h1 {
    font-size: 20px;
  }
}

.top_content >>> a{
  color: #FFFFFF;
}

.top_image img {
  width: 100%;
}

h2 {
  font-weight: bold;
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

.works_link {
  text-align: right;
}

.index_taglist {
  line-height: 3rem;
}
</style>