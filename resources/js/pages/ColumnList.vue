<template>
  <div class="post-list">
    <h1 class="m-2">コラム一覧</h1>
    <Post :items="posts" />
    <Pagination :current-page="currentPage" :last-page="lastPage" :path="`columns/`" />
  </div>
</template>

<script>
import { OK } from '../util'
import Post from '../components/Post.vue'
import Pagination from '../components/Pagenation.vue'
import { metatag } from '../utils/metatag.js'

export default {
  components: {
    Post,
    Pagination,
  },
  data () {
    return {
      posts: [],
      currentPage: 0,
      lastPage: 0,
    }
  },
  props: {
    page: {
      type: Number,
      required: false,
      default: 1
    }
  },
  methods: {
    async fetchPosts () {
      const response = await axios.get(`/api/posts`,
      {
        params: {
          category: 2,
          page: this.page
        }
      })

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.posts = response.data.data
      this.currentPage = response.data.current_page
      this.lastPage = response.data.last_page
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
    return metatag("COLUMNS", "コラム記事の一覧を掲載しています。",
      location.protocol + '//' + location.host + "/storage/upload/images/favicon.png",
      location.protocol + '//' + location.host + "/storage/upload/images/favicon.png");
  }
}
</script>