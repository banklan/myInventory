<template>
   <div class="supervisor_wrap">
        <supervisor-nav></supervisor-nav>
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="sup_main">
                        <div class="sup_card inventory">
                            <button type="button" class="btn btn-inventory btn-lg" @click.prevent="goInventory">Manage Inventories</button>
                        </div>
                        <div class="sup_card products">
                            <button type="button" class="btn btn-products btn-lg" @click.prevent="goProducts">Manage Products</button>
                        </div>
                        <div class="sup_card sales">
                            <button type="button" class="btn btn-sales btn-lg" @click.prevent="goSales">View Sales</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data() {
            return {
                
            }
        },
        methods: {
            goInventory(){
                this.$router.push({name:'SupAllStocks'})
            },
            goSales(){
                this.$router.push({name:'SupAllSales'})
            },
            goProducts(){
                this.$router.push({name:'SupAllProducts'})
            },
        },
    }
</script>

<style lang="scss">
    .sup_main{
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;

        .sup_card{
            flex: 0 1 31%;
            height: 30rem;
            border:1px solid #d8d8d8;
            border-radius: 6px;

            display: flex;
            justify-content: center;
            align-items: center;

            .btn-inventory{
                background: #fff900;;
                transition: all .4s;

                &:hover{
                    background: orange;
                    color: #fff;
                }
            }
            .btn-sales{
                background: #14c313;
                color: #fff;
                transition: all .4s;

                &:hover{
                    background: rgb(3, 153, 83);
                    color: #fff;
                }
            }
            .btn-products{
                background: #0945ec;
                color: #fff;               
                transition: all .4s;

                &:hover{
                    background: rgb(39, 37, 167);
                    color: #fff;
                }
            }
            // .inventory{
            //     height: 100%;
            //     width: 100%;
            //     background-image: linear-gradient(to bottom right, rgba(13, 146, 91, 0.86), rgba(27, 249, 116, 0.87)), url('../../../../../public/images/aisle.jpg');

            // }
            // .bckg{
            //     height: 100%;
            //     width: 100%;
            //     overflow: hidden;
            //     background-image: linear-gradient(to right bottom, red, yellow);
            // }
            
            // box-shadow: 5px 5px 5px rgba(110,120,120,.2);
        }
    }
    
</style>