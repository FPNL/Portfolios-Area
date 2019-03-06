import Vue from 'vue'
Vue.prototype.$bus = new Vue()

// Alert.vue
// 自定義名稱 'messsage:push'
// vm.$bus.$emit('message:push', message, status);
// message(String): 傳入參數，訊息內容
// status(String): Alert樣式，預設值為 warning

// productModal.vue
// 自定義名稱 'addCart'
// vm.$bus.$emit('addCart', id);
// id(String): 傳入參數，產品ID

// cartList.vue
// 自定義名稱 'getCart'
// vm.$bus.$emit('getCart')
// 無參數
