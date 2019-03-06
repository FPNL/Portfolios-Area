<template>
  <div id="app">
    <alert></alert>
    <div id="container">
      <router-view />
    </div>
  </div>
</template>

<script>
// https://github.com/hexschool/vue-course-api-wiki/wiki
import Alert from '@/components/app/Alert.vue'
export default {
  components: {
    Alert
  },
  methods: {},
  created () {
  }
}

</script>

<style lang="scss">
  @import './assets/scss/all'

</style>
