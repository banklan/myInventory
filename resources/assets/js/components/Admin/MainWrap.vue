<template>
    <div class="main_wrap">
        <div class="mgmt all_users">
            <span class="icon"><i class="fa fa-users"></i></span>
            <h4 class="text-center">You have {{ admins.length | pluralize('Admin') }}, {{ sups.length | pluralize('supervisor') }} and {{ users.length | pluralize('user') }}</h4>
            <router-link :to="{name: 'all_users'}" class="btn btn-pry">View User</router-link>
        </div>
        <div class="mgmt inventory">
            <span class="icon"><i class="fa fa-tasks"></i></span>
            <h4>You have {{ products }} products</h4>
            <p v-if="stockOut.length > 0" class="text-center out">{{ stockOut.length | pluralize('product') }} is very low on stock</p>
            <p v-if="stockWarning.length > 0" class="text-center warn">{{ stockWarning.length | pluralize('product') }} stock requires attention</p>
            <router-link :to="{name: 'AdminStock'}" class="btn btn-pry">View Stock</router-link>
        </div>
        <div class="mgmt tables">
            <span class="icon"><i class="fa fa-database"></i></span>
            <h4 class="text-center">You have made {{ items | pluralize('sale') }} today worth &#8358;{{ total_sales | toCurrency }} </h4>
            <router-link :to="{name: 'all_users'}" class="btn btn-pry">View all sales</router-link>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            admins: '',
            sups: '',
            users: '',
            products: '',
            items: '',
            total_sales: '',
            stockOut: [],
            stockWarning: []
        }
    },
    mounted() {
        //get admins counts
        axios.get('/getadmins').then((res) => {
            this.admins = res.data 
        })

        //get sups counts
        axios.get('/getallsupervisors').then((res) => {
            this.sups = res.data
        })

        //get users counts
        axios.get('/getusers').then((res) => {
            this.users = res.data
        })

        //get all product counts
        axios.get('/admin_getproducts').then((res) => {
            this.products = res.data.length
            for(var i=0; i<res.data.length; i++){
                if(res.data[i].stock_out == true){
                    this.stockOut.push(res.data[i])
                }
                if(res.data[i].stock_warning == true){
                    this.stockWarning.push(res.data[i])
                }
            }
        })

        // get all sales today
        axios.get('/admin_getsales_today').then((res) => {
            this.items = res.data.length
            this.total_sales = res.data.map(item=>item.total_price).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0)
        })

        // get stock status
        axios.get('/admin_getstock_status').then((res) => {
            this.product = res.data
            console.log(res.data)
        })
    },

}
</script>

<style lang="scss" scoped>
    .main_wrap{
        height: 100vh;
        padding: 2rem;
        display: flex;
        justify-content: space-around;
        align-items: space-around;
        flex-wrap: wrap;

        .mgmt{
            padding: 1.5rem;
            box-sizing: border-box;
            flex: 0 1 30%;
            border:1px solid #06a21a;
            border-radius: 4px;
            height: 30rem;
            margin-top: 2rem;

            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;

            .h5{
                padding: 15px;
            }

            .icon{
                height:6rem;
                width: 6rem;
                border-radius: 50%;
                border: 1px solid #228b22;

                display: flex;
                justify-content: center;
                align-items: center;

                .fa{
                    font-size: 34px;
                    color: #228b22;
                }
            }
            p.out{
                color: #ff4d4a;
                font-weight: bold;
            }
            p.warn{
                color: #ffa700;
                // font-weight: bold;
            }
        }
    }
</style>
