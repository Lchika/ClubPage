import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'

const state = {
  apiStatus: null,
  submitPostErrorMessages: null,
  registerdId: null,
  updatePostErrorMessages: null,
}

const getters = {
}

const mutations = {
  setApiStatus (state, status) {
    state.apiStatus = status
  },
  setSubmitPostErrorMessages (state, messages) {
    state.submitPostErrorMessages = messages
  },
  setRegisterdId (state, id) {
    state.registerdId = id
  },
  setUpdatePostErrorMessages (state, messages) {
    state.updatePostErrorMessages = messages
  },
}

const actions = {
  async submitPost (context, data) {
    context.commit('setApiStatus', null)
    context.commit('setRegisterdId', null)
    const response = await axios.post('/api/posts', data)

    if (response.status === CREATED) {
      context.commit('setApiStatus', true)
      context.commit('setRegisterdId', response.data.id)

      // メッセージ登録
      context.commit('message/setContent', {
        content: '記事が投稿されました',
        timeout: 6000
      }, { root: true })
      return false
    }

    context.commit('setApiStatus', false)
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setSubmitPostErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
  },
  async updatePost (context, data) {
    context.commit('setApiStatus', null)
    context.commit('setRegisterdId', null)
    const response = await axios.put(`/api/posts/${data.id}`, data)

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setRegisterdId', response.data.id)

      // メッセージ登録
      context.commit('message/setContent', {
        content: '記事が更新されました',
        timeout: 6000
      }, { root: true })
      return false
    }

    context.commit('setApiStatus', false)
    if (response.status === UNPROCESSABLE_ENTITY) {
      context.commit('setUpdatePostErrorMessages', response.data.errors)
    } else {
      context.commit('error/setCode', response.status, { root: true })
    }
  },
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}