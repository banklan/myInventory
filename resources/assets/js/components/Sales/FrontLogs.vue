<template>
    <div class="logs" v-if="openBatch">
        <sales-nav></sales-nav>
        <div class="log_wrap">
            <div class="log_top">
               <h4>Sales {{ day }}</h4> 
               <div class="form-group">
                   <label for="batch" class="control-label">Choose batch</label>
                   <select class="form-control" v-model="batchDate">
                        <option v-for="batch in batches" :key="batch.id" :value="batch.batch">{{ batch.batch }}</option>
                    </select>
                    <button class="btn btn-primary btn-sm" @click="viewBatch">Go</button>
               </div>
            </div>
            
            <div class="sales_table">
                <div v-if="logs.length == 0" class="alert alert-danger">
                    <p>There are no transactions for the batch date</p>
                </div>
                <table v-if="!logs.length == 0" class="table table-condensed table-bordered table-responsive table-hovered">
                    <thead>
                        <tr>
                            <th>Transaction Id</th>
                            <th>product Id</th>
                            <th>Units Sold</th>
                            <th>Unit Price (&#8358;)</th>
                            <th>Total Cost (&#8358;)</th>
                            <th>Batch</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(sale) in logs" :key="sale.id">
                            <td>{{ sale.id }}</td>
                            <td>{{ sale.product_id }}</td>
                            <td>{{ sale.units_sold }}</td>
                            <td>{{ sale.unit_price | toCurrency}}</td>
                            <td>{{ sale.total_price | toCurrency }}</td>
                            <td>{{ sale.batch }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="batch_summary" v-if="logs.length > 0">
                <h4>Summary of Sales for {{ day }}</h4>
                <table class="table table-condensed table-bordered table-responsive table-hovered">
                    <thead>
                        <tr>
                            <th>No of Sales</th>
                            <th>Amount Sold (&#8358;)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ logs.length }} </td>
                            <td>{{ TotalSold | toCurrency }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            openBatch: false,
            logs:[],
            batches: [],
            batchDate: '',
            day: 'today',
            
        }
    },
    computed: {
        TotalSold(){
            let val = this.logs.map(item=>item.total_price).reduce((prev, next) => parseFloat(prev) + parseFloat(next), 0)
            // this.totalSold = val
            // console.log(val)
            return val
        }
    },
    methods: {
        getLogs(){
            axios.get('/get_userslog').then((res) => {
                // console.log(res.data)
                this.logs = res.data
            })
        },
        getBatch(){
            axios.get('/get_usersbatches').then((res)=>{
                this.batches = res.data
                console.log(res.data)
            })
        },
        viewBatch(){
            if(this.batchDate !== ''){
                axios.post('/get_batchsales', {
                    batch: this.batchDate
                }).then((res) => {
                    this.logs = res.data
                    this.day = this.batchDate
                })
            }
        },
        
    },
    mounted(){
        axios.get('/get_batchstatus').then((res) => {
            if(res.data === 0){
                this.$router.push({name: 'SalesUserHome'})
            }else{
                this.openBatch = true
            }
        })

        this.getLogs();
        this.getBatch()
    }
}
</script>

<style lang="scss">
    .log_wrap{
        margin: 1.5rem;
        padding: 1.5rem;
    }
    .log_top{
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-bottom: 1.5rem;

        h4{
            flex: 0 1 40%;
        }
        .form-group{
            flex: 0 1 60%;
            display: flex;
            justify-content: space-between;
            align-items: center;

            label{
                flex: 0 1 25%;
            }

            select{
                flex: 0 1 50%;
            }

            button{
                flex: 0 1 15%;
            }
        }
    }
    
    table th, table td{
        text-align: center;
    } 
    .batch_summary{
        margin-top: 4rem;
    }
</style>
