<template>
  <div id="app" class="card-add col-md-8">
   <h2>Профиль карты</h2>
     <form>
      <div class="form-group">
        <label for="serie">Серия карты</label>
        <input type="text" class="form-control" id="serie" v-model="card.serie" disabled>
      </div>
      <div class="form-group">
        <label for="number">Номер карты</label>
        <input type="text" class="form-control" id="number" v-model="card.number" disabled>
      </div>
    <div class="form-group">
        <label for="sum">Сумма на карте</label>
        <input type="text" class="form-control" id="sum" v-model="card.sum" disabled>
      </div>
      <div class="form-group">
        <label for="status">Статус</label>
      <input type="text" class="form-control" id="status" v-model="card.status" disabled>
      </div>
</form>
   <h2>История покупок</h2>
   <table class="table table-striped">
    <thead>
      <tr>
      <th>Дата покупки</th>
      <th>Статус</th>
      <th>Стоимость</th>
      <th>Бонусы</th>
      </tr>
    </thead>
      <tr v-for="(ord, ind) in orders" :key="ord[ind]">
        <td>{{ ord.used_at }}</td>
        <td>{{ ord.status }}</td>
        <td>{{ ord.cost }}</td>
        <td>{{ ord.bonus }}</td>
        
      </tr>
  </table>
   
  </div>
</template>

<script>
export default {
  name: 'Cardprofile',
  props: ['id','card'],
  data () {
    return {
       
       orders:[]

    }
  },
  created(){
    this.getorders();
  },
  methods:{
    getorders(){
      let self = this;
     
      axios.get('/main/getorders',{ params: {id: this.id}})
      .then(
      data =>{
            console.log(data.data)
              self.orders = data.data;
            }
      )
      .catch(err=>{ console.log(err)})
    },
    getcard(){
      
    }
   
  }
  
}
</script>
