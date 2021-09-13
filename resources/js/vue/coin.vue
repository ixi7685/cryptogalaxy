<template>
    <div style="width:100%;height:100vh;display:flex;flex-direction:column;align-items:center">
        <div style="width:100%;display:flex;flex-direction:column;align-items:center">
            <div style="width:100%;">
                <router-link :to="{ name: 'coins' }">
                    <font-awesome-icon icon="backward" /> Back to assets
                </router-link>
            </div>
            <div style="margin-top:20px; margin-left:100px;width:50%;height:100px;display:flex;justify-content:space-between">
                <img
                    style="width:50px;height:50px;"
                    :src="`${$route.params.image}`" 
                /> 
                 <div style="margin-top:15px;margin-right:25px;">
                    {{ $route.params.name}}({{this.symbol}})
                </div>
                <div style="margin-top:15px;margin-right:5px;">
                    Supply: {{ $route.params.supply }}
                </div>
                <div style="margin-top:15px;margin-right:5px;">
                    Cap: {{ $route.params.market_cap }} $
                </div>
                <div style="margin-top:15px;margin-right:5px;">
                    Rank: {{ $route.params.market_cap_rank }}
                </div>
                <div style="margin-top:15px;margin-right:5px;">
                    Price: {{ $route.params.price }} $
                </div>
            </div>
        </div>

        <div style="margin-top:50px;width:100%;display:flex;flex-direction:column;align-items:center">
            <div style="width:45%">
            <div style="display:flex;justify-content:space-between">
            <h4> Price Alerts</h4>
            <div style="border: 1px solid black; color:black;width:400px;height:60px;padding:10px;display:flex;flex-direction:column;justify-content:flex-start;align-items:center"  v-if="elementVisible">
             <font-awesome-icon icon="bell"/>  {{$route.params.name}} pass your alert price
            </div> 
            <div id="show-modal" @click="showModal = true" style="margin-top:20px">
                <font-awesome-icon icon="plus-square" /> New price alert
            </div>
            </div>
            </div>
            <div v-for="(alert, key) in filteredAlerts" :key="key">
                <div class="coin-container">
                    <div class="coin-row">
                        <div class="coin-data">
                            <div style="display:flex;width:300px">
                                <img
                                style="width:20px;height:20px;margin-right:5px"
                                :src="`${$route.params.image}`"
                            />
                            <div> 1 {{ $route.params.name}}({{symbol}}) </div>  <span style="margin-left:5px;margin-right:5px"> > </span>  <div>{{ alert.price }} $</div>
                            </div>
                            <div @click="edit(key)" style="width:100px">
                                <font-awesome-icon icon="edit" />
                            </div>
                            <div @click="removeItem(key)" style="width:100px">
                                <font-awesome-icon icon="trash" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" id="modal-template">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-container">
                            <form>
                                <div v-if="alert">
                                    <div>
                                        <div
                                            style="display:flex;justify-content:center;color:black;font-size:18px"
                                        >
                                            <h6>Crypto Galaxy</h6>
                                        </div>
                                        <div>
                                            <label style="color:black"
                                                >Name</label
                                            >
                                            <input
                                                id="name"
                                                v-model="$route.params.name"
                                                type="text"
                                                name="name"
                                                placeholder="Name"
                                                disabled

                                            />
                                        </div>

                                        <div>
                                            <label style="color:black"
                                                >Price</label
                                            >
                                            <input
                                                id="price"
                                                v-model="alert.price"
                                                type="number"
                                                name="price"
                                                min="1" 
                                                placeholder="Enter price"
                                                required
                                            />
                                        </div>
                                        <div
                                            style="display:flex;justify-content:space-between"
                                        >
                                            <button
                                                style="background:white;color:black;height:30px;border:1px solid black"
                                                @click="refresh"
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                style="background:white;color:black;height:30px;border:1px solid black"
                                                @click="update(alert.price)"
                                            >
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div>
                                        <div
                                            style="display:flex;justify-content:center;color:black;font-size:18px"
                                        >
                                            <h6>Crypto Galaxy</h6>
                                        </div>
                                        <div>
                                            <label for="name">Name</label>
                                            <input
                                                id="name"
                                                v-model="$route.params.name"
                                                type="text"
                                                name="name"
                                                placeholder="Name"
                                                disabled
                                            />
                                        </div>

                                        <div>
                                            <label for="age">Price</label>
                                            <input
                                                id="price"
                                                v-model="price"
                                                type="number"
                                                name="price"
                                                min="1" 
                                                placeholder="Enter price"
                                                required
                                            />
                                        </div>

                                        <div
                                            style="display:flex;justify-content:space-between"
                                        >
                                            <button
                                                style="background:white;color:black;height:30px;border:1px solid black"
                                                @click="showModal = false"
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                style="background:white;color:black;height:30px;border:1px solid black"
                                                @click="addAlert"
                                            >
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div  v-if="loading" class="loading">Loading&#8230;</div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            minimumPriceAlert:'',
            alerts: [],
            name: "",
            price: "",
            alert: "",
            currentKey: "",
            showModal: false,
            elementVisible: false,
            symbol:"",
            loading:false
        };
    },
    methods: {
        refresh() {
            this.showModal = false;
            this.alert = "";
        },

        getCoin() {
            console.log(this.$route.params.id);
            axios
                .get(`api/${this.$route.params.id}`)
                .then(response => {
                    this.alerts = response.data;
                    this.loading = false;
                    this.alertMinPrice()
                })
                .catch(error => {
                    console.log(error);
                });
        },

        edit(key) {
            this.showModal = true;
            this.currentKey = key;
            axios
                .post(`api/${this.$route.params.id}/${this.currentKey}/edit`, {
                    key : this.currentKey
                })
                .then(response => {
                    this.alert = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        update(price) {
            if(price == ''){
                return;
            }
            this.showModal = false;

            axios
                .post(
                    `api/${this.$route.params.id}/${this.currentKey}/update`,
                    {
                        id: this.currentKey,
                        name: this.alert.name,
                        price: this.alert.price
                    }
                )
                .then(response => {
                    if (response.status == 200) {
                        this.currentKey = "";
                        this.alert = "";
                        this.showSpinner();
                        this.getCoin();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        removeItem(key) {
            this.currentKey = key;
            if(confirm("Do you really want to delete?")){
            axios
                .delete(`api/${this.currentKey}/delete`, {
                    id: this.currentKey
                })
                .then(response => {
                    if (response.status == 200) {
                        this.showSpinner();
                        this.getCoin();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            }    
        },

        addAlert() {
            if(this.price == ''){
                return;
            }
            this.showModal = false;
            
            axios
                .post(`api/${this.$route.params.id}/store`, {
                    name: this.$route.params.name,
                    price: this.price
                })
                .then(response => {
                    if (response.status == 200) {
                        
                        this.showSpinner();
                        this.name = "";
                        this.price = "";
                        this.getCoin();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        closeModal() {
            this.showModal = false;
        },
        SymbolToUpperCase(){

            this.symbol = this.$route.params.symbol.toUpperCase()
        },
        showSpinner(){
            this.loading = true;
        }
    },

    computed: {
        filteredAlerts: function() {

            let store = [this.$route.params.name];

            const result = Object.entries(this.alerts).filter(([k, v]) => store.some(s => s == v.name));
            
            var prices = []

            result.forEach(item =>{
                item.forEach(it => {

                    if(it.price){
                        prices.push(parseInt(it.price))
                    }
                    
                })
            })

            this.minimumPriceAlert = Math.min(...prices);

             if (this.$route.params.price > this.minimumPriceAlert) {
                this.elementVisible = true;
            } else {
                this.elementVisible = false;
            }

            return Object.fromEntries(result);

        },
    },
    created() {
        this.getCoin();
        this.SymbolToUpperCase();
        this.loading = true;
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
    height: 400px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
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

input {
    width: 100%;
    border: 1px solid black;
    padding: 15px;
    margin-top: 15px;
    margin-bottom: 15px;
}

label {
    color: black;
    font-size:21px
}
h6 {
    font-family: "Mr Dafoe";
    font-size: 1em;
    color: black;
    text-shadow: 0 0 0.05em #fff, 0 0 0.2em #fe05e1, 0 0 0.3em #fe05e1;
    transform: rotate(-3deg);
}
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0, .8));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.8), rgba(0, 0, 0,.8));
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 150ms infinite linear;
  -moz-animation: spinner 150ms infinite linear;
  -ms-animation: spinner 150ms infinite linear;
  -o-animation: spinner 150ms infinite linear;
  animation: spinner 150ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
