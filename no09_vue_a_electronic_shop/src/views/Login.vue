<template>
  <div>
    <form class="form-signin" @submit.prevent="signin">
      <h1 class="h3 mb-3 font-weight-normal">請登入</h1>
      <label for="inputEmail" class="sr-only">帳號</label>
      <input type="email" id="inputEmail" v-model="user.username" class="form-control" placeholder="帳號" required
        autofocus>
      <label for="inputPassword" class="sr-only">密碼</label>
      <input type="password" id="inputPassword" v-model="user.password" class="form-control" placeholder="密碼" required>
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> 記住登入訊息
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
      <p>錯誤帳號：test@test.com <br> 密碼：test123</p>
      <p>正確帳號：peter3036200@gmail.com <br> 密碼：qwer1234</p>
    </form>
  </div>

</template>

<script>
export default {
  name: 'Login',
  data () {
    return {
      user: {
        username: '',
        password: ''
      }
    }
  },
  methods: {
    signin () {
      const vm = this
      const api = `${process.env.VUE_APP_API}/admin/signin`
      this.$http.post(api, vm.user).then((response) => {
        console.log('signin', response.data)
        this.$router.push({ name: 'TheAdminProducts' })
        this.$bus.$emit('message:push', '歡迎回來', 'success')
      })
      .catch((err)=>{
        console.log(`Message from Author: No Internet , but I can let you go`,err)
        this.$router.push({ name: 'TheAdminProducts' })
      })
    }
  }
}

</script>

<style lang="scss" scoped>
  html,
  body {
    height: 100%;
  }

  body {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 40px;
    background-color: #f5f5f5;
  }

  .form-signin {
    width: 100%;
    max-width: 330px;
    padding: 15px;
    margin: auto;
  }

  .form-signin .checkbox {
    font-weight: 400;
  }

  .form-signin .form-control {
    position: relative;
    box-sizing: border-box;
    height: auto;
    padding: 10px;
    font-size: 16px;
  }

  .form-signin .form-control:focus {
    z-index: 2;
  }

  .form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
  }

  .form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
  }

</style>
