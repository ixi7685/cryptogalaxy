<!--
<template>
    <div style="width:100%;height:100vh">
        <router-link :to="{ name: 'coins' }"> Back to assets</router-link>
        <span> Overview </span>
        <div
            style="margin-top:100px; margin-left:100px;width:80%;height:300px;display:flex;justify-content:space-between"
        >
            <div style="margin-top:15px;margin-right:5px;">
                Name: {{ $route.params.id }}
            </div>
            <div style="margin-top:15px;margin-right:5px;">
                Symbol: {{ $route.params.symbol }}
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
            <img style="width:50px;height:50px;" :src="`${coin.image.small}`" />
        </div>
        <span> Price alert </span>
       <!-- <div>
            <div>
                <form id="app" @onClick="checkForm">
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
                    <p>
                        <input type="submit" value="Submit" />
                    </p>
                </form>
            </div>
        </div>-->
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            coin: [],
            name:'',
            price:''
        };
    },
    methods: {
     /*   getCoin() {
            axios
                .get(`api/${this.$route.params.id}`)
                .then(response => {
                    console.log(response);
                    this.coin = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },*/

     /*   checkForm(){
            if( this.item.name == '' || this.item.price == '' ){
                return;
            }
            axios.post('api/price_alert/store', {
                name : this.name,
                price : this.price
            })
            .then( response => {
                if( response.status == 201){
                    this.name = ""; 
                    this.price = ""; 
                }
            })
            .catch ( error => {
                console.log( error )
            })
        }*/
    },
    created() {
      //  this.getCoin();
        console.log("coiiiiin");
    }
};
</script>

<style></style>
