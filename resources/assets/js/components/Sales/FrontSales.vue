<template>
    <div class="sales" v-if="openBatch">
        <sales-nav></sales-nav>
        <div class="main_wrap">
            <div class="form-group">
                <div class="col-md-10">
                    <input type="text" class="form-control" v-model="item" @keyup.enter="fetchItem">
                    <!-- <button class="btn btn-default" type="button" @click="fetchItem">Fetch</button> -->
                </div>
                <div class="col-md-2">
                    <button class="btn btn-pry" type="button" @click="fetchItem">Fetch</button>
                </div>
                <div style="clear:both"></div>
            </div>
            <div class="results" v-if="displayRez">
                <div class="fetch_table" v-if="products.length > 0">
                    <table class="table table-responsive table-hover table-bordered table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Size</th>
                                <th>Price(&#8358;)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="prod in products" :key="prod.id" @click="checkOut(prod)">
                                <td>{{prod.id}}</td>
                                <td>{{prod.name}}</td>
                                <td>{{prod.category && prod.category.name}}</td>
                                <td>{{prod.size}}</td>
                                <td>{{prod.sellin_price}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="alert alert-danger" v-else>
                    There are no products that matches your search
                </div>
            </div>
            <div class="form-group" v-if="cart">
                <div class="col-md-4 col-md-offset-4">
                    <button class="btn btn-primary btn-block" @click.prevent="showCart"><i class="fa fa-cart-plus"></i> Show Cart</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            item: '',
            displayRez: false,
            products: [],
            cart: [],
            openBatch: false,
        }
    },
    filters:{
        cost(value){
            let val = parseFloat(value / 100)
            return val.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&, ')
        }
    },
    computed: {
        getCart(){
            this.cart = this.$store.getters.getCart
            // console.log(this.cart)
        }
    },
    methods: {
        fetchItem(){
            if(this.item.trim() !== ''){
                this.displayRez = true
                axios.post('/sales_fetchitem', {
                    item: this.item
                }).then((res) =>{
                    if(res.data){
                        this.products = res.data
                        console.log(res.data)
                    }else{
                        this.resultTable = false
                    }
                })
            }
        },
        checkOut(prod){
            this.$router.push({path: '/frontsales_checkout/' + prod.id})
        },
        showCart(){
            this.$router.push({name: 'salesCart'})
        }
    },
    mounted() {
        this.getCart

        let cart = JSON.parse(localStorage.getItem('cart'))
        this.cart = cart

        axios.get('/get_batchstatus').then((res) => {
            if(res.data === 0){
                this.$router.push({name: 'SalesUserHome'})
            }else{
                this.openBatch = true
            }
        })
    },
}
</script>

<style lang="scss" scoped>
    .main_wrap{
        width: 100%;
        margin: 3rem auto;

        input{
            height: 4rem;
            border-radius: 12px;
        }

        table tbody tr:hover{
            cursor: pointer;
            background: #ddd;
            color: rgb(68, 68, 68);
        }

        .form-group:last-child{
            button .fa{
                margin-right: 1rem;
            }
        }
    }
</style>
