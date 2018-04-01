import VueRouter from 'vue-router'
import Dashboard from './views/Dashboard'
import StudentsIndex from './views/students/Index'
import InstructorsIndex from './views/instructors/Index'
import UsersIndex from './views/users/Index'
import DeansIndex from './views/deans/Index'
import SettingsIndex from './views/settings/Index'
import RequestsIndex from './views/requests/Index'
import ActivitiesIndex from './views/activities/Index'
import ExamSchedulesIndex from './views/exam-schedules/Index'

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
      },
      {
        path: '/settings',
        name: 'settings',
        component: SettingsIndex
      },
      {
        path: '/requests',
        name: 'requests',
        component: RequestsIndex
      },
      {
        path: '/activities',
        name: 'activities',
        component: ActivitiesIndex
      },
      {
        path: '/exam-schedules',
        name: 'exam-schedules',
        component: ExamSchedulesIndex
      }
  ],
})
