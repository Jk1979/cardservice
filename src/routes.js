import Cardlist from './Cardlist.vue'
import Cardadd from './Cardadd.vue'
import Cardprofile from './Cardprofile.vue'

export const routes = [
  {
    path : '/',
    component: Cardlist,
    name: 'cards',
    props: true
  },
  {
    path : '/add',
    component: Cardadd
  },
  {
    name: 'profile',
    path: '/profile/:id', 
    component: Cardprofile,
    props: true
  }
  
]; 