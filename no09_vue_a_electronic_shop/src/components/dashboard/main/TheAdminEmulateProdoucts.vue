<template>
  <div>
    <loading :active.sync="status.isLoading"></loading>
    <div class="row mt-4">
      <div class="col-md-4 mb-4" v-for="(item, index) in products" :key="index">
        <div class="card border-0 shadow-sm">
          <div style="height: 150px; background-size: cover; background-position: center" :style="{backgroundImage: `url(${item.image} ) `}">
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
          <div class="card-footer d-flex">
            <button type="button" class="btn btn-outline-secondary btn-sm" @click="openModal(false, item)">
              <i class="fas fa-spinner fa-spin" v-if="status.moreLoading"></i>
              查看更多
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm ml-auto" @click="addtocart(item.id)">
              <i class="fas fa-spinner fa-spin" v-if="status.carLoaging"></i>
              加到購物車
            </button>
          </div>
        </div>
      </div>
    </div>
    <base-pagination :pagination='pagination' @pagination='getProducts'></base-pagination>
    <admin-cart-list class="mt-5" :page="'eProduct'"></admin-cart-list>
    <admin-emulate-products-float-modal :product='product' :is-new='isNew' :cusapi="'forpeter'"></admin-emulate-products-float-modal>
  </div>
</template>

<script>
import AdminEmulateProductsFloatModal from '@/components/dashboard/main/share/AdminEmulateProductsFloatModal.vue'
import AdminCartList from '@/components/dashboard/main/share/AdminCartList.vue'
import BasePagination from '@/components/dashboard/main/share/BasePagination.vue'
import $ from 'jquery'
export default {
  name: 'TheAdminEmulateProdoucts',
  data () {
    return {
      products: '',
      product: {},
      page: 'eProduct',
      del_value: 'product',
      pagination: {},
      isNew: false,
      status: {
        isLoading: false,
        carLoaging: false,
        moreLoading: false
      }
    }
  },
  components: {
    AdminEmulateProductsFloatModal,
    AdminCartList,
    BasePagination
  },
  methods: {
    getProducts (page = 1) {
      const vm = this
      vm.status.isLoading = true
      const api = `${process.env.VUE_APP_API}/api/${process.env.VUE_APP_CUSTAPI}/products?page=${page}`

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
      .catch((err)=>{
        console.log("The admin Products got no internet,  ", err)
      })
      .then(()=>{
        vm.status.isLoading = false
      })
    },
    openModal (item) {
      this.status.moreLoading = true
      this.product = Object.assign({}, item)
      this.isNew = false
      $('#productModal').modal('show')
      this.status.moreLoading = false
    },
    openDelModal (item) {
      this.product = Object.assign({}, item)
      $('#delProductModal').modal('show')
    },
    addtocart (id) {
      this.status.carLoaging = true
      this.$bus.$emit('addCart', id)
      this.status.carLoaging = false
    }
  },
  created () {
    this.getProducts()
  }

}

</script>

<style lang="scss" scoped>

</style>
