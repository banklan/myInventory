<template>
    <div class="stocks">
        <sales-nav></sales-nav>
        <div class="main_wrap">
            <div v-if="stocks.length > 0">
                <h4 class="text-center">All stocks</h4>
                <div class="stock_table">
                    <table class="table table-condensed table-responsive table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Product Id</th>
                                <th>Name</th>
                                <th>Colour</th>
                                <th>Price per unit</th>
                                <th>Units in Stock</th>
                                <th>Stock Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in stocks" :key="item.id">
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.colour }}</td>
                                <td>{{ item.sellin_price }}</td>
                                <td>{{ item.total_in_stock | toThousandth }}</td>
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
            <div v-else class="alert alert-danger">
                <p>No stocks at the moment</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            stocks: [],
            isDanger: false
        }
    },
    mounted() {
        axios.get('/get_allstocks').then((res) => {
            console.log(res.data)
            this.stocks = res.data
        })
    },
}
</script>

<style lang="scss">
    .main_wrap{
        margin: 3rem auto;

        table{
            background: #fff;

            th{
                text-align: center;
            }
            td{
                text-align: center;

                .status{
                    height:2rem;
                    width:2rem;
                    border-radius: 50%;
                    display: inline-block;
                }
                .healthy{
                    background: #12c312;
                }
                .warning{
                    background: #ffe24a;
                }
                .danger{
                   background: #ff1c1c;
                }
            }
            
        }
    }
</style>
