<template>
    <div class="supervisor_wrap">
        <supervisor-nav></supervisor-nav>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="sup_main">
                        <div class="top_strip">
                            <router-link :to="{name: 'SupAllStocks'}"><i class="fa fa-arrow-left"></i> Back</router-link>
                            <h4>Stock Search result for <strong>"{{ $route.query.q }}" - {{ products.length }} items </strong></h4>
                        </div>
                        <div class="stock_table" v-if="products.length > 0">
                            <table class="table table-responsive table-hover table-condensed table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Size</th>
                                        <th>Stock Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="prod in products" :key="prod.id">
                                        <td>{{ prod.id }}</td>
                                        <td>{{ prod.name }}</td>
                                        <td>{{ prod.category.name }}</td>
                                        <td>{{ prod.size }}</td>
                                        <td>{{ prod.totalUnits }}</td>
                                        <td><router-link :to="{path: '/supervisor/add_stock/' + prod.id}" class="btn btn-success">Add Stock</router-link></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                        <div v-if="!products.length > 0" class="alert alert-danger">
                            <p>There are no stocks that matched your search criteria</p>
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
            products: []
        }
    },
    methods: {
        getTotalUnits(rez){
            for (let i = 0; i < rez.length; i++) {
                let stocks = rez[i].stocks
                for(let j = 0; j < stocks.length; j++){
                    let totalUnits = stocks.map(item=>item.total_units).reduce((prev, next) => parseFloat(prev) + parseFloat(next))
                    // console.log(totalUnits)
                    rez[i].totalUnits = totalUnits
                }
            }
        },
    },
    mounted() {
        if(this.$route.params.result){
            this.products = this.$route.params.result
            this.getTotalUnits(this.products)
        }else{
            this.products = JSON.parse(localStorage.getItem('SupProdsearchResult'))
            this.getTotalUnits(this.products)
        }
    },
}
</script>

<style lang="scss" scoped>
    .supervisor_wrap .top_strip{
        width: 100%;
        height: 4rem;
        display: flex;
        justify-content: space-around;
        margin-bottom: 2rem;

        a{
            flex: 0 1 40%;
        }

        h4{
            flex: 0 1 60%;
        }
    }
</style>
