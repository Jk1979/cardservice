<template>
  <div id="app" class="card-add col-md-8">
    <form>
  <div class="form-group">
    <label for="serie">Серия карты</label>
    <input type="text" class="form-control" id="serie" v-model="card.serie" >
  </div>
  <div class="form-group">
    <label for="number">Номер карты</label>
    <input type="text" class="form-control" id="number" v-model="card.number" >
  </div>
 <div class="form-group">
    <label for="sum">Сумма на карте</label>
    <input type="text" class="form-control" id="sum" v-model="card.sum" >
  </div>
  <div class="form-group">
    <label for="sum">Статус</label>
    <select class="custom-select" v-model="card.status">
      <option value="1" selected="selected">Активирована</option>
      <option value="0">Не активирована</option>
    </select>
  </div>
  <button type="button" class="btn btn-primary" @click="addCard">Добавить карту</button>
</form>
   
  </div>
</template>

<script>
export default {
  name: 'Cardadd',
  props:{
     
  },
  data () {
    return {
       card: {}
    }
  },
  methods:{
    addCard(){
        let self = this;
      let data = JSON.stringify(this.card)
      axios.post('/main/addcard',{data:this.card})
      .then(data => {
        console.log(data.data);
            // self.cards.push = data.data; 
      }).catch(err=>{ console.log(err)})
      // eventBus.$emit("adddata", data.data);
      this.$router.push({name:'cards',params: { newcard: data.data }})
    }
  }
  
}
</script>
