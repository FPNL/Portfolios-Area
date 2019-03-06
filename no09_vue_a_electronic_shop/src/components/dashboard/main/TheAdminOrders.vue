<template lang='pug'>
  div
    loading(:active.sync="status.isLoading")
    div
      span(class='badge badge-pill mx-2' @click='clickChange("forpeter")' :class="{'badge-primary': click=='forpeter', 'badge-light': click!=='forpeter'}") 男裝
      span(class='badge badge-pill mx-1' @click='clickChange("forwomen")' :class="{'badge-primary': click=='forwomen', 'badge-light': click!=='forwomen'}") 女裝
      span(class='badge badge-pill mx-1' @click='clickChange("forkids")' :class="{'badge-primary': click=='forkids', 'badge-light': click!=='forkids'}") 童裝
    table(class='table mt-4')
      thead
        tr(class='text-center')
          th(class='' width='120') 購買時間
          th(class='text-left' width='120') E-mail
          th(class='text-left' width='220') 購買款項
          th(class='' width='80') 應付金額
          th(class='' width='100') 是否付款
          //- th(class='' width='100') 編輯
      tbody
        tr(class='text-center' v-for="item in orders" :key="item.id")
          td {{item.create_at}}
          td(class='text-left') {{item.user.email}}
          td(class="text-left")
            div(v-for="(product, key) in item.products" :key="key") {{product.product.title}} {{product.qty}} {{product.product.unit}}
          td(class='text-right') {{item.total | currency}}
          td
            span(v-if="item.is_paid" class='text-success') 已付款
            span(v-else) 未付款
    BasePagination(:pagination='pagination' @pagination='getOrders'  v-if="pagination.total_pages>1")
</template>

<script>
import BasePagination from '@/components/dashboard/main/share/BasePagination.vue'
export default{
  name: 'TheAdminOrders',
  data () {
    return {
      orders: {},
      order: {},
      click: 'forpeter',
      products: {},
      pagination: {},
      isNew: false,
      status: {
        isLoading: false
      }
    }
  },
  components: {
    BasePagination
  },
  methods: {
    getOrders (page = 1) {
      const vm = this
      vm.status.isLoading = true
      const api = `${process.env.VUE_APP_API}/api/${vm.click}/admin/orders?page=${page}`

      this.$http.get(api, vm.user).then((response) => {
        if (response.data.success) {
          console.log('getOrders', response)
          vm.orders = response.data.orders
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
    clickChange (item) {
      this.click = item
      this.getOrders()
    }
  },
  computed: {
  },
  created () {
    this.getOrders()
  }
}
</script>
<style scoped>
.badge{
  cursor: pointer;
}
</style>
