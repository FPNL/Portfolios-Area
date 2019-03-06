<template>
  <div class="row mt-4">
    <div class="col-2">
      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab"
          aria-controls="v-pills-home" aria-selected="true" @click.prevent="custapi='forpeter'">男裝</a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab"
          aria-controls="v-pills-profile" aria-selected="false" @click.prevent="custapi='forwomen'">女裝</a>
        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab"
          aria-controls="v-pills-messages" aria-selected="false" @click.prevent="custapi='forkids'">童裝</a>
        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab"
          aria-controls="v-pills-settings" aria-selected="false" @click.prevent="custapi='foract'">活動特賣</a>
      </div>
    </div>

    <div class="tab-content col-10" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

        <HomeProductsFloatModal :cusapi='custapi' v-if="custapi=='forpeter'"/>

      </div>
      <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">

        <HomeProductsFloatModal :cusapi='custapi' v-if="custapi=='forwomen'"/>

      </div>
      <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">

        <HomeProductsFloatModal :cusapi='custapi' v-if="custapi=='forkids'" />

      </div>
      <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
        你還期待著特賣活動阿？ <br>
        2020年2/31日準時開賣！
      </div>
    </div>
    <div class="col-9">
    </div>
  </div>
</template>

<script>
import HomeProductsFloatModal from '@/components/homeModal/HomeProductsFloatModal.vue'
export default {
  name: 'TheHomeProducts',
  data () {
    return {
      custapi: 'forpeter'
    }
  },
  components: {
    HomeProductsFloatModal
  },
  methods: {

  },
  watch: {
    custapi () {
      this.$bus.$emit('getCart', this.custapi)
      console.log('changeOutSide')
    }
  },
  created () {

  }
}

</script>
