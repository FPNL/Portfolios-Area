<template>
  <div>
    <table class="table w-75 mx-auto" v-if="cart.total">
      <thead>
        <th></th>
        <th>品名</th>
        <th>數量</th>
        <th width='80'>單價</th>
      </thead>
      <tbody>
        <tr v-for="item in cart.carts" :key="item.id">
          <td class="align-middle">
            <button type="button" class="btn btn-outline-danger btn-sm" @click="delCart(item.id)">
              <i class="far fa-trash-alt"></i>
            </button>
          </td>
          <td class="align-middle">
            {{ item.product.title }}
            <div class="text-success" v-if="item.coupon">
              已套用優惠券
            </div>
          </td>
          <td class="align-middle">{{ item.qty }}/{{ item.product.unit }}</td>
          <td class="align-middle text-right">{{ item.final_total | currency}}</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" class="text-right">總計</td>
          <td class="text-right">{{ cart.total | currency}}</td>
        </tr>
        <tr>
          <td colspan="3" class="text-right text-success" v-if="cart.final_total<cart.total">折扣價</td>
          <td class="text-right text-success" v-if="cart.final_total<cart.total">{{ cart.final_total | currency}}</td>
        </tr>
        <tr v-if="page!=='no'">
          <td colspan="4">
            <div class="input-group input-group-sm">
              <input type="text" class="form-control" placeholder="請輸入優惠碼" v-model="code">
              <div class="input-group-append">
                <button  class="btn btn-outline-secondary" type="submit" @click="useCoupon">
                  套用優惠碼
                </button>
              </div>
            </div>
          </td>
        </tr>
        <tr v-if="page!=='no'">
          <td colspan="3" class="text-right"></td>
          <td class="text-right">
            <a href="#" class="btn btn-info btn-lg text-white" @click.prevent="goChange" v-if="page==='home'">付款去~</a>
            <router-link :to="{name: 'TheAdminCheckOut'}"  class="btn btn-info btn-lg text-white" v-if="page==='eProduct'">付款去~</router-link>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
export default {
  name: 'AdminCartList',
  props: ['page'],
  data () {
    return {
      cart: {},
      code: ''
    }
  },
  components: {},
  methods: {
    getCart (custapi = 'forpeter') {
      const vm = this
      const api = `${process.env.VUE_APP_API}/api/${custapi}/cart`

      this.$http.get(api).then((response) => {
        console.log('getCart', response)
        if (response.data.success) {
          vm.cart = response.data.data
        } else {
          vm.$bus.$emit('message:push', response.data.message, 'danger')
        }
      })
    },
    delCart (id) {
      const vm = this
      const api = `${process.env.VUE_APP_API}/api/${process.env.VUE_APP_CUSTAPI}/cart/${id}`

      this.$http.delete(api).then((response) => {
        console.log('delCart', response)
        if (response.data.success) {
          vm.$bus.$emit('message:push', response.data.message, 'warning')
        } else {
          vm.$bus.$emit('message:push', response.data.message, 'danger')
        }
        this.getCart()
      })
    },
    useCoupon () {
      const vm = this
      const api = `${process.env.VUE_APP_API}/api/${process.env.VUE_APP_CUSTAPI}/coupon`

      this.$http.post(api, {
        'data': {
          'code': vm.code
        }
      }).then((response) => {
        console.log('useCoupon', response)
        if (response.data.success) {
          vm.$bus.$emit('message:push', response.data.message, 'success')
          console.log('use coupon success')
        } else {
          vm.$bus.$emit('message:push', response.data.message, 'danger')
        }
        this.getCart()
        vm.code = ''
      })
    },
    goChange () {
      this.$emit('goChange')
    }

  },
  created () {
    const vm = this
    vm.getCart()
    vm.$bus.$on('getCart', function (custapi) {
      vm.getCart(custapi)
    })
  }
}

</script>
