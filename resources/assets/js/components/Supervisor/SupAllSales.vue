<template>
   <div class="supervisor_wrap">
        <supervisor-nav></supervisor-nav>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="sup_main">
                        <div class="top_strip form-horizontal">
                            <div class="form-group">
                                <label class="control-label">By Batch</label>
                                <div>
                                    <select class="form-control" v-model="view.batch">
                                        <option selected disabled value="">- Select Batch -</option>
                                        <option v-for="batch in batches" :key="batch.id" :value="batch.batch">{{ batch.batch }}</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" @click.prevent="viewBatch" :disabled="loading"><i v-if="!loading" class="fa fa-filter"></i>{{ loading ? 'Filtering...' : ' Filter' }}</button>
                            </div>
                            <div class="form-group">
                                <label class="control-label">By User</label>
                                <div>
                                    <select class="form-control" v-model="view.user">
                                        <option selected disabled value="">- Select User -</option>
                                        <option v-for="user in users" :key="user.user_id" :value="user.user_id">{{ user.user_id }}</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" :disabled="loading" @click.prevent="viewByUser"><i v-if="!loading" class="fa fa-filter"></i>{{ loading ? 'Filtering...' : ' Filter' }}</button>
                            </div>
                            <div class="form-group">
                                <label class="control-label">By Product</label>
                                <div>
                                    <input type="text" class="form-control" v-model="view.product" @keyup.enter="viewByProduct">
                                </div>
                                <button class="btn btn-primary" :disabled="loading" @click.prevent="viewByProduct"><i v-if="!loading" class="fa fa-filter"></i>{{ loading ? 'Filtering...' : ' Filter' }}</button>
                            </div>
                            <div class="form-group today">
                                <button class="btn btn-default" type="button" @click="showToday">Today sales</button>
                            </div>
                        </div>
                        <div class="stock_table">
                            <div v-if="viewTable">
                                <h4 class="text-center">{{ tableTitle }}</h4>
                                <div class="sales_tables" v-if="sales.length > 0">
                                    <table class="table table-condensed table-responsive table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Item Id</th>
                                                <th>Batch</th>
                                                <th>Item</th>
                                                <th>Units Sold</th>
                                                <th>price</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="sale in sales" :key="sale.id">
                                                <td class="center">{{ sale.id }}</td>
                                                <td>{{ sale.batch }}</td>
                                                <td>{{ sale.product.name }}</td>
                                                <td>{{ sale.units_sold }}</td>
                                                <td class="center">{{ sale.total_price | toCurrency }}</td>
                                                <td class="center"><button class="btn btn-info btn-sm" type="button" @click="showSale(sale)"><i class="fa fa-eye"></i> View</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="summary_table">
                                        <h4 class="text-center">Summary Table</h4>
                                        <table class="table table-condensed table-responsive table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Units Sold</th>
                                                    <th>Total Amount Sold</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ totalUnits }}</td>
                                                    <td>{{ totalAmount | toCurrency }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div v-if="!sales.length > 0">
                                    <p class="text-danger">No sales for the chosen criteria</p>
                                </div>
                            </div>
                            <div v-if="!viewTable">
                                <div class="alert alert-info">
                                    <p>Filter and view sales by batch, user or find an entry with the form using item name or id </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            AllSales: [],
            sales: [],
            batches: [],
            users: [],
            view: {
                batch: '',
                user: '',
                product: ''
            },
            viewTable: false,
            tableTitle: '',
            loading: false
        }
    },
    computed: {
        totalUnits(){
            let total = this.sales.map(item=>item.units_sold).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0);
            return total;
        },
        totalAmount(){
            let total = this.sales.map(item=>item.total_price).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0)
            return total;
        }
    },
    methods: {
        getSales(){
            axios.get('/sup_getsales').then((res) => {
                this.AllSales = res.data
            })
        },
        getBatches(){
            axios.get('/sup_getbatches').then((res) => {
                this.batches = res.data
            })
        },
        getUsers(){
            axios.get('/sup_getusers').then((res) => {
                this.users = res.data
            })
        },
        showToday(){
            axios.get('/sup_getsales_today').then((res) => {
                console.log(res.data)
                this.viewTable = true;
                this.sales = res.data
                this.tableTitle = "Today's sales"
            })
        },
        viewBatch(){
            if(this.view.batch !== ''){
                this.loading = true
                axios.post('/sup_findbatch', {
                    batch: this.view.batch
                }).then((res) => {
                    this.loading = false
                    this.viewTable = true;
                    this.sales = res.data
                    this.tableTitle = "Sales for Batch "+ this.view.batch
                })
            }
        },
        viewByUser(){
            if(this.view.user !== ''){
                this.loading = true;
                axios.post('/sup_findsalesbyuser', {
                    user: this.view.user
                }).then((res) => {
                    this.loading = false;
                    this.viewTable = true;
                    this.sales = res.data;
                    this.tableTitle = "Sales for User ID "+ this.view.user
                })
            }
        },
        viewByProduct(){
            if(this.view.product !== ''){
                axios.post('/sup_findsalesbyprod', {
                    product: this.view.product
                }).then((res) => {
                    console.log(res.data)
                    this.tableTitle = "Sales for Product "+ this.view.product
                    this.view.product = ''
                    this.loading = false;
                    this.viewTable = true;
                    this.sales = res.data;
                })
            }
        },
        showSale(sale){
            this.$router.push({path: '/supervisor/all_sales/' + sale.id})
        }
    },
    mounted() {
        this.getSales();
        this.getBatches()
        this.getUsers()
        // this.getProduct()
    },
}
</script>

<style lang="scss" scoped>
    .top_strip{
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;

        .form-group{
            flex: 1 1 48%;
            display: flex;
            justify-content: space-around;
        }
        .today button{
            padding: 6px 20px; 
        }
    }
    .stock_table{
        margin-top: 6rem;
    }
    .summary_table{
        margin-top: 4rem;
    }
</style>