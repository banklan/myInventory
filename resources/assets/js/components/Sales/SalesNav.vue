<template>
    <div class="front_nav_wrap">
        <div class="batch">
            <!-- batch here -->
        </div>
        <div class="nav_menu">
            <ul class="nav navbar-nav">
                <li class="menu">
                    <router-link :to="{name:'FrontSales'}">Sales</router-link>
                </li>
                <li class="menu">
                    <router-link :to="{name:'FrontStocks'}">Stocks</router-link>
                </li>
                
                <li class="menu">
                    <router-link :to="{name:'FrontLogs'}">Logs</router-link>
                </li>
                <li class="menu">
                    <router-link :to="{name:'FrontSettings'}">Settings</router-link>
                </li>
            </ul>
        </div>
        <div class="user">
            <!-- <a href="">Sales - nnnnnnnnnn</a> -->
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
    .front_nav_wrap 
    {
        width: 100%;
        margin: 0 auto;
        height: 5rem;
        display: flex;
        justify-content: center;
        align-items: center;

        .batch{
            flex: 0 1 20%;
        }

        .nav_menu{
            flex: 1 1 60%;

            ul{
                width: 100%;
                height: 100%;
                margin: 0 auto;
                display: flex;
                justify-content: space-around;
                align-items: center;
                border-bottom: 1px solid #0a0aff;

                li{
                flex:auto;
                text-align: center; 

                    &:hover a{
                        color: var(--pry-col-red);
                        border-bottom: 2px solid var(--pry-col-red);
                        background: none;
                    }
                    
                    a{
                            color: #0a0aff;
                        }

                    a.exact-active, a.active{
                        color: var(--pry-col-red);
                        border-bottom: 2px solid var(--pry-col-red);
                    }
                }
            }
        }
        .user{
            flex: 0 1 20%;
        }
        
    } 
</style>
