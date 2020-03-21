<template>
  <div>
    <div class="container-wrapp">
      <div class="container">
        <header>
          <Navbar />
        </header>
        <main>
          <Message />
          <RouterView />
          <div id="page_top"><a href="#"><b-icon-shift class="mt-3" scale="2.5"></b-icon-shift></a></div>
        </main>
        <Footer />
      </div>
    </div>
  </div>
</template>


<script>
import Message from './components/Message.vue'
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import { NOT_FOUND, UNAUTHORIZED, INTERNAL_SERVER_ERROR } from './util'

export default {
  components: {
    Message,
    Navbar,
    Footer
  },
  computed: {
    errorCode () {
      return this.$store.state.error.code
    }
  },
  watch: {
    errorCode: {
      async handler (val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        } else if (val === UNAUTHORIZED) {
          // トークンをリフレッシュ
          await axios.get('/api/refresh-token')
          // ストアのuserをクリア
          this.$store.commit('auth/setUser', null)
          // ログイン画面へ
          this.$router.push('/login')
        } else if (val === NOT_FOUND) {
          this.$router.push('/not-found')
        }
      },
      immediate: true
    },
    $route () {
      this.$store.commit('error/setCode', null)
    }
  },
  mounted: function() {
    var appear = false;
    var pagetop = $('#page_top');
    $(window).scroll(function () {
      if ($(this).scrollTop() > 100) {  //100pxスクロールしたら
        if (appear == false) {
          appear = true;
          pagetop.stop().animate({
            'bottom': '50px' //下から50pxの位置に
          }, 300); //0.3秒かけて現れる
        }
      } else {
        if (appear) {
          appear = false;
          pagetop.stop().animate({
            'bottom': '-50px' //下から-50pxの位置に
          }, 300); //0.3秒かけて隠れる
        }
      }
    });
    pagetop.click(function () {
      $('body, html').animate({ scrollTop: 0 }, 500); //0.5秒かけてトップへ戻る
      return false;
    });
  },
  metaInfo: {
    title: 'Title',
    titleTemplate: '%s | メカトロ同好会エルチカ'
  }
}
</script>

<style scoped>
* {
  background-color: #F8F8F8;
}

.container-wrapp * {
  background-color: #FFFFFF;
}

.container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

#page_top{
  width: 50px;
  height: 50px;
  position: fixed;
  right: 20px;
  bottom: -50px;
  opacity: 0.6;
  border-radius: 50%;
}
#page_top a{
  text-align: center;
  position: relative;
  display: block;
  width: 50px;
  height: 50px;
  text-decoration: none;
  border-radius: 50%;
  background-color: #000000;
  color: #FFFFFF;
}
#page_top svg{
  background-color: #000000;
}
</style>