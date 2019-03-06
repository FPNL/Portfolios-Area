<template>
  <div class="modal fade" id="FloatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content border-0">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="exampleModalLabel">
            <span v-if="belongModal=='product'">新增產品</span>
            <span v-if="belongModal=='coupon'">新增優惠券</span>
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-4" v-if="belongModal=='product'">
              <div class="form-group">
                <label for="image">輸入圖片網址</label>
                <input type="text" class="form-control" id="image" placeholder="請輸入圖片連結" v-model="item.image">
              </div>
              <div class="form-group">
                <label for="customFile">或 上傳圖片
                  <i class="fas fa-spinner fa-spin" v-if="status.fileLoading"></i>
                </label>
                <input type="file" id="customFile" class="form-control" ref="files" @change="uploadFile">
              </div>
              <img :src="item.image" class="img-fluid" alt="">
            </div>
            <div :class="{ 'col-12' : belongModal == 'coupon' , 'col-8' : belongModal == 'product' }">
              <div class="form-group">
                <label for="title">標題</label>
                <input type="text" class="form-control" id="title" placeholder="請輸入名稱"
                  v-model="item.title">
              </div>
              <div class="form-row" v-if="belongModal=='product'">
                <div class="form-group col-md-6">
                  <label for="category">分類</label>
                  <input type="text" class="form-control" id="category" placeholder="請輸入分類" v-model="item.category">
                </div>
                <div class="form-group col-md-6">
                  <label for="price">單位</label>
                  <input type="unit" class="form-control" id="unit" placeholder="請輸入單位" v-model="item.unit">
                </div>
              </div>
              <div class="form-row" v-if="belongModal=='product'">
                <div class="form-group col-md-6">
                  <label for="origin_price">原價</label>
                  <input type="number" class="form-control" id="origin_price" placeholder="請輸入原價" v-model="item.origin_price">
                </div>
                <div class="form-group col-md-6">
                  <label for="price">售價</label>
                  <input type="number" class="form-control" id="price" placeholder="請輸入售價" v-model="item.price">
                </div>
              </div>
              <hr v-if="belongModal=='product'">
              <div class="form-group" v-if="belongModal=='product'">
                <label for="description">產品描述</label>
                <textarea type="text" class="form-control" id="description" placeholder="請輸入產品描述" v-model="item.description"></textarea>
              </div>
              <div class="form-group" v-if="belongModal=='product'">
                <label for="content">說明內容</label>
                <textarea type="text" class="form-control" id="content" placeholder="請輸入產品說明內容" v-model="item.content"></textarea>
              </div>

              <div class="form-row" v-if="belongModal=='coupon'">
                <div class="form-group col-md-6">
                  <label for="origin_price">折扣百分比</label>
                  <input type="number" class="form-control" id="origin_price" placeholder="請輸入折扣百分比" v-model="item.percent">
                </div>
                <div class="form-group col-md-6">
                  <label for="price">到期日</label>
                  <input type="date" class="form-control" id="price" placeholder="請輸入期限" v-model="item.due_date">
                </div>
              </div>
              <div class="form-row" v-if="belongModal=='coupon'">
                <div class="form-group">
                  <label for="price">優惠券序號</label>
                  <input type="text" class="form-control" id="price" placeholder="請輸入序號" v-model="item.code">
                </div>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="is_enabled" v-model="item.is_enabled" :true-value='1'
                    :false-value='0'>
                  <label class="form-check-label" for="is_enabled">
                    是否啟用
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-primary" @click="buildItem">確認</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import $ from 'jquery'
export default {
  name: 'AdminfloatModal',
  props: ['item', 'isNew', 'click', 'belongModal'],
  data () {
    return {
      status: {
        fileLoading: false
      }
    }
  },
  methods: {
    buildItem () {
      const vm = this
      let api = `${process.env.VUE_APP_API}/api/${vm.click}/admin/${vm.belongModal}`
      let method = 'post'
      if (!vm.isNew) {
        api = `${process.env.VUE_APP_API}/api/${vm.click}/admin/${vm.belongModal}/${vm.item.id}`
        method = 'put'
      }
      this.$http[method](api, {
        data: vm.item
      }).then((response) => {
        console.log('build' + vm.belongModal + 'success', response)
        if (response.data.success) {
          $('#FloatModal').modal('hide')
        } else {
          console.log('build' + vm.belongModal + 'failed, try again')
          vm.$bus.$emit('message:push', response.data.message, 'danger')
          $('#FloatModal').modal('hide')
        }
        this.$emit('get-items')
      })
    },
    uploadFile () {
      const datafile = this.$refs.files.files[0]
      const vm = this
      const formData = new FormData()
      vm.status.fileLoading = true
      formData.append('file-to-uploads', datafile)
      const api = `${process.env.VUE_APP_API}/api/${vm.click}/admin/upload`
      this.$http.post(api, formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then((response) => {
        console.log('uploadFile', response)
        if (response.data.success) {
          vm.$set(vm.item, 'image', response.data.imageUrl)
        } else {
          console.log('uploadFile failed, try again')
          vm.$bus.$emit('message:push', response.data.message, 'danger')
        }
        vm.status.fileLoading = false
      })
    }
  }
}
</script>
