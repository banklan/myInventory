<template>
    <div class="checkout" v-if="openBatch">
        <div class="top_strip">
            <a @click.prevent="$router.go(-1)" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
        <table class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th>Prod Id</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Size</th>
                    <th>Colour</th>
                    <th>Unit Price (&#8358;)</th>
                    <th>Dispense Unit</th>
                    <th>Amount(&#8358;)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ prod.id }}</td>
                    <td>{{ prod.name }}</td>
                    <td>{{ prod.category && prod.category.name }}</td>
                    <td>{{ prod.size }}</td>
                    <td>{{ prod.colour }}</td>
                    <td>{{ prod.sellin_price }}</td>
                    <td><input type="number" min="1" v-model="unit" @blur="calcPrice"></td>
                    <td>{{ totalAmount }}</td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <div class="col-md-4 col-md-offset-2">
                <button class="btn btn-primary btn-block" :disabled="clicked" type="button" @click="addToCart">Add to cart & continue</button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-danger btn-block" type="button" @click="clear">Clear</button>
            </div>
            <div style="clear: both"></div>
        </div>
        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <button class="btn btn-success btn-block btn-lg" type="button" @click="checkout">CheckOut</button>
            </div>
        </div>
        {{ getCat }}
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            prod: {},
            unit: null,
            totalAmount: '',
            cart: {},
            clicked: true,
            openBatch: false
        }
    },
    computed: {
        getCat(){
            let cart = this.$store.getters.getCart
            localStorage.setItem('cart', JSON.stringify(cart))
        }
    },
    methods: {
        calcPrice(){
            this.totalAmount = this.unit * this.prod.selling_price / 100
            this.clicked = false
        },
        getProduct(){
            axios.get('/get_product/' + this.id).then((res) =>{
                this.prod = res.data
            })
        },
        clear(){
            this.unit = null
            this.totalAmount = null
        },
        addToCart(){
            this.clicked = true
            this.cart.name = this.prod.name
            this.cart.id = this.prod.id
            this.cart.unitCost = this.prod.sellin_price
            this.cart.price = this.prod.selling_price
            this.cart.unit = this.unit
            this.cart.totalCost = this.totalAmount
            this.$store.commit('add_to_cart', this.cart)
            this.$toasted.show('Added to cart!',
            {
                type: 'success'
            })
            this.$router.push({name: 'FrontSales'})
        },
        checkout(){
            // this.clicked = true
            if(this.unit !== '' && this.totalAmount !== ''){
                this.cart.name = this.prod.name
                this.cart.id = this.prod.id
                this.cart.unitCost = this.prod.sellin_price
                this.cart.price = this.prod.selling_price
                this.cart.unit = this.unit
                this.cart.totalCost = this.totalAmount
                this.$store.commit('add_to_cart', this.cart)
                this.$router.push({name: 'salesCart'})
            }else{
                this.$router.push({name: 'salesCart'})
            }
        }
    },
    mounted() {
        this.getProduct();

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

<style lang="scss">
    .top_strip{
        margin-bottom: 3rem;
    }
    table td input{
        width: 100%;
        padding: 2px;
        box-sizing: border-box;
        border: none;
        background: #f5f8fa;

        &:focus{
            outline: none;
        }
    }
    .form-group:not(:last-child){
        margin-top: 3rem;
    }
    .form-group:last-child{
        margin-top: 3rem;
    }
</style>
