<template>
    <div class="side">
        <ul id="nav">
            <li><a href="#">Users</a>
                <ul>
                    <li><a href="#">Admin</a></li>
                    <li><a href="#">Supervisors</a></li>
                    <li><a href="#">Inventory</a></li>
                    <li><a href="#">Sales</a></li>
                </ul>
            </li>
            <li><a href="#">Role</a></li>
            <li><a href="#">Stock</a></li>
            <li><a href="#">Status</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Sales</a></li>
        </ul>
    </div>
</template>

<style scoped>
    *{
        margin:0;
        padding: 0;
    }
    .side{
        margin: 50px;
        padding: 0;
        background-color: black;
    }
    #nav{
        margin: 0;
        padding: 0;
        float: left;
    }
    #nav li{
        list-style: none;
        background:#fff;
        width: 250px;
        border-bottom:1px solid #4d4d4d;
        transition: .4s all ease;
    }
    #nav li a{
        display: block;
        padding: 1.2rem;
        border-left: 4px solid #444;
        text-decoration: none;
        box-shadow: 4px 4px 5px #ccc;
        color: #555;
    }
    #nav li a:hover{
        border-left: 4px solid #069;
        background: #f8f8f8;
    }
    #nav li ul{
        display: none;
    }
    #nav li:hover ul{
        display: block;
        margin-left: 1.8rem;
    }
    #nav li:hover ul li{
        background: #fff;
    }
    #nav li:hover ul li a{
        color: #555;
    }
    #nav li:hover ul li a:hover{
        background: #222;
        border-left: 4px solid #900;
    }
</style>

