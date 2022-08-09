// import App from './App'
import Home from './components/HomeComponent'
import Profile from './components/ProfileComponent'
import Users from './components/UsersComponent'
import Login from './components/AuthComponent'

export const routes = [
  {
    path: '/profile',
    name: 'profile',
    component: Profile,
  },
  {
    path: '/home',
    name: 'Home',
    component: Home,
  },
  {
    path: '/users',
    name: 'Users',
    component: Users,
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
]

export default routes