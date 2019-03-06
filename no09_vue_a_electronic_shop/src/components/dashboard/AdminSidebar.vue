<template>
  <nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
      <h4 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span style="user-select: none">賣家管理</span>
        <a class="d-flex align-items-center text-muted" href="#">
          <span data-feather="plus-circle"></span>
        </a>
      </h4>
      <ul class="nav flex-column">
        <li class="nav-item active" @click='choose="product"'>
          <router-link :to='{ name: "TheAdminProducts"}' class="nav-link"  >
            <span data-feather="file" :class='{"text-danger": choose=="product"}' >商品登錄</span>
          </router-link>
        </li>
        <li class="nav-item" @click='choose="coupon"'>
          <router-link :to='{ name: "TheAdminCoupons"}' class="nav-link" >
            <span data-feather="shopping-cart" :class='{"text-danger": choose=="coupon"}' >優惠券登錄</span>
          </router-link>
        </li>
        <li class="nav-item" @click='choose="order"'>
          <router-link :to='{ name: "TheAdminOrders"}' class="nav-link">
            <span data-feather="users" :class='{"text-danger": choose=="order"}'>訂單收錄</span>
          </router-link>
        </li>
      </ul>
      <h4 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span style="user-select: none">模擬買家</span>
        <a class="d-flex align-items-center text-muted" href="#">
          <span data-feather="plus-circle"></span>
        </a>
      </h4>
      <ul class="nav flex-column mb-2">
        <li class="nav-item" @click='choose="eproduct"'>
          <router-link :to="{ name: 'TheAdminEmulateProdoucts' }" class="nav-link">
            <span data-feather="file-text" :class='{"text-danger": choose=="eproduct"}'>商品列表</span>
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'AdminSidebar',
  data () {
    return {
      choose: 'product'
    }
  }
}

</script>
