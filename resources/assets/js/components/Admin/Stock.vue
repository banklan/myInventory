<template>
    <div class="admin_wrap">
        <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="breadcrumb"><router-link :to="{name: 'admin'}">Dashboard</router-link> > All Stock</div>
           
            <div class="stock_wrap">
                <div v-if="stocks.length > 0">
                    <h4 class="text-center">All stocks</h4>
                    <div class="stock_table">
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
                <div v-else class="alert alert-danger">
                    <p>No stocks at the moment</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            stocks: []
        }
    },
    mounted() {
        // get stock
        axios.get('/admin_getstock').then((res) => {
            this.stocks = res.data
        })
    },
}
</script>

<style lang="scss" scoped>
    // .stock_table{
    //     background: #fff;

    //     table{
    //         th{
    //             text-align: center;
    //         }
    //         tr .center{
    //             text-align: center;
    //         }
    //         td{
    //             text-align: center;
    //             .status{
    //                 height:2rem;
    //                 width:2rem;
    //                 border-radius: 50%;
    //                 display: inline-block;
    //             }
    //             .healthy{
    //                 background: #12c312;
    //             }
    //             .warning{
    //                 background: #ffe24a;
    //             }
    //             .danger{
    //                background: #ff1c1c;
    //             }
    //         }
    //     }
    // }
</style>
