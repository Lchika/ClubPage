require('./bootstrap');

import Vue from 'vue'
//import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import { BImg } from 'bootstrap-vue'
Vue.component('b-img', BImg)
import { BRow } from 'bootstrap-vue'
Vue.component('b-row', BRow)
import { BCol } from 'bootstrap-vue'
Vue.component('b-col', BCol)
import { BForm } from 'bootstrap-vue'
Vue.component('b-form', BForm)
import { BFormGroup } from 'bootstrap-vue'
Vue.component('b-form-group', BFormGroup)
import { BButton } from 'bootstrap-vue'
Vue.component('b-button', BButton)
import { BFormInput } from 'bootstrap-vue'
Vue.component('b-form-input', BFormInput)
import { BIconTag } from 'bootstrap-vue'
Vue.component('b-icon-tag', BIconTag)
import { BIconArrowClockwise } from 'bootstrap-vue'
Vue.component('b-icon-arrow-clockwise', BIconArrowClockwise)
import { BIconCalendar } from 'bootstrap-vue'
Vue.component('b-icon-calendar', BIconCalendar)
import { BIconFolder } from 'bootstrap-vue'
Vue.component('b-icon-shift', BIconShift)
import { BIconShift } from 'bootstrap-vue'
Vue.component('b-icon-folder', BIconFolder)
import { BIconCircleFill } from 'bootstrap-vue'
Vue.component('b-icon-circle-fill', BIconCircleFill)
import { BIconCircleHalf } from 'bootstrap-vue'
Vue.component('b-icon-circle-half', BIconCircleHalf)
import { BNavbar } from 'bootstrap-vue'
Vue.component('b-navbar', BNavbar)
import { BNavbarNav } from 'bootstrap-vue'
Vue.component('b-navbar-nav', BNavbarNav)
import { BNavbarBrand } from 'bootstrap-vue'
Vue.component('b-navbar-brand', BNavbarBrand)
import { BNavbarToggle } from 'bootstrap-vue'
Vue.component('b-navbar-toggle', BNavbarToggle)
import { BNavItem } from 'bootstrap-vue'
Vue.component('b-nav-item', BNavItem)
import { BCollapse } from 'bootstrap-vue'
Vue.component('b-collapse', BCollapse)
// ルーティングの定義をインポートする
import router from './router'
import store from './store'
// ルートコンポーネントをインポートする
import App from './App.vue'

//import 'app.css'
//import 'bootstrap/dist/css/bootstrap.css'
//import 'bootstrap-vue/dist/bootstrap-vue.css'

// webpackの不具合でchunkが正常に読み込めないため、空のscssファイルをimportして強制リロード
// https://github.com/webpack/webpack/issues/959
require ('./fake.scss');

window.CKEditor = require('@ckeditor/ckeditor5-vue');
Vue.use(CKEditor);
//Vue.component('ckeditor-component', require('./components/CKEditorComponent.vue'));
require('@ckeditor/ckeditor5-build-classic/build/translations/ja');
// Install BootstrapVue
//Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
//Vue.use(IconsPlugin)

import VueMeta from 'vue-meta';
Vue.use(VueMeta);

import jQuery from 'jquery'
global.jquery = jQuery
global.$ = jQuery
window.$ = window.jQuery = require('jquery')

const createApp = async () => {
  // ページリロードでVuexが初期化されるためログインチェックする
  await store.dispatch('auth/currentUser')

  new Vue({
    el: '#app',
    router,
    store,
    components: { App },
    template: '<App />'
  })
}

createApp()