import VueRouter from 'vue-router'
import Dashboard from './views/Dashboard'
import StudentsIndex from './views/students/Index'
import InstructorsIndex from './views/instructors/Index'
import UsersIndex from './views/users/Index'
import DeansIndex from './views/deans/Index'

export const router = new VueRouter({
  mode: 'history',
  routes: [
      { path: '/', redirect: '/dashboard' },
      {
          path: '/dashboard',
          name: 'dashboard',
          component: Dashboard
      },
      {
        path: '/students',
        name: 'students',
        component: StudentsIndex
      },
      {
        path: '/instructors',
        name: 'instructors',
        component: InstructorsIndex
      },
      {
        path: '/users',
        name: 'users',
        component: UsersIndex
      },
      {
        path: '/deans',
        name: 'deans',
        component: DeansIndex
      }
  ],
})
