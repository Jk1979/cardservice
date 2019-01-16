<template>
  <div id="app">
    <div class="container-fluid">
    <div class="row">
        <router-link to="/" class="btn btn-success route-link">Список карт</router-link>
        <router-link to="/add" class="btn btn-success">Добавить карту</router-link>
    </div>
    <div class="row">
       <router-view></router-view>
    </div>
    </div>
    
  </div>
</template>

<script>
export default {
  name: 'app',
  data () {
    return {
      
    }
  },
   created(){
      
  },
  methods:{
    
  }
}
</script>

<style>

</style>
