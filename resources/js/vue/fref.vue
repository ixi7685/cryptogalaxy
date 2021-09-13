<template>
    <div
        style="width:100%;height:100vh;display:flex;flex-direction:column;align-items:center"
    >
        <div
            style="width:100%;display:flex;flex-direction:column;align-items:center"
        >
            <div style="width:100%;">
                <router-link :to="{ name: 'coins' }">
                    <font-awesome-icon icon="backward" /> Back to assets
                </router-link>
            </div>

            <div style="width:45%">
                <h4>Overview</h4>
            </div>
            <div
                style="margin-top:20px; margin-left:100px;width:50%;height:100px;display:flex;justify-content:space-between"
            >
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

        <div
            style="margin-top:50px;width:100%;display:flex;flex-direction:column;align-items:center"
        >
            <div style="width:45%">
                <div style="display:flex;justify-content:space-between">
                    <h4> Price Alerts</h4>

                    <div id="show-modal" @click="showModal = true" style="margin-top:15px">
                        <font-awesome-icon icon="plus-square" /> New price alert
                    </div>
                </div>
            </div>

            <div v-for="(alert, i) in filteredAlerts" :key="i">
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
                            <div @click="edit(i)" style="width:100px">
                                <font-awesome-icon icon="edit" />
                            </div>
                            <div @click="removeItem(i)" style="width:100px">
                                <font-awesome-icon icon="trash" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="background:red; color:white;margin-top:25px;width:250px;height:150px;padding:10px;display:flex;flex-direction:column;justify-content:flex-start;align-items:center;padding:20px" v-if="elementVisible">
             <div> <font-awesome-icon icon="bell"/> </div>
                 <div>  {{$route.params.name}} just pass alert price </div>
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
                                            Price Alert
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
                                               
                                                required
                                            />
                                        </div>
                                        <div
                                            style="display:flex;justify-content:space-between"
                                        >
                                            <button
                                                style="background:red;color:white;height:30px;border-radius: 1px;"
                                                @click="refresh"
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                style="background:green;color:white;height:30px;border-radius: 1px;"
                                                @click="update"
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
                                            Price Alert
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
                                                placeholder="Place"
                                                required
                                            />
                                        </div>

                                        <div
                                            style="display:flex;justify-content:space-between"
                                        >
                                            <button
                                                style="background:red;color:white;height:30px;border-radius: 1px;"
                                                @click="showModal = false"
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                style="background:green;color:white;height:30px;border-radius: 1px;"
                                                @click="checkForm"
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
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            alerts: [],
            name: "",
            price: "",
            alert: "",
            currentKey: "",
            showModal: false,
            elementVisible: false,
            filteredAl: "",
            symbol:""
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
                })
                .catch(error => {
                    console.log(error);
                });
        },

        edit(i) {
            this.showModal = true;
            this.currentKey = i;
            console.log(i);
            axios
                .post(`api/${this.$route.params.id}/${i}/edit`, {
                    i: i
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

        update() {

            if(this.price == ''){
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
                        console.log(1);
                        this.currentKey = "";
                        this.alert = "";
                        this.getCoin();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            
        },
        removeItem(i) {
        
            this.currentKey = i;
            if(confirm("Do you really want to delete?")){
            axios
                .delete(`api/${this.currentKey}/delete`, {
                    id: this.currentKey
                })
                .then(response => {
                    if (response.status == 200) {
                        this.getCoin();
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            }    
        },

        checkForm() {

            
            
            if(this.price == ''){
                return;
            } else {
                
            }
            this.showModal = false;
            
                axios
                .post(`api/${this.$route.params.id}/store`, {
                    name: this.$route.params.name,
                    price: this.price
                })
                .then(response => {
                    if (response.status == 200) {
                        
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
        getAlertPrices(){
          return Object.entries(this.alerts)  
        }
    },

    computed: {
        filteredAlerts: function() {
            
            let store = [this.$route.params.name];

            const result = Object.entries(this.alerts).filter(([k, v]) => store.some(s => s == v.name));

            return Object.fromEntries(result);

        },
        detail:function() {
            if (this.$route.params.price > 200) {
                this.elementVisible = true;
            } else {
                this.elementVisible = false;
            }
        },
    },
    created() {
        this.getCoin();
        this.SymbolToUpperCase();
      //  this.detail();
       
        setTimeout(() => {
         this.getAlertPrices();
      }, 200);
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
    width: 500px;
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
    height: 300px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: whitesmoke;
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

input {
    width: 100%;
    border: 1px solid black;
    border-radius: 4px;
    padding: 15px;
    margin-top: 15px;
    margin-bottom: 15px;
}

label {
    color: black;
}
</style>
