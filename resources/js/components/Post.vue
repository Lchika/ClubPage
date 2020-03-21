<template>
  <div class="postlist">
    <b-row>
    <b-col cols="12" md="6" lg="4" class="p-4" v-for="item in items" :key="item.id">
      <div class="post-card card-link hover-shadow">
        <RouterLink
          class="post__overlay"
          :to="`/posts/${item.id}`"
        >
        </RouterLink>
        <div class="post-thumbnail">
          <b-img fluid-grow v-bind:src=item.thumbnail></b-img>
        </div>
        <div class="post-content">
          <div class="post-card__tag">
            <span v-for="tag in item.tags" :key="tag.name" class="mr-1">
              <b-button size="sm" variant="tag"><b-icon-tag></b-icon-tag> {{ tag.name }}</b-button>
            </span>
          </div>
          <div class="post-title">
            {{item.title}}
          </div>
          <div class="post-card__meta">
            <b-icon-arrow-clockwise></b-icon-arrow-clockwise>{{item.updated_at}} <b-icon-calendar class="ml-2"></b-icon-calendar>{{item.created_at}}
          </div>
          
        </div>
      </div>
    </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      required: true
    }
  }
}
</script>

<style scoped>
.post-card {
  transition: 0.5s;
  overflow: hidden;
  width: 100%;
  border-radius: 5px;
  background: #fff;
  box-shadow: 0 2px 4px #ccc;
  height: 100%;
}

.post-card .post-title {
  font-size: 1.2em;
  margin-top: 3px;
  margin-bottom: 40px;
  color: #333;
}

.post-card .post-thumbnail img {
  height: 250px;
  object-fit: cover;
}

.post-card .post-content {
  padding: 10px 20px 10px 20px;
}

.card-link {
  position: relative;
}

.card-link > a {
  position: absolute;
  top: 0;
  left: 0;
  height:100%;
  width: 100%;
}

.hover-shadow {
  transition: all 0.25s ease 0s;
}

.hover-shadow:hover {
  box-shadow: 0 7px 10px 0 rgba(0, 0, 0, 0.25);
}

.post-card__meta {
  margin-top: 20px;
  color: gray;
  position: absolute;
  bottom: 10px;
}
.post-card__tag {
  line-height: 2rem;
}
</style>