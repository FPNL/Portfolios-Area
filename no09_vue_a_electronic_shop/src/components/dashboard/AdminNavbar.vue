<template>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <router-link :to="{name:'TheHomeProducts'}"  class="navbar-brand col-sm-3 col-md-2 mr-0 text-white" style="user-select: none">慢工出細活商店</router-link>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="#" @click.prevent='signout'  style="user-select: none">登出</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'AdminNavbar',
  methods: {
    signout () {
      const api = `${process.env.VUE_APP_API}/logout`
      this.$http.post(api).then((response) => {
        console.log('signout', response.data)
        if (response.data.success) {
          this.$router.push('/home')
        }
      })
    }
  }
}

</script>

<style lang="scss" scoped>

</style>
