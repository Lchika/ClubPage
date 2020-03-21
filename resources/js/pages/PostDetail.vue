<template>
  <div v-if="post" class="post-detail">
    <div v-if="isLogin">
      <RouterLink class="button" :to="{name: 'update', params:{id:post.id}}">
        <i class="icon ion-md-add"></i>
        記事を編集する
      </RouterLink>
    </div>
    <h1 class="post-detail__title mt-3 mb-3">
      {{ post.title }}
    </h1>
    <div class="post-detail__category my-2">
      <RouterLink :to="`/${post.category.name}s`">
        <b-button size="sm" variant="secondary" class="mx-1"><b-icon-folder></b-icon-folder>{{ post.category.name }}</b-button>
      </RouterLink>
    </div>
    <div class="post-detail__tags my-1">
      <span v-for="tag in post.tags" :key="tag.name" class="post-detail__tag mx-1">
        <RouterLink :to="`/tag/${tag.name}`">
          <b-button size="sm" variant="tag"><b-icon-tag></b-icon-tag>{{ tag.name }}</b-button>
        </RouterLink>
      </span>
    </div>
    <div class="post-detail__body mt-5" v-html="post.body"></div>
    <!--<div class="post-detail__body mt-5">
      <PostContent :content="post.body" />
    </div>-->
    <!--
    <ul v-if="post.comments.length > 0" class="post-detail__comments mt-5">
      <li
        v-for="comment in post.comments"
        :key="comment.body"
        class="post-detail__commentItem"
      >
        <p class="post-detail__commentBody">
          {{ comment.body }}
        </p>
        <p class="post-detail__commentInfo">
          {{ comment.user_name }}
        </p>
      </li>
    </ul>
    <p class="mt-5 pt-5" v-else>コメントはまだないよ。</p>
    <form @submit.prevent="addComment" class="form">
      <div v-if="commentErrors" class="errors">
        <ul v-if="commentErrors.user_name">
          <li v-for="msg in commentErrors.user_name" :key="msg">{{ msg }}</li>
        </ul>
        <ul v-if="commentErrors.user_link">
          <li v-for="msg in commentErrors.user_link" :key="msg">{{ msg }}</li>
        </ul>
        <ul v-if="commentErrors.body">
          <li v-for="msg in commentErrors.body" :key="msg">{{ msg }}</li>
        </ul>
      </div>
      <b-form-group label-for="userName" label="ユーザ名">
        <b-form-input type="text" class="form__item" id="userName" v-model="comment.userName"></b-form-input>
      </b-form-group>
      <b-form-group label-for="userLink" label="リンク" description="任意" >
        <b-form-input type="text" class="form__item" id="userLink" v-model="comment.userLink"></b-form-input>
      </b-form-group>
      <b-form-group label-for="body" label="コメント">
        <b-form-input type="text" class="form__item" id="body" v-model="comment.body"></b-form-input>
      </b-form-group>
      <div class="form__button">
        <b-button type="submit" class="button button--inverse">コメントを投稿する</b-button>
      </div>
    </form>
    -->
  </div>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'
//import PostContent from '../components/PostContent.vue'
import { metatag } from '../utils/metatag.js'

export default {
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data () {
    return {
      post: null,
      comment: {
        body: '',
        userName: '',
        userLink: '',
      },
      commentErrors: null,
    }
  },
  methods: {
    async fetchPost () {
      const response = await axios.get(`/api/posts/${this.id}`)

      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }

      this.post = response.data
    },
    async addComment () {
      const response = await axios.post(`/api/posts/${this.id}/comments`, {
        body: this.comment.body,
        user_name: this.comment.userName,
        user_link: this.comment.userLink,
      })

      // バリデーションエラー
      if (response.status === UNPROCESSABLE_ENTITY) {
        this.commentErrors = response.data.errors
        return false
      }

      this.comment.body = ''
      this.comment.userName = ''
      this.comment.userLink = ''
      // エラーメッセージをクリア
      this.commentErrors = null

      // その他のエラー
      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.post.comments = [
        response.data,
        ...this.post.comments
      ]
    }
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchPost()
      },
      immediate: true
    }
  },
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
    },
  },
  metaInfo () {
    return this.post ? metatag(this.post.title, this.post.abstract,
      location.protocol + '//' + location.host + this.post.thumbnail,
      location.protocol + '//' + location.host + "/storage/upload/images/favicon.png")
      : null;
  }
}
</script>

<style scoped>
.post-detail__tags {
  line-height: 2.5rem;
}
.post-detail h1 {
  font-weight: bold;
}
.post-detail__body >>> h2 {
  font-weight: bold;
  border-bottom: solid 1px lightgrey;
  margin-top: 3rem;
  margin-bottom: 1.5rem;
  padding: 0.5rem 0;
  font-size: 1.7rem;
}
.post-detail__body >>> h3 {
  font-weight: bold;
  margin-top: 2rem;
  margin-bottom: 1.2rem;
  font-size: 1.4rem;
}
.post-detail__body >>> h4 {
  font-weight: bold;
  margin-top: 2rem;
  font-size: 1.1rem;
}
</style>