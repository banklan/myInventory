<template>
    <div class="nav_wrap">
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="menu dropdown" :class="{'linkActive': stockRoute}">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                        Manage Stocks <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                       <li><router-link :to="{name: 'SupAllStocks'}">View</router-link> </li>
                       <!-- <li><router-link :to="{name: 'SupNewStock'}">Add New</router-link> </li> -->
                    </ul>
                </li>
                <li class="menu dropdown" :class="{'linkActive': productRoute}">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                        Manage Products <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><router-link :to="{name: 'SupAllProducts'}">View</router-link> </li>
                        <li><router-link :to="{name: 'SupNewProd'}">Add New</router-link> </li>
                    </ul>
                </li>
                <li class="menu">
                    <router-link :to="{name:'SupAllSales'}">Sales</router-link>
                </li>
                 <li class="menu">
                    <router-link :to="{name:'SupSettings'}">Settings</router-link>
                </li>
                <!-- <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                        Another Link <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><router-link :to="{name: 'SupStock'}">Sub Link2</router-link> </li>
                        <li><router-link :to="{name: 'SupStock'}">Sub Link2 New</router-link> </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <router-link>Extra Link</router-link>
                </li> -->
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            stockRoute: false,
            productRoute: false
        }
    },
    beforeRouteEnter (to, from, next) {
        this.currentRoute = to
        next()
    },
    mounted() {
        if(this.$route.name === 'SupAllStocks' || this.$route.name === 'SupNewStock'){
            this.stockRoute = true
        }
        if(this.$route.name === 'SupAllProducts' || this.$route.name === 'SupNewProd'){
            this.productRoute = true
        }
    },
}
</script>

<style lang="scss">
    .nav_wrap{
        #app-navbar-collapse{
            margin: 1rem 6rem;

            .navbar-nav{
                width: 60%;
                display: flex;
                justify-content: space-around;
                align-items: center;
                margin: 0 auto;

                .linkActive > a{
                    color: red;
                }

                .linkActive ul > li > a.exact-active, ul li a.active{
                    color: red;
                }

                li a.active, li a.exact-active{
                    color: red;
                }
            }
        }
    }
</style>
