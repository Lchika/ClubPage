<template>
  <div class="thumbnail-button">
    <button type="button"><b-img thumbnail fluid v-bind:src="item.src"></b-img></button>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  }
}
</script>
