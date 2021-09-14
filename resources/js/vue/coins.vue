<template>
<div>
    <div v-if="currencies">
        <div class="nav"><h2 style="padding-top:40px">Crypto Galaxy</h2></div>
        <div v-for="currency in currencies" :key="currency.id">
            <div class="coin-container">
                <div class="coin-row">
                    <router-link
                        :to="{
                            name: 'coin',
                            params: {
                                currencies: currencies,
                                id: currency.id,
                                price: currency.current_price,
                                volume: currency.total_volume,
                                supply: currency.total_supply,
                                name: currency.name,
                                image: currency.image,
                                symbol: currency.symbol,
                                market_cap: currency.market_cap,
                                market_cap_rank: currency.market_cap_rank
                            }
                        }"
                    >
                        <div class="coin">
                            <img :src="`${currency.image}.png`" />
                            <h1>{{ currency.name }}</h1>
                            <p class="coin-symbol">{{ currency.symbol }}</p>
                        </div>
                    </router-link>

                    <div class="coin-data">
                        <p class="coin-price">{{ currency.current_price }} $</p>
                        <p class="coin-volume">{{ currency.total_volume }}</p>

                        <p class="coin-marketcap">
                            Market Cap: {{ currency.market_cap }} $
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  v-if="loading" class="loading">Loading&#8230;</div>
</div>    
</template>

<script>
export default {
    data: function() {
        return {
            currencies: []
        };
    },
    methods: {
        
        getList() {
            this.loading = true;
            axios
                .get("/api/")
                .then(response => {
                    this.currencies = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    created() {
        this.getList();
    }
};
</script>

<style scoped>

.nav {
    display: flex;
    justify-content: center;
    align-items: center;
}

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
    width: 900px;
}

.coin {
    display: flex;
    align-items: center;
    padding-right: 24px;

    min-width: 300px;
}

.coin h1 {
    font-size: 16px;
    width: 150px;
}

.coin img {
    height: 30px;
    width: 30px;
    margin-right: 10px;
}

.coin-symbol {
    text-transform: uppercase;
}

.coin-data {
    display: flex;
    text-align: right;
    justify-content: space-between;
    width: 100%;
}

.coin-price {
    width: 110px;
}

.coin-volume {
    width: 155px;
}

.coin-marketcap {
    width: 230px;
}

.coin-percent {
    width: 100px;
}

.red {
    color: #f00606;
}

.green {
    color: #11d811;
}
h2 {
    font-family: "Mr Dafoe";
    font-size: 3.5em;
    margin-top: -0.6em;
    color: white;
    text-shadow: 0 0 0.05em #fff, 0 0 0.2em #fe05e1, 0 0 0.3em #fe05e1;
    transform: rotate(-7deg);
}
</style>
