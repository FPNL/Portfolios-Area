<template>
  <div class="">
    <loading :active.sync="status.isLoading"></loading>
    <div class="card_group">
      <div class="card border-0 shadow-sm mx-1 my-3 cusor_all" v-for="(item, index) in products" :key="index" @click="openModal(item)" v-if="item.is_enabled">
        <div style="height: 300px; background-size: cover; background-position: center" :style="{backgroundImage: `url(${item.image} ) `}">
        </div>
        <div class="card-body">
          <span class="badge badge-secondary float-right ml-2">分類</span>
          <h5 class="card-title">
            <a href="#" class="text-dark">{{item.title}}</a>
          </h5>
          <p class="card-text">{{item.content}}</p>
          <div class="d-flex justify-content-between align-items-baseline">
            <div class="h5" v-if="!item.price">{{item.origin_price}} 元</div>
            <del class="h6" v-if="item.price">原價 {{item.origin_price}} 元</del>
            <div class="h5" v-if="item.price">現在只要 {{item.price}} 元</div>
          </div>
        </div>
      </div>
    </div>
    <AdminEmulateProductsFloatModal :product='product' :cusapi='cusapi'></AdminEmulateProductsFloatModal>
  </div>
</template>

<script>
import AdminEmulateProductsFloatModal from '@/components/dashboard/main/share/AdminEmulateProductsFloatModal.vue'
import $ from 'jquery'
export default {
  name: 'HomeProductsFloatModal',
  props: {
    cusapi: String
  },
  data () {
    return {
      products: {},
      product: {},
      pagination: {},
      status: {
        isLoading: false,
        moreLoading: false,
        cartLoading: false
      }
    }
  },
  components: {
    AdminEmulateProductsFloatModal
  },
  methods: {
    getProducts (page = 1) {
      const vm = this
      vm.status.isLoading = true
      const api = `${process.env.VUE_APP_API}/api/${vm.cusapi}/products/all`

      this.$http.get(api).then((response) => {
        if (response.data.success) {
          console.log('geteProducts', response)
          vm.products = response.data.products
          vm.pagination = response.data.pagination
        } else {
          vm.$bus.$emit('message:push', response.data.message, 'danger')
        }
        // vm.status.isLoading = false
      })
      .catch((err)=>{console.log("HomeproductsFloatModal",err)})
      .then(()=>{
        vm.status.isLoading=false;
      })
    },
    openModal (item) {
      this.status.isLoading = true
      this.product = Object.assign({}, item)
      $('#productModal').modal('show')
      this.status.isLoading = false
    }
  },
  watch: {
    cusapi () {
      this.getProducts()
    }
  },
  created () {
    this.getProducts()
  }
}

</script>

<style scoped>
  .card_group {
    display: flex;
    flex-wrap: wrap;
  }

  .cusor_all,
  .cusor_all:hover {
    cursor: pointer;
    text-decoration: none;
  }

</style>
