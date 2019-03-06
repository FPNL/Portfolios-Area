<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
      <router-link class="navbar-brand" :to="{name:'TheHomeProducts'}">Navbar</router-link>
      <div class="d-flex">
        <ul>
          <li class="li1"  @mouseover="mouseOver(true)" @mouseout="mouseOver(false)">
            <router-link :to="{name: 'TheHomeCheckOut'}" class="hover_for">購物車</router-link>
            <div  class=" showOrder" v-show="codidi">
              <admin-cart-list :page="'no'" ></admin-cart-list>
            </div>
          </li>
        </ul>
        <router-link :to='{name: "Login"}' class="mx-4">登入</router-link>
      </div>

    </nav>
    <router-view/>
  </div>
</template>

<script>
import AdminCartList from '@/components/dashboard/main/share/AdminCartList.vue'
export default {
  name: 'Home',
  data () {
    return {
      codidi: false
    }
  },
  components: {
    AdminCartList
  },
  methods: {
    mouseOver (tf) {
      this.codidi = tf
    }
  },
  created () {
    this.$router.push({ name: 'TheHomeProducts' })
  }
}
</script>

<style scoped>
ul{
  margin: 0;
  padding: 0;
}
.li1{
  text-decoration: none;
  list-style: none;
  position: relative;
}
.showOrder{
  position: absolute;
  top: 100%;
  right: 0;
  z-index: 2;
  width: 800px;
  background-color: rgb(213, 219, 219);
  color: rgb(13, 18, 22) ;
  border-radius: 5px;
}
</style>
