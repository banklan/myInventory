<template>
    <div class="main_wrap">
        <div class="mgmt all_users">
            <span class="icon"><i class="fa fa-users"></i></span>
            <h5>You have 1 Admin, 1 supervisor and 3 users</h5>
            <router-link :to="{name: 'all_users'}" class="btn btn-pry">View all users</router-link>
        </div>
        <div class="mgmt inventory">
            <span class="icon"><i class="fa fa-tasks"></i></span>
            <h5>You have 3 roles</h5>
            <router-link :to="{name: 'all_users'}" class="btn btn-pry">View all users</router-link>
        </div>
        <div class="mgmt tables">
            <span class="icon"><i class="fa fa-database"></i></span>
            <h5>You have 5 tables</h5>
            <router-link :to="{name: 'all_users'}" class="btn btn-pry">View all users</router-link>
        </div>
    </div>
</template>

<script>
export default {
    

}
</script>

<style lang="scss" scoped>
    .main_wrap{
        height: 100vh;
        padding: 2rem;
        display: flex;
        justify-content: space-around;
        align-items: space-around;
        flex-wrap: wrap;

        .mgmt{
            flex: 0 1 28%;
            border:1px solid #cecece;
            border-radius: 4px;
            height: 30rem;
            margin-top: 2rem;

            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;

            .h5{
                padding: 15px;
            }

            .icon{
                height:6rem;
                width: 6rem;
                border-radius: 50%;
                border: 1px solid #228b22;

                display: flex;
                justify-content: center;
                align-items: center;

                .fa{
                    font-size: 34px;
                    color: #228b22;
                }
            }
        }
    }
</style>
