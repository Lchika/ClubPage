import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
//import PostList from './pages/PostList.vue'
//import Login from './pages/Login.vue'
//import PostForm from './pages/PostForm.vue'
//import PostDetail from './pages/PostDetail.vue'
//import PostUpdateForm from './pages/PostUpdateForm.vue'
//import Index from './pages/Index.vue'
//import SystemError from './pages/errors/System.vue'
//import NotFound from './pages/errors/NotFound.vue'

import store from './store'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
  {
    path: '/',
    component: resolve => { require.ensure(['./pages/Index.vue'], () => { resolve(require('./pages/Index.vue'))}, 'js/index')}
  },
  {
    path: '/posts',
    component: resolve => { require.ensure(['./pages/PostList.vue'], () => { resolve(require('./pages/PostList.vue'))}, 'js/post_list')},
    props: route => {
      const page = route.query.page
      return {
        page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1
      }
    }
  },
  {
    path: '/login',
    component: resolve => { require.ensure(['./pages/Login.vue'], () => { resolve(require('./pages/Login.vue'))}, 'js/login')},
    beforeEnter (to, from, next) {
      if (store.getters['auth/check']) {
        next('/')
      } else {
        next()
      }
    }
  },
  {
    path: '/posts/add',
    component: resolve => { require.ensure(['./pages/PostForm.vue'], () => { resolve(require('./pages/PostForm.vue'))}, 'js/post_form')},
    beforeEnter (to, from, next) {
      // ユーザログインしていない場合はルートに飛ばす
      if (store.getters['auth/check']) {
        next()
      } else {
        next('/')
      }
    }
  },
  {
    path: '/posts/:id',
    component: resolve => { require.ensure(['./pages/PostDetail.vue'], () => { resolve(require('./pages/PostDetail.vue'))}, 'js/post_detail')},
    props: true
  },
  {
    path: '/posts/:id/update',
    name: 'update',
    component: resolve => { require.ensure(['./pages/PostUpdateForm.vue'], () => { resolve(require('./pages/PostUpdateForm.vue'))}, 'js/post_update_form')},
    props: true,
    beforeEnter (to, from, next) {
      // ユーザログインしていない場合はルートに飛ばす
      if (store.getters['auth/check']) {
        next()
      } else {
        next('/')
      }
    }
  },
  {
    path: '/news',
    component: resolve => { require.ensure(['./pages/News.vue'], () => { resolve(require('./pages/News.vue'))}, 'js/news')},
  },
  {
    path: '/works',
    component: resolve => { require.ensure(['./pages/WorkList.vue'], () => { resolve(require('./pages/WorkList.vue'))}, 'js/work_list')},
    props: route => {
      const page = route.query.page
      return {
        page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1
      }
    }
  },
  {
    path: '/columns',
    component: resolve => { require.ensure(['./pages/ColumnList.vue'], () => { resolve(require('./pages/ColumnList.vue'))}, 'js/column_list')},
    props: route => {
      const page = route.query.page
      return {
        page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1
      }
    }
  },
  {
    path: '/tag/:id',
    component: resolve => { require.ensure(['./pages/TagPostList.vue'], () => { resolve(require('./pages/TagPostList.vue'))}, 'js/tag_post_list')},
    props: route => {
      const page = route.query.page
      const id = route.params.id
      return {
        id: id,
        page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1
      }
    }
  },
  {
    path: '/about',
    component: resolve => { require.ensure(['./pages/About.vue'], () => { resolve(require('./pages/About.vue'))}, 'js/about')}
  },
  {
    path: '/500',
    component: resolve => { require.ensure(['./pages/errors/System.vue'], () => { resolve(require('./pages/errors/System.vue'))}, 'js/system_error')}
  },
  {
    path: '*',
    component: resolve => { require.ensure(['./pages/errors/NotFound.vue'], () => { resolve(require('./pages/errors/NotFound.vue'))}, 'js/not_found')}
  }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router