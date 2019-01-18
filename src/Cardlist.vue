<template>
  <div id="app">
   <div class="col-md-12">
                <h2>Список карт:</h2>
                <div v-if="cards.length > 0" class="item-style" >
                    <table class="table table-striped">
                      <thead>
                        <tr>
                        <th>№</th>
                        <th @click="makeSort(1)">Серия</th>
                        <th @click="makeSort(2)">Номер карты</th>
                        <th @click="makeSort(3)">Дата создания</th>
                        <th @click="makeSort(4)">Активна до</th>
                        <th @click="makeSort(5)">Статус карты</th>
                        <th @click="makeSort(6)">Сумма</th>
                        <th @click="makeSort(7)">Количество покупок</th>
                        <th>Опции</th>
                        </tr>
                      </thead>
                        <tr v-for="(card, ind) in cards" :key="card[ind]">
                          <td width="30">{{ ind }}</td>
                          <td>{{ card.serie }}</td>
                          <td>{{ card.number }}</td>
                          <td>{{ card.created_at }}</td>
                          <td>{{ card.active_until }}</td>
                          <td>{{ card.status }}</td>
                          <td>{{ card.sum }}</td>
                          <td>{{ card.countorders }}</td>
                          <td>
                            <router-link :to="{ name: 'profile', params: { id: card.id, card: card } }" class="btn btn-warning router-link">Профиль</router-link>
                            <button type="button" class="btn btn-danger" @click="removeCard(card.id)">Удалить</button>
                            <span v-if="card.status == 'активирована'">
                            <button type="button" class="btn btn-info" @click="actvateCard(card.id,0)">Деактивировать</button>
                            </span>
                            <span v-else>
                            <button type="button" class="btn btn-info" @click="actvateCard(card.id,1)">Активировать</button>
                            </span>
                          </td>
                        </tr>
                    </table>
                </div>
            </div>
  </div>
</template>

<script>

export default {
  name: 'Cardlist',
  props: ['newcard'],
  data() {
    return {
       cards : [],
    }
  },
  
  computed:{
    
  },
  components: {
    
  },
  created(){
    
    this.getcards()

  },
  watch: {
    // эта функция запускается при любом изменении вопроса
    newcard: function (val) {
        let vm = this;
       console.log(val);
       vm.cards.push(val)
    }
  },
  methods: {
    actvateCard(id,n){
      axios.get('/main/activatecard',{ params: {id: id, num:n}})
      .then(
      data =>{
            this.getcards('serie');
            }
      )
      .catch(err=>{ console.log(err)})
    },
    makeSort(i){
      let sort ='serie';
      switch(i) {
        case 1:  sort = 'serie'; break;
        case 2:  sort = 'number'; break;
        case 3:  sort = 'created_at'; break;
        case 4:  sort = 'active_until'; break;
        case 5:  sort = 'status'; break;
        case 6:  sort = 'sum'; break;
        case 7:  sort = 'countorders'; break;
      }
      this.cards = [];
      this.getcards(sort);
    },
    getcards(sort = 'serie'){
      let self = this;
      let uri = '';
      this.cards=[];
      if(sort) {  uri = '?sort='+ sort}
      axios.get('/main/getcards',{ params: {sort: sort}})
      .then(
      data =>{
            let obj = data.data;
            for(let i in obj){
              
              self.cards.push(obj[i]);
            }
            }
      )
      .catch(err=>{ console.log(err)})
    },
    removeCard(id){
        if(confirm('Удалить?')){
          axios.get('/main/removecard',{ params: {id: id}})
           .then(
          data =>{
                  console.log(data)
                  
                  this.getcards('serie');
                }
          )
      .catch(err=>{ console.log(err)})
        }
    }
  }
  
  
}
</script>