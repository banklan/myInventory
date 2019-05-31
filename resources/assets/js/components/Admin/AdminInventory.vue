<template>
    <div class="admin_wrap">
       <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="breadcrumb"><router-link :to="{name: 'admin'}">Dashboard</router-link> > Stock & Inventory</div>
            <div class="select_stock form-horizontal">
                <div class="form-group">
                    <label class="control-label col-md-3" for="stock">Choose Stock</label>
                    <div class="col-md-4">
                        <select class="form-control" v-model="type">
                            <option selected disabled value="">- Choose Stock - </option>
                            <option value="0">Out Of Stock</option>
                            <option value="1">Almost Out Of Stock</option>
                            <option value="10">Healthy Stock</option>
                            <option value="4">All Stock</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-block" @click.prevent="fetchStock">fetch</button>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
            <div class="stock_table_wrap">
                <h4 class="text-center">{{ stockType }}</h4>
                <div class="stock_table" v-if="showTable">
                    <table class="table table-condensed table-responsive table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Product Id</th>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Price per unit</th>
                                <th>Units in Stock</th>
                                <th>Stock Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in stocks" :key="item.id">
                                <td class="center">{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.size }}</td>
                                <td class="center">{{ item.sellin_price }}</td>
                                <td class="center">{{ item.total_in_stock | toThousandth }}</td>
                                <td>
                                    <span v-if="item.status == 10"><span class="status healthy"></span></span>
                                    <span v-if="item.status == 1"><span class="status warning"></span></span>
                                    <span v-if="item.status == 0"><span class="status danger"></span></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            AllStocks: [],
            type: '',
            stocks: [],
            stockType: '',
            showTable: false
        }
    },
    methods: {
        fetchStock(){
            if(this.type == 0){
                let items = this.AllStocks.filter((item)=>
                    item.status == 0
                )
                this.stocks = items
                this.stockType = 'Out of Stock'
                this.showTable = true
            }
            else if(this.type == 1){
                let items = this.AllStocks.filter((item)=>
                    item.status == 1
                )
                this.stocks = items
                this.stockType = 'Almost Out of Stock'
                this.showTable = true
            }else if(this.type == 10){
                let items = this.AllStocks.filter((item)=>
                    item.status == 10
                )
                this.stocks = items
                this.stockType = 'Healthy Stock'
                this.showTable = true
            }else{
                this.stocks = this.AllStocks
                this.stockType = 'All Stock'
                this.showTable = true
            }
        }
    },
    mounted() {
         axios.get('/admin_getstock').then((res) => {
            this.AllStocks = res.data
        })
    },
}
</script>

<style lang="scss" scoped>   
    .stock_table_wrap h4{
        margin: 4rem auto;
    }
</style>
