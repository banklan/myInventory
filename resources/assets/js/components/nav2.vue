<template>
    <div class="sidebar_wrap">
       <h4><i class="fa fa-tachometer"></i><span>Admin Dashboard</span></h4> 
       <div class="dashboard_contents">
           <ul class="content_list nav">
               <!-- <li class="list-item"><router-link :to="{name: 'all_users'}"><i class="fa fa-users"></i>Users Management</router-link></li> -->
               <li :class="route == 'UsersAll' ? ' active': ''" class="list-item"><router-link :to="{name: 'UsersAll'}"><i class="fa fa-users"></i>Users Management</router-link></li>
               <li :class="route == 'Roles' ? ' active': ''" class="list-item"><router-link :to="{name: 'Roles'}"><i class="fa fa-briefcase"></i>Roles Management</router-link></li>
               <li :class="route == 'Inventory' ? ' active': ''" class="list-item"><router-link :to="{name: 'Inventory'}"><i class="fa fa-database"></i>Database Management</router-link></li>
               <li :class="route == 'Settings' ? ' active': ''" class="list-item"><router-link :to="{name: 'Settings'}"><i class="fa fa-tasks"></i>Inventory and Stock</router-link></li>
               <li class="list-item"><a href="#"><i class="fa fa-gear fa-spin"></i>Settings</a></li>
               <li class="dropdown-toggle" data-toggle="collapse" data-target="#dropdownLinks" aria-expanded="false"><a href="#">Dropdown<i class="fa fa-caret-down" style="margin-left:2rem"></i></a>
                    <ul class="list-item nav collapse" id="dropdownLinks" role="menu" aria-labelledby="dropdown">
                        <li class="dropdown_link"><a href="#"><i class="fa fa-user"></i>Dropdown 1</a></li>
                        <li class="dropdown_link"><a href="#"><i class="fa fa-user"></i>Dropdown 2</a></li>
                        <li class="dropdown_link"><a href="#"><i class="fa fa-user"></i>Dropdown 3</a></li>
                    </ul>
                </li>
           </ul>
       </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            route: ''
        }
    },
    mounted() {
        this.route = this.$route.name
    },
}
</script>

<style lang="scss" scoped>   
    *{
        margin: 0;
        padding: 0;
    }
    .sidebar_wrap{
        background: #000123;
        width: 25%;
        height:100vh;
        margin-top: -2.5rem;
    }
    .sidebar_wrap li a{
        color: #fff;
        padding: 1.5rem;
        display: block;
        text-decoration: none;
    }
    .sidebar_wrap a .fa{
        margin-right: 1.8rem;
    }
    .sidebar_wrap li a:hover{
        background: #d93600;
    }
    .sidebar_wrap .dropdown-toggle ul li:hover .dropdown-toggle{
        background: #d93600;
    }
    .active{
        background: #d93600;
    }
    .router-link-exact-active{
        background: #d93600;
    } 
    .router-link-active{
         background: #d93600;
    }
</style>
