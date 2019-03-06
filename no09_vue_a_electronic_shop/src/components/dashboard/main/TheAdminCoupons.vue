<template lang='pug'>
  div(class='')
    loading(:active.sync="status.isLoading")
    div(class='mt4 d-flex justify-content-between')
      div
        span(class='badge badge-pill mx-2' @click='clickChange("forpeter")' :class="{'badge-primary': click=='forpeter', 'badge-light': click!=='forpeter'}") 男裝
        span(class='badge badge-pill mx-1' @click='clickChange("forwomen")' :class="{'badge-primary': click=='forwomen', 'badge-light': click!=='forwomen'}") 女裝
        span(class='badge badge-pill mx-1' @click='clickChange("forkids")' :class="{'badge-primary': click=='forkids', 'badge-light': click!=='forkids'}") 童裝
      button(class='btn btn-primary' @click='openModal(true)') 新增優惠券
    table(class='table mt-4 w-75 mx-auto')
      thead
        tr(class='text-center')
          th(class='text-left') 名稱
          th(class='' width='110') 折扣百分比
          th(class=''  width='120') 到期日
          th(class='text-right') 序號
          th(class='' width='100') 是否啟用
          th(class='' width='200') 編輯
      tbody
        tr(class='text-center' v-for="item in coupons" :key="item.id")
          td(class='text-left') {{item.title}}
          td(class='text-right') {{item.percent}}
          td(class='text-right') {{item.due_date}}
          td(class='text-right') {{item.code}}
          td
            span(v-if="item.is_enabled" class='text-success') 啟用
            span(v-else) 未啟用
          td
            button(class="btn btn-outline-primary btn-sm" @click='openModal(false, item)') 編輯
            button(class="btn btn-outline-danger btn-sm ml-3" @click='openDelModal(item)') 刪除

    BasePagination(:pagination='pagination' @pagination='getCoupons' v-if="pagination.total_pages>1")
    AdminFloatModal(@get-items='getCoupons' :item='coupon' :is-new='isNew' :click='click' :belongModal='"coupon"')
    BaseDeleteModal(@get-product='getCoupons' :product='coupon' :value='del_value' :click='click')
</template>

<script>
import AdminFloatModal from '@/components/dashboard/main/share/AdminFloatModal.vue'
import BaseDeleteModal from '@/components/dashboard/main/share/BaseDeleteModal.vue'
import BasePagination from '@/components/dashboard/main/share/BasePagination.vue'
import $ from 'jquery'
export default{
  name: 'TheAdminCoupons',
  data () {
    return {
      coupons: '',
      coupon: {},
      click: 'forpeter',
      del_value: 'coupon',
      pagination: {},
      isNew: false,
      status: {
        isLoading: false
      }
    }
  },
  components: {
    AdminFloatModal,
    BasePagination,
    BaseDeleteModal
  },
  methods: {
    getCoupons (page = 1) {
      const vm = this
      vm.status.isLoading = true
      const api = `${process.env.VUE_APP_API}/api/${vm.click}/admin/coupons?page=${page}`

      this.$http.get(api).then((response) => {
        if (response.data.success) { // 資料取得成功的話
          console.log('getCoupons', response)
          vm.coupons = response.data.coupons
          vm.pagination = response.data.pagination
        } else { // 有錯誤的話
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
    clickChange (item) {
      this.click = item
      this.getCoupons()
    },
    openModal (isNew, item) {
      if (isNew) {
        this.coupon = {}
        this.isNew = true
      } else {
        this.coupon = Object.assign({}, item)
        this.isNew = false
      }
      $('#FloatModal').modal('show')
    },
    openDelModal (item) {
      this.coupon = Object.assign({}, item)
      $('#delProductModal').modal('show')
    }
  },
  created () {
    this.getCoupons()
  }
}
</script>
<style scoped>
.badge{
  cursor: pointer;
}
</style>
