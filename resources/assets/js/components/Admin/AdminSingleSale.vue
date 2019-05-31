<template>
    <div class="admin_wrap">
        <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="topbar"><a href="#" @click.prevent="$router.go(-1)" title="Back"><i class="fa fa-arrow-circle-left"></i><span>Back </span></a></div>
            
            <div class="sale_wrap">
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
            axios.get('/admin_getsale/' + this.id).then((res) => {
                this.sale = res.data
                console.log(res.data)
            })
        }
    },
    mounted() {
        this.getSale()
    },
}
</script>

<style lang="scss" scoped>
    .sale_wrap{
        padding: 2rem;
        margin: 1.5rem auto;

        tr{
            height: 4rem;
            display: flex;
            border-bottom: 1px solid #cecece;

            th{
                flex: 1 1 30%;
            }

            td{
                flex: 1 1 70%;
            }
        }
    }
</style>
