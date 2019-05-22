<template>
    <div class="admin_wrap">
       <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="topbar"><a href="#" @click.prevent="$router.go(-1)" title="Back"><i class="fa fa-arrow-circle-left"></i><span>Back </span></a></div>
            <div v-if="users.length === 0" class="alert alert-warning"> 
                there are no results to show at the moment
            </div>
            <div v-else class="result_table">
                <h4>Search result for <strong>"{{ $route.query.q }}" {{ users.length }}</strong></h4>
                <table class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>User Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td style="text-align:center">{{ user.id }}</td>
                            <td>{{ user.full_name }}</td>
                            <td>{{ user.email }}</td>
                            <td style="text-align:center">{{ user.role_id }}</td>
                            <td>{{ user.created_at }}</td>
                            <td style="text-align:center">
                                <button class="btn btn-info btn-sm" @click.prevent="openUser(user)"><i class="fa fa-eye"></i>View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: []
        }
    },
    methods: {
        openUser(user){
            if(user.role_id == 1){
                this.$router.push({path: '/admin/front_office/' + user.id})
            }else if(user.role_id == 2){
                this.$router.push({path: '/admin/supervisor/' + user.id})
            }else if(user.role_id == 7){
                this.$router.push({path: '/admin/admins/' + user.id})
            }
        },
    },
    mounted() {
        if(this.$route.params.result){
            this.users = this.$route.params.result
        }else{
            this.users = JSON.parse(localStorage.getItem('searchResult'))
        }
        
    },
}
</script>

<style lang="scss" scoped>   
    .alert{
        margin: 2rem;
    }
    .result_table{
        margin: 2rem;

        h4{
            padding: 1.5rem 0;
        }
        th{
            text-align: center;
        }
    }
</style>
