<template>
  <b-navbar toggleable="lg">
    <b-navbar-brand>
      <RouterLink class="navbar__brand" to="/">
        TOP
      </RouterLink>
    </b-navbar-brand>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item>
          <RouterLink to="/news">
            活動履歴
          </RouterLink>
        </b-nav-item>
        <b-nav-item>
          <RouterLink to="/works">
            作品
          </RouterLink>
        </b-nav-item>
        <b-nav-item>
          <RouterLink to="/columns">
            コラム
          </RouterLink>
        </b-nav-item>
        <b-nav-item>
          <RouterLink to="/posts">
            記事
          </RouterLink>
        </b-nav-item>
        <b-nav-item>
          <RouterLink to="/about">
            ABOUT
          </RouterLink>
        </b-nav-item>
      </b-navbar-nav>
      <b-navbar-nav class="ml-auto">
        <div v-if="isLogin" class="navbar__item">
          <RouterLink class="button" to="/posts/add">
            <i class="icon ion-md-add"></i>
            記事を投稿する
          </RouterLink>
        </div>
        <span v-if="isLogin" class="navbar__item">
          {{ username }}
        </span>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
export default {
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
    },
    username () {
      return this.$store.getters['auth/username']
    }
  }
}
</script>

<style scoped>
a {
  color: #606060;
}
</style>