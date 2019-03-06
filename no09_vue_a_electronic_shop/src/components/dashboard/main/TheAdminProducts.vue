<template lang='pug'>
  div
    loading(:active.sync="status.isLoading")
    div(class='mt4 d-flex justify-content-between')
      div
        span(class='badge badge-pill mx-2' @click='clickChange("forpeter")' :class="{'badge-primary': click=='forpeter', 'badge-light': click!=='forpeter'}") 男裝
        span(class='badge badge-pill mx-1' @click='clickChange("forwomen")' :class="{'badge-primary': click=='forwomen', 'badge-light': click!=='forwomen'}") 女裝
        span(class='badge badge-pill mx-1' @click='clickChange("forkids")' :class="{'badge-primary': click=='forkids', 'badge-light': click!=='forkids'}") 童裝
      button(class=' btn btn-primary' @click='openModal(true)') 新增產品
    table(class='table mt-4')
      thead
        tr(class='text-center')
          th(class='' width='120') 分類
          th(class='text-left') 產品名稱
          th(class='' width='80') 原價
          th(class='' width='80') 售價
          th(class='' width='100') 是否啟用
          th(class='' width='130') 編輯
      tbody
        tr(class='text-center' v-for="item in products" :key="item.id")
          td {{item.category}}
          td(class='text-left') {{item.title}}
          td(class='text-right') {{item.origin_price | currency}}
          td(class="text-right") {{item.price | currency}}
          td
            span(v-if="item.is_enabled" class='text-success') 啟用
            span(v-else) 未啟用
          td
            button(class="btn btn-outline-primary btn-sm" @click='openModal(false, item)') 編輯
            button(class="btn btn-outline-danger btn-sm ml-1" @click='openDelModal(item)') 刪除
    AdminFloatModal(@get-items='getProducts' :item='product' :is-new='isNew' :click='click' :belongModal='"product"')
    BasePagination(:pagination='pagination' @pagination='getProducts')
    BaseDeleteModal(@get-product='getProducts' :product='product' :value='del_value' :click='click')
</template>

<script>
import AdminFloatModal from '@/components/dashboard/main/share/AdminFloatModal.vue'
import BaseDeleteModal from '@/components/dashboard/main/share/BaseDeleteModal.vue'
import BasePagination from '@/components/dashboard/main/share/BasePagination.vue'
import $ from 'jquery'
export default{
  name: 'TheAdminProducts',
  data () {
    return {
      products: '',
      click: 'forpeter',
      product: {},
      del_value: 'product',
      pagination: {},
      isNew: false,
      status: {
        isLoading: false
      }
    }
  },
  components: {
    AdminFloatModal,
    BaseDeleteModal,
    BasePagination
  },
  methods: {
    getProducts (page = 1) {
      const vm = this
      vm.status.isLoading = true
      const api = `${process.env.VUE_APP_API}/api/${vm.click}/admin/products?page=${page}`

      this.$http.get(api).then((response) => {
        if (response.data.success) {
          console.log('getProducts', response)
          vm.products = response.data.products
          vm.pagination = response.data.pagination
        } else {
          vm.$bus.$emit('message:push', response.data.message, 'danger')
        }
      })
      .catch((err)=>{
        console.log("The admin Products got no internet,  ", err)
      })
      .then(()=>{
        vm.status.isLoading = false
      })
    },
    clickChange (item) {
      this.click = item
      this.getProducts()
    },
    openModal (isNew, item) {
      if (isNew) {
        this.product = {}
        this.isNew = true
      } else {
        this.product = Object.assign({}, item)
        this.isNew = false
      }
      $('#FloatModal').modal('show')
    },
    openDelModal (item) {
      this.product = Object.assign({}, item)
      $('#delProductModal').modal('show')
    }
  },
  created () {
    this.getProducts()
  }
}
</script>

<style scoped>
.badge{
  cursor: pointer;
}
</style>
