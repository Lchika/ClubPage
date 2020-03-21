<template>
  <div class="container--small">
    <h1>記事投稿</h1>
    <b-form class="form" @submit.prevent="submitPost">
      <div v-if="postErrors" class="errors">
        <ul v-if="postErrors.id">
          <li v-for="msg in postErrors.id" :key="msg">{{ msg }}</li>
        </ul>
        <ul v-if="postErrors.title">
          <li v-for="msg in postErrors.title" :key="msg">{{ msg }}</li>
        </ul>
        <ul v-if="postErrors.category_id">
          <li v-for="msg in postErrors.category_id" :key="msg">{{ msg }}</li>
        </ul>
        <ul v-if="postErrors.body">
          <li v-for="msg in postErrors.body" :key="msg">{{ msg }}</li>
        </ul>
      </div>
      <b-form-group label-for="id" label="記事ID:" description="本記事のurlになります。基本的に英数字及び-(ハイフン)で入力してください。">
        <b-form-input type="text" id="id" v-model="postForm.id"></b-form-input>
      </b-form-group>
      <b-form-group label-for="title" label="タイトル:">
        <b-form-input type="text" id="title" v-model="postForm.title"></b-form-input>
      </b-form-group>
      <b-form-group label-for="category-id" label="カテゴリーID:" description="1:作品、2:コラム">
        <b-form-input type="text" id="category-id" v-model="postForm.category_id"></b-form-input>
      </b-form-group>
      <b-form-group label-for="body" label="本文">
        <ckeditor :editor="editor" v-model="postForm.body" :config="editorConfig"></ckeditor>
      </b-form-group>
      <b-form-group label-for="abstract" label="要約" description="記事一覧表示時に使われます。">
        <b-form-input type="text" id="abstract" v-model="postForm.abstract"></b-form-input>
      </b-form-group>
      <!--
      <b-form-group label-for="thumbnail" label="サムネイル">
        <b-form-input type="text" class="form__item" id="thumbnail" v-model="postForm.thumbnail"></b-form-input>
        <button class="button button--inverse" v-on:click="upload">画像アップロード</button>
      </b-form-group>
      -->
      <b-form-group label-for="tags" label="タグ">
        <vue-tags-input
          v-model="tag"
          :tags="postForm.tags"
          :autocomplete-items="autocompleteItems"
          :validation="validation"
          @tags-changed="newTags => postForm.tags = newTags"
          @before-adding-tag="checkTag"
        />
      </b-form-group>
      <b-form-group label-for="thumbnail" label="サムネイル" description="候補一覧が表示されますので、そこから選んでください。">
        <b-form-input type="text" id="thumbnail" v-model="postForm.thumbnail"></b-form-input>
        <b-row>
          <b-col cols="4" v-for="image in thumbnailImages" :key="image.src">
            <div class="thumbnail-button">
              <button type="button" v-on:click="fillThumbnail(image.src)"><b-img thumbnail fluid v-bind:src="image.src"></b-img></button>
            </div>
          </b-col>
        </b-row>
      </b-form-group>
      <b-button type="submit" variant="primary">投稿する</b-button>
    </b-form>
  </div>
</template>

<script>
import { OK } from '../util'
import { mapState } from 'vuex'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import MediaUploadAdapter from '../utils/MediaUploadAdapter.js';
import { imgsrc } from '../utils/TagGetter.js';
import { fixIframe } from '../utils/FixIframeSource.js';
import VueTagsInput from '@johmun/vue-tags-input';

export default {
  components: {
    VueTagsInput,
  },
  data () {
    return {
      loading: false,
      postForm: {
        id: '',
        title: '',
        category_id: 0,
        body: '',
        abstract: '',
        thumbnail: '',
        tags: [],
      },
      editor: ClassicEditor,
      editorData: '<p>Content of the editor.</p>',
      editorConfig: {
        language: 'ja',
        extraPlugins: [this.uploadAdapter]
      },
      thumbnailImages: {},
      tag: '',
      validation: [{
        classes: 'max-length',
        rule: tag => tag.text.length > 20,
      }],
      autocompleteItems: [],
    }
  },
  computed: {
    filteredItems() {
      return this.autocompleteItems.filter(i => {
        return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
      });
    },
    ...mapState({
      apiStatus: state => state.post.apiStatus,
      postErrors: state => state.post.submitPostErrorMessages,
      registerdId: state => state.post.registerdId,
    })
  },
  methods: {
    async submitPost () {
      /*
      const formData = new FormData()
      formData.append('id', this.postForm.id)
      formData.append('title', this.postForm.title)
      formData.append('category_id', this.postForm.category_id)
      formData.append('body', this.postForm.body)
      */
      // postストアのsubmitPostアクションを呼び出す
      this.postForm.body = fixIframe(this.postForm.body)
      await this.$store.dispatch('post/submitPost', this.postForm)
      if (this.apiStatus) {
        // 記事詳細ページに移動する
       this.$router.push(`/posts/${this.registerdId}`)
      }
    },
    clearError () {
      this.$store.commit('post/setSubmitPostErrorMessages', null)
    },
    uploadAdapter(editor) {
      editor.plugins.get('FileRepository').createUploadAdapter = loader => {
        return new MediaUploadAdapter(loader);
      };
    },
    fillThumbnail(src) {
      this.postForm.thumbnail = src
    },
    checkTag(obj) {
      if (obj.tag.text.length > 20) console.log('タグは20文字まで')
      else obj.addTag();
    },
    async fetchAutoCompleteTags () {
      const response = await axios.get(`/api/tags`)
      
      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.autocompleteItems = response.data.data
    },
  },
  created () {
    this.clearError()
  },
  watch: {
    $route: {
      async handler () {
        await this.fetchAutoCompleteTags()
      },
      immediate: true
    },
    'postForm.body': function(val){
      this.thumbnailImages = imgsrc(this.postForm.body)
      //console.log(this.thumbnailImages);
    }
  },
}
</script>