import Vue from 'vue'
import Router from 'vue-router'

import Home from './views/Home.vue'
import TheHomeProducts from '@/components/homeModal/TheHomeProducts.vue'
import TheHomeCheckOut from '@/components/homeModal/TheHomeCheckOut.vue'

import Login from './views/Login.vue'

import Admin from './views/Admin.vue'
import TheAdminProducts from '@/components/dashboard/main/TheAdminProducts.vue'
import TheAdminCoupons from '@/components/dashboard/main/TheAdminCoupons.vue'
import TheAdminOrders from '@/components/dashboard/main/TheAdminOrders.vue'
import TheAdminEmulateProdoucts from '@/components/dashboard/main/TheAdminEmulateProdoucts.vue'
import TheAdminCheckOut from '@/components/dashboard/main/TheAdminCheckOut.vue'

Vue.use(Router)

export default new Router({
  // mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '*',
      redirect: '/home'
    },
    {
      path: '/',
      name: 'Home',
      component: Home,
      children: [
        {
          path: 'home',
          name: 'TheHomeProducts',
          component: TheHomeProducts
        },
        {
          path: 'cart',
          name: 'TheHomeCheckOut',
          component: TheHomeCheckOut
        }
      ]
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/admin',
      name: 'Admin',
      component: Admin,
      children: [
        {
          path: 'products',
          name: 'TheAdminProducts',
          component: TheAdminProducts,
          meta: { requiresAuth: true }
        },
        {
          path: 'coupons',
          name: 'TheAdminCoupons',
          component: TheAdminCoupons,
          meta: { requiresAuth: true }
        },
        {
          path: 'orders',
          name: 'TheAdminOrders',
          component: TheAdminOrders,
          meta: { requiresAuth: true }
        },
        {
          path: 'eproducts',
          name: 'TheAdminEmulateProdoucts',
          component: TheAdminEmulateProdoucts
        },
        {
          path: 'check',
          name: 'TheAdminCheckOut',
          component: TheAdminCheckOut
        }
      ]
    }
  ]
})
