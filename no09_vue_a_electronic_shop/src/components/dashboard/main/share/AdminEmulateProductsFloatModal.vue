<template>
  <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content border-0">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLabel">
            <span>{{product.title}} </span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-4">
              <img :src="product.image" class="img-fluid" alt="">
            </div>
            <div class="col-sm-8">
              <div class="form-group">
                <p>{{product.title}} </p>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="origin_price">原價</label>
                  <div class="h5" v-if="!product.price">{{product.origin_price}} 元</div>
                  <div><del class="h5" v-if="product.price">{{product.origin_price}} 元</del></div>
                </div>
                <div class="form-group col-md-6">
                  <label for="price">售價</label>
                  <div class="h5" v-if="product.price"> {{product.price}} 元</div>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="description">產品描述</label>
                  <p>{{product.description}} </p>
                </div>
                <div class="form-group col-md-6">
                  <label for="content">說明內容</label>
                  <p>{{product.content}} </p>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <select name="qyt" id="" v-model="qty">
            <option value="1" selected> 1 {{product.unit}} </option>
            <option :value="num+1" v-for="(num, index) in 9" :key="index"> {{num+1}} {{product.unit}}</option>
          </select>
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" @click="addToCart(product.id, qty)">確認</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import $ from 'jquery'
export default {
  name: 'AdminEmulateProductsFloatModal',
  props: ['product', 'isNew', 'cusapi'],
  data () {
    return {
      qty: 1
    }
  },
  methods: {
    addToCart (id, qty = 1) {
      const vm = this
      let api = `${process.env.VUE_APP_API}/api/${vm.cusapi}/cart`
      let content = { 'product_id': id, 'qty': qty }
      console.log(content)
      this.$http.post(api, { data: content }).then((response) => {
        console.log('addToCart success', response)
        if (response.data.success) {
          $('#productModal').modal('hide')
          vm.qty = 1
          vm.$bus.$emit('getCart')
        } else {
          console.log('addToCart failed, try again')
          vm.$bus.$emit('message:push', response.data.message, 'danger')
          $('#productModal').modal('hide')
        }
      })
    }
  },
  created () {
    const vm = this
    vm.$bus.$on('addCart', function (producId) {
      return vm.addToCart(producId)
    })
  }
}

</script>
