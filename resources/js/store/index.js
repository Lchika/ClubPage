import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import post from './post'
import message from './message'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    error,
    post,
    message,
  }
})

export default store