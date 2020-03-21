<template>
  <div class="about">
    <h1 class="my-4">メカトロ同好会エルチカについて</h1>
    <p>
      本団体は、電子工作が好きな人の集まりです。</br>
      主に愛知県周辺のメイカーイベントに出展していたりします。
    </p>
    <h2 class="my-3">連絡先</h2>
    <p>
      準備中...
    </p>
  </div>
</template>

<script>
import { metatag } from '../utils/metatag.js'

export default {
  metaInfo () {
    return metatag("ABOUT", "本団体 メカトロ同好会エルチカ についての情報を記載しています。",
      location.protocol + '//' + location.host + "/storage/upload/images/favicon.png",
      location.protocol + '//' + location.host + "/storage/upload/images/favicon.png");
  }
}
</script>
