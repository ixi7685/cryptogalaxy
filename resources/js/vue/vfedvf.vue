<template>
    <div style="width:100%;height:100vh">
        <router-link :to="{ name: 'coins' }"> Back to assets</router-link>
        <span> Overview </span>
        <div v-if="$route.params.price > 10000"> VECEEEEEE</div>
        <div
            style="margin-top:100px; margin-left:100px;width:80%;height:300px;display:flex;justify-content:space-between"
        >
            <div style="margin-top:15px;margin-right:5px;">Name: {{ $route.params.id  }}</div>
             <div style="margin-top:15px;margin-right:5px;">Symbol: {{ $route.params.symbol}}</div>
             <div style="margin-top:15px;margin-right:5px;">Supply: {{ $route.params.supply}}</div>
             <div style="margin-top:15px;margin-right:5px;" >Cap: {{ $route.params.market_cap}} $</div>
             <div style="margin-top:15px;margin-right:5px;" >Rank: {{ $route.params.market_cap_rank }}</div>
            <div style="margin-top:15px;margin-right:5px;">
                Price: {{ $route.params.price }} $
            </div>
            <!-- <img style="width:50px;height:50px;" :src="`${$route.params.image }`" />
           <img style="width:50px;height:50px;" :src="`${coin.image.small}`" /> -->
        </div>

        <button id="show-modal" @click="showModal = true">Show Modal</button>
        <span> Price alert </span>
        <div>
               
            </div>

<div v-for="(alert , i) in alerts" :key="i" > 
  <div class='coin-container'>
     
      <div class='coin-row'>
        <div class='coin-data'>
          <div style="width:150px">{{alert.name}} </div>
          <div style="width:150px">{{alert.price}} $</div>
          <div style="width:40px"><button @click="edit(i)">Edit</button></div>
          <div style="width:49px"><button @click="removeItem(i)">Delete</button></div>
        </div>
      </div>
     </div> 
    </div>


<!--
    <div v-if="alert"> 

        <form  >
                    <p>
                        <label for="name">Name</label>
                        <input
                            id="name"
                            v-model="alert.name"
                            type="text"
                            name="name"
                        />
                    </p>

                    <p>
                        <label for="age">Price</label>
                        <input
                            id="price"
                            v-model="alert.price"
                            type="number"
                            name="age"
                            min="0"
                        />
                    </p>
                    <p>
                        <input @click="update" value="Submit" />
                    </p>
                </form>
    </div> -->

  <div  v-if="showModal" id="modal-template" >
     <transition name="modal">
        <div class="modal-mask" @click.stop="">
          <div class="modal-wrapper">
            <div class="modal-container">
                
                 <form>
                    <div v-if="alert">

                         <p>
                        <label for="name">Name</label>
                        <input
                            id="name"
                            v-model="alert.name"
                            type="text"
                            name="name"
                        />
                    </p>

                    <p>
                        <label for="age">Price</label>
                        <input
                            id="price"
                            v-model="alert.price"
                            type="number"
                            name="age"
                            min="0"
                        />
                    </p>
                    
                    </div>
                    <div v-else>
                        <p>
                        <label for="name">Name</label>
                        <input
                            id="name"
                            v-model="name"
                            type="text"
                            name="name"
                        />
                    </p>

                    <p>
                        <label for="age">Price</label>
                        <input
                            id="price"
                            v-model="price"
                            type="number"
                            name="age"
                            min="0"
                        />
                    </p>
                    </div>
                    <p>
                        <button @click="showModal = false">Cancel</button>
                        <button @click="checkForm"> Submit </button>
                    </p>
                </form>

               

            </div>
          </div>
        </div>
      </transition>
 </div>

     </div>
</template>

<script>
export default {
    data: function() {
        return {
            alerts: [],
            name:'',
            price:'',
            alert:'',
            currentKey:'',
            showModal: false
        };
    },
    methods: {
        getCoin() {
            console.log(this.$route.params.id);
            axios
                .get(`api/${this.$route.params.id}`)
                .then(response => {
                    console.log(response);
                    console.log(1)
                     this.alerts = response.data;
                    

                })
               .catch(error => {
                    console.log(error);
                });
        },

        edit(i){
            this.showModal = true;
            this.currentKey = i
            console.log(i);
                 axios
                .post(`api/${this.$route.params.id}/${i}/edit`, {
                    i:i
                })
                .then(response => {
                    console.log(response);
                     this.alert = response.data;
                    

                 console.log(this.alert);
                })
                .catch(error => {
                    console.log(error);
                });
            },

        update(){
                 axios.post(`api/${this.$route.params.id}/${this.currentKey}/update`, {
                    id: this.currentKey,
                    name:this.alert.name,
                    price:this.alert.price
                })
                .then ( response => {

                    if( response.status == 200) {
                        console.log(1);
                        this.currentKey = ''
                        this.alert =''

                        this.getCoin();
                    }
                })
                .catch ( error  => {

                    console.log(error)

                })
            },
            removeItem(i){
                this.currentKey = i
                axios.delete(`api/${this.$route.params.id}/${this.currentKey}/delete`, {
                    currentKey: this.currentKey
                })
                .then( response => {

                        if (response.status == 200) {
                            this.getCoin();
                        }
                })
                .catch ( error => {
                    console.log( error )
                } )
            },


        checkForm(){
            this.showModal = false;
            axios.post(`api/${this.$route.params.id}/store`, {
                name : this.name,
                price : this.price
            })
            .then( response => {
                if( response.status == 200){
                    this.name = ""; 
                    this.price = ""; 

                    this.getCoin();
                    
                }
            })
            .catch ( error => {
                console.log( error )
            })
        }
    },
    created() {
        this.getCoin();
       
    }
};
</script>

<style>

.coin-container {
  display: flex;
  justify-content: center;
}

.coin-row {
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: center;
  height: 80px;
  border-bottom: 1px solid #d7d7d7;
  width: 400px;
}

.coin-data {
  display: flex;
  text-align: right;
  justify-content: space-between;
  width: 100%;
}

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}


</style>

