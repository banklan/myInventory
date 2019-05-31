<template>
    <div class="cart" v-if="openBatch">
        <h4 class="text-center">Cart</h4>
        <table class="table table-responsive table-hover table-bordered table-condensed table-striped">
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Prod ID</th>
                    <th>Name</th>
                    <th>Unit Price</th>
                    <th>Unit(s)</th>
                    <th>Total Amount(&#8358;)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in carts" :key="index">
                    <td> {{ index + 1 }}</td>
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.unitCost }}</td>
                    <td>{{ item.unit }}</td>
                    <td>{{ item.totalCost }}</td>
                    <td class="text-center"><button class="btn btn-danger btn-sm" type="button" @click="delItem(item.id, index)"><i class="fa fa-trash"></i></button></td>
                </tr>
                <tr>
                    <th colspan="5" style="text-align:right">Total(&#8358;)</th>
                    <td>{{ Total }}</td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <div class="col-md-4 col-md-offset-4">
                <button class="btn btn-primary btn-block checkout" @click.prevent="checkout">Checkout</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            carts: [],
            openBatch: false
        }
    },
    computed: {
        getCart(){
            let cart = this.$store.getters.getCart
            this.carts = cart
        },
        Total(){
            let cart = this.carts
            let val = cart.map(item=>item.totalCost).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0)
            let total = val * 100  
            return val.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&, ')
        }
    },
    methods: {
        checkout(){
            axios.post('/sales_checkout', {
                sales: this.carts
            }).then((res) => {
                console.log(res.data)
                this.carts = ''
                this.$router.push({name: 'FrontSales'})
                this.$toasted.show('Sales completed!',
                {
                    type: 'success'
                })
                localStorage.removeItem('cart')
            })
        },
        delItem(item, index){
            if(confirm("Delete this item?")){
                this.$store.commit('remove_item', item)
                this.carts.splice(index, 1)
            }
        }
    },
    mounted() {
        // this.getCart

        let carts = JSON.parse(localStorage.getItem('cart'))

        this.carts = carts

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

<style>
    .cart .form-group{
        margin-top: 3rem;
    }
    .cart button.checkout{
        background: #9e57ec !important;
        border-color: #aa6cf7 !important;
        padding: 8px 15px !important;
    }
</style>
