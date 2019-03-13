import Vue from 'vue'
import Router from 'vue-router'
import User from './components/User'
import Home from './components/Home'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'user',
      component: User,
      meta: {
        login: true
      }
    },
    {
      path: '/home',
      name: 'home',
      component: Home,
      meta : {
        auth: true
      }
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.auth)) {
    if (localStorage.getItem('auth') === 'false') {
      next('/');
    } else {
      next();
    }
  } else if (to.matched.some(record => record.meta.login)) {
    if (localStorage.getItem('auth') === 'true') {
      next('/home')
    } else {
      next()
    }
  } else {
    next();
  }
})

export default router
