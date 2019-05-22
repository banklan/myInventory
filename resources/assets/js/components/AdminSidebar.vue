<template>
    <div class="sidebar_wrap">
       <h4><i class="fa fa-tachometer"></i><span>Admin Dashboard</span></h4> 
       <div class="dashboard_contents">
           <ul class="content_list nav">
               <li class="list-item"><router-link :to="{name: 'Roles'}" class="roles"> <i class="fa fa-briefcase"></i>Roles Management</router-link></li>
               <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#ProductsLinks" aria-expanded="false" :class="{'active': subIsActive('/products')}" role="button"><i class="fa fa-lock"></i>Products Management<i class="fa fa-caret-down" style="margin-left:2rem"></i></a>
                    <ul class="nav collapse" id="ProductsLinks" role="menu" aria-labelledby="dropdown">
                        <li class="dropdown_link"><router-link :to="{name: 'AdminProdCateg'}"><i class="fa fa-user"></i>Categories</router-link></li>
                        <li class="dropdown_link"><router-link :to="{name: 'AllProducts'}"><i class="fa fa-user"></i>Products</router-link></li>
                    </ul>
                </li>
               <li class="list-item"><router-link :to="{name: 'Inventory'}"> <i class="fa fa-tasks"></i>Inventory and Stock</router-link></li>
               <li class="list-item"><router-link :to="{name: 'AdminSales'}"> <i class="fa fa-tasks"></i>Sales</router-link></li>
               <li class="list-item"><router-link :to="{name: 'Settings'}"> <i class="fa fa-gear fa-spin"></i>Settings</router-link></li>
               <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="collapse" data-target="#dropdownLinks" aria-expanded="false" :class="{'active': subIsActive('/users')}" role="button"><i class="fa fa-group"></i>Users<i class="fa fa-caret-down" style="margin-left:2rem"></i></a>
                    <ul class="nav collapse" id="dropdownLinks" role="menu" aria-labelledby="dropdown">
                        <li class="dropdown_link"><router-link :to="{name: 'AllAdmins'}"><i class="fa fa-user"></i>Admin</router-link></li>
                        <li class="dropdown_link"><router-link :to="{name: 'AllSupervisors'}"><i class="fa fa-user"></i>Supervisors</router-link></li>
                        <li class="dropdown_link"><router-link :to="{name: 'AllSales'}"><i class="fa fa-user"></i>Sales</router-link></li>
                    </ul>
                </li>
           </ul>
       </div>
       <!-- <div class="test_links">
           <router-link :to="{name: 'Roles'}" tag="li" class-active="active">Roles Mgt</router-link>
       </div> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            routeName:'',
        }
    },
    methods: {
        subIsActive(input){
            const paths = Array.isArray(input) ? input : [input]
            return paths.some(path => {
                return this.$route.path.indexOf(path) === 0
            })
        }
    },
    mounted() {
        this.routeName = this.$route.name
         
    },
}
</script>

<style lang="scss" scoped>   
    .sidebar_wrap{
        h4{
            padding: 1.5rem 0 0 1.5rem;

            .fa{
                margin-right: 1rem;
            }
        }
        .dashboard_contents{

            .content_list{
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 2rem 0;
                list-style: none;

                a.active, a.exact-active{
                    background-color: #030546;
                    color: rgb(253, 228, 0);
                }

                a{
                    color: #fff;
                    display: block;
                    padding: 1.5rem;
                    text-decoration: none;

                    .fa{
                        margin-right: 2rem;
                    }

                    &:hover{
                        background: #030546;
                        color: rgb(253, 228, 0);
                    }
                }
                // li.dropdown-toggle ul li a.active li.dropdown-toggle a{
                //     background: orangered;
                //     color: rgb(253, 228, 0);
                // }
            }
        }
    }
    
</style>
