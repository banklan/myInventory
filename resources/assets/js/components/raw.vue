<template>
    <div class="sidebar_wrap">
       <h4><i class="fa fa-tachometer"></i><span>Admin Dashboard</span></h4> 
       <div class="dashboard_contents">
           <ul class="content_list nav">
               <!-- <li class="list-item"><router-link :to="{name: 'all_users'}"><i class="fa fa-users"></i>Users Management</router-link></li> -->
               <li class="list-item"><a href="#"><i class="fa fa-users"></i>Users Management</a></li>
               <li class="list-item"><a href="#"><i class="fa fa-briefcase"></i>Roles Management</a></li>
               <li class="list-item"><a href="#"><i class="fa fa-database"></i>Database Management</a></li>
               <li class="list-item"><a href="#"><i class="fa fa-tasks"></i>Inventory and Stock</a></li>
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
    .sidebar_wrap li:hover ul{
        padding-left: 8px;
        // margin-left: -8px;
    }
     .sidebar_wrap .list-item:hover a{
        background: #d93600;
        color: rgb(255, 230, 0);
     }
    .sidebar_wrap li a{
        display: block;
        padding: 1.2rem;
        text-decoration: none;
        // box-shadow: 4px 4px 5px #ccc;
        color: rgb(194, 194, 194);
    }
    .sidebar_wrap li a:hover{
        // background: #020563;
        color: rgb(241, 240, 240);
        border-left: 1px solid  rgb(255, 230, 0);
    }
    li .fa{
        margin-right: 1.8rem;
    }
</style>








<template>
    <div class="sidebar_wrap">
       <h4><i class="fa fa-tachometer"></i><span>Admin Dashboard</span></h4> 
       <div class="dashboard_contents">
           <ul class="content_list nav">
               <!-- <li class="list-item"><router-link :to="{name: 'all_users'}"><i class="fa fa-users"></i>Users Management</router-link></li> -->
               <li class="list-item"><router-link :to="{name: 'UsersAll'}"><i class="fa fa-users"></i>Users Management</router-link></li>
               <li class="list-item"><router-link :to="{name: 'Roles'}"> <i class="fa fa-briefcase"></i>Roles Management</router-link></li>
               <li class="list-item"><router-link :to="{name: 'Tables'}"> <i class="fa fa-database"></i>Database Management</router-link></li>
               <li class="list-item"><router-link :to="{name: 'Inventory'}"> <i class="fa fa-tasks"></i>Inventory and Stock</router-link></li>
               <li class="list-item"><router-link :to="{name: 'Settings'}"> <i class="fa fa-gear fa-spin"></i>Settings</router-link></li>
               <li class="dropdown-toggle" data-toggle="collapse" data-target="#dropdownLinks" aria-expanded="false">Dropdown<i class="fa fa-caret-down" style="margin-left:2rem"></i>
                    <ul class="nav collapse" id="dropdownLinks" role="menu" aria-labelledby="dropdown">
                        <li class="dropdown_link"><i class="fa fa-user"></i>Dropdown 1</li>
                        <li class="dropdown_link"><i class="fa fa-user"></i>Dropdown 2</li>
                        <li class="dropdown_link"><i class="fa fa-user"></i>Dropdown 3</li>
                    </ul>
                </li>
           </ul>
       </div>
    </div>
</template>

<script>
export default {

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

                .list-item{
                    padding: 1.5rem 3rem;
                        
                    .fa{
                        margin-right: 2rem;
                    }

                    &:hover{
                        background: #030546;
                        color: #0eff14;
                        cursor: pointer;
                    }
                }
                // #dropdownLinks .dropdown_link:hover{
                //     background: #000123;
                //     color: #0eff14;
                //     cursor: pointer;
                //     margin-left:-3rem;
                //     margin-right:-3rem;
                // }
                // #dropdown_wrap li{
                //     background-color: lemonchiffon;
                // }
                
            }
        }
    }
</style>
