<template lang="pug">
#login-wrapper
    #loginBlock.inline
      #signIn
          h1 ВХОД
          form(@submit.prevent="login")
            input#email_row(type='email' required v-model="email"  placeholder='E-mail')
            input#pswd_row(type='password' required v-model="pswd"  placeholder='Пароль' autocomplete='off')
            a#remembePswd(href='') Забыли пароль?
            button(type="submit") Войти
    #presentaion.inline
</template>

<script>
import {AUTH_REQUEST} from '../store/actions/auth'

export default {
    name: 'login',
    data () {
      return {
        email: '',
        pswd: '',
      }
    },
    methods: {
      login: function () {
        const { email, pswd } = this
        this.$store.dispatch(AUTH_REQUEST, { email, pswd }).then(() => {
          this.$router.push('/feed')
        })
      }
    },
  }
</script>

<style lang="stylus" scoped>
</style>