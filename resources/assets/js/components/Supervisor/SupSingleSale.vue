<template>
    <div class="supervisor_wrap">
        <supervisor-nav></supervisor-nav>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="sup_main">
                        <div class="top_strip_single">
                            <a href="#" @click.prevent="$router.go(-1)" title="Back"><i class="fa fa-arrow-circle-left"></i><span>Back </span></a>
                        </div>
                        <div class="prod_wrap">
                            <table class="table table-condensed table-responsive table-hover">
                                <tr>
                                    <th>Sale ID:</th>
                                    <td>{{ sale.id }}</td>
                                </tr>
                                <tr>
                                    <th>Product Name: </th>
                                    <td>{{ sale.product && sale.product.name }}</td>
                                </tr>
                                <tr>
                                    <th>Product Category: </th>
                                    <td>{{ sale.product && sale.product.category.name }}</td>
                                </tr>
                                <tr>
                                    <th>Unit Price((&#8358;): </th>
                                    <td>{{ sale.unit_price | toCurrency}}</td>
                                </tr>
                                <tr>
                                    <th>Units Sold: </th>
                                    <td>{{ sale.units_sold }}</td>
                                </tr>
                                <tr>
                                    <th>Cost of Units sold(&#8358;): </th>
                                    <td>{{ sale.total_price | toCurrency }}</td>
                                </tr>
                                <tr>
                                    <th>Batch: </th>
                                    <td>{{ sale.batch }}</td>
                                </tr>
                                <tr>
                                    <th>User: </th>
                                    <td>{{ sale.user_id }}</td>
                                </tr>
                            </table>
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
            id: this.$route.params.id,
            sale: {}
        }
    },
    methods: {
        getSale(){
            axios.get('/sup_getsale/' + this.id).then((res) => {
                this.sale = res.data
            })
        }
    },
    mounted() {
        this.getSale()
    },
}
</script>

<style lang="scss">
    .prod_wrap{
        margin-top: 2rem;
        padding: 2rem;
        border: #ececec;
        border-radius: 6px;
        box-shadow: 0px 0px 7px 1px #b9b9b9db;
        background: #fff;

       tr{
            height: 4.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;

            th{
                flex: 0 1 30%;
            }
            td{
                flex: 1 1 70%;
            }
        } 

        .sup_btns{
            width: 30%;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
    }
</style>

           