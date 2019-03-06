<template>
  <div class="my-5 row justify-content-center">
    <form class="col-6 mr-3" v-if="!orderID">
      <div class="form-group">
        <label for="useremail">Email</label>
        <input type="email" class="form-control" name="email" id="useremail" v-validate="'required|email'" v-model="form.user.email"
          placeholder="請輸入 Email" data-vv-as="E-Mail" :class="{'is-invalid': errors.has('email')}" required>
        <span class="text-danger">{{ errors.first('email') }}</span>
      </div>

      <div class="form-group">
        <label for="username">收件人姓名</label>
        <input type="text" class="form-control" name="name" id="username" v-model="form.user.name" placeholder="輸入姓名"
          v-validate="'required'" :class="{'is-invalid': errors.has('name')}" data-vv-as="姓名">
        <span class="text-danger">{{ errors.first('name') }}</span>
      </div>

      <div class="form-group">
        <label for="usertel">收件人電話</label>
        <input type="tel" class="form-control" v-validate="'required|digits:10'" name="tel" id="usertel" v-model="form.user.tel"
          placeholder="請輸入電話" :class="{'is-invalid': errors.has('tel')}">
        <span class="text-danger" v-if=" errors.has('tel') ">手機號碼為10碼</span>
      </div>

      <div class="form-group">
        <label for="useraddress">收件人地址</label>
        <input type="address" class="form-control" name="address" id="useraddress" v-model="form.user.address"
          v-validate="'required'" :class="{'is-invalid': errors.has('address')}" placeholder="請輸入地址">
        <span class="text-danger" v-if=" errors.has('address') ">地址欄位不得留空</span>
      </div>

      <div class="form-group">
        <label for="useraddress">留言</label>
        <textarea name="" id="" class="form-control" cols="30" rows="3" v-model="form.message"></textarea>
      </div>
      <div class="text-right">
        <button class="btn btn-danger"  @click.prevent="postOrder">送出訂單</button>
      </div>
    </form>

    <form class="col-md-8" @submit.prevent="payOrder"  v-if="orderID">
      <table class="table">
        <thead>
          <th>品名</th>
          <th>數量</th>
          <th>單價</th>
        </thead>
        <tbody>
          <tr v-for="item in order.products" :key="item.id">
            <td class="align-middle" v-if="item.product.title">{{ item.product.title }}</td>
            <td class="align-middle">{{ item.qty }}/{{ item.product.unit }}</td>
            <td class="align-middle text-right">{{ item.final_total }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2" class="text-right">總計</td>
            <td class="text-right">{{ order.total }}</td>
          </tr>
        </tfoot>
      </table>

      <table class="table">
        <tbody>
          <tr>
            <th width="100">Email</th>
            <td v-if="order.user">{{ order.user.email }}</td>
          </tr>
          <tr>
            <th>姓名</th>
            <td v-if="order.user.name">{{ order.user.name }}</td>
          </tr>
          <tr>
            <th>收件人電話</th>
            <td>{{ order.user.tel }}</td>
          </tr>
          <tr>
            <th>收件人地址</th>
            <td>{{ order.user.address }}</td>
          </tr>
          <tr>
            <th>付款狀態</th>
            <td>
              <span v-if="!order.is_paid">尚未付款</span>
              <span v-else class="text-success">付款完成</span>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="text-right" v-if="order.is_paid === false">
        <button class="btn btn-danger" @click.prevent="payOrder">確認付款去</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'TheAdminCheckOut',
  props: {},
  data () {
    return {
      order: {},
      orderID: '',
      form: {
        user: {
          name: '',
          email: '',
          tel: '',
          address: ''
        },
        message: ''
      }
    }
  },
  methods: {
    payOrder () {
      const vm = this
      const api = `${process.env.VUE_APP_API}/api/${process.env.VUE_APP_CUSTAPI}/pay/${vm.orderID}`

      this.$http.post(api).then((response) => {
        console.log('payOrder', response)
        if (response.data.success) {
          vm.$bus.$emit('message:push', response.data.message, 'success')
          vm.getOrder()
        } else {
          vm.$bus.$emit('message:push', response.data.message, 'danger')
        }
      })
    },
    getOrder () {
      const vm = this
      const api = `${process.env.VUE_APP_API}/api/${process.env.VUE_APP_CUSTAPI}/order/${vm.orderID}`

      this.$http.get(api).then((response) => {
        console.log('delCart', response)
        if (response.data.success) {
          vm.order = response.data.order
          console.log(vm.order)
        } else {
          vm.$bus.$emit('message:push', response.data.message, 'danger')
        }
      })
    },
    postOrder () {
      const vm = this
      const api = `${process.env.VUE_APP_API}/api/${process.env.VUE_APP_CUSTAPI}/order`
      this.$validator.validate().then((result) => {
        if (result) {
          this.$http.post(api, { data: vm.form }).then((response) => {
            console.log('postOrder', response)
            if (response.data.success) {
              vm.$bus.$emit('message:push', response.data.message, 'success')
              console.log('postOrder success')
              vm.orderID = response.data.orderId
              vm.getOrder()
            } else {
              vm.$bus.$emit('message:push', response.data.message, 'danger')
            }
          })
        } else {
          vm.$bus.$emit('message:push', '欄位不完整', 'danger')
        }
      })
    }
  },
  created () {
    console.log(this.order)
  }
}
</script>
