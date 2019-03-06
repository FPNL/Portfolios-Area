<template>
  <div>
    <AdminCartList v-if="!goCheck" @goChange='changeValue' :page="'home'"></AdminCartList>
    <TheAdminCheckOut v-if="goCheck"></TheAdminCheckOut>
  </div>
</template>

<script>
import AdminCartList from '@/components/dashboard/main/share/AdminCartList.vue'
import TheAdminCheckOut from '@/components/dashboard/main/TheAdminCheckOut.vue'
export default {
  name: 'TheHomeCheckOut',
  props: {},
  data () {
    return {
      goCheck: false,
      page: 'home'
    }
  },
  components: {
    AdminCartList,
    TheAdminCheckOut
  },
  methods: {
    changeValue () {
      this.goCheck = !this.goCheck
    }
  },
  created () {

  }
}

</script>
