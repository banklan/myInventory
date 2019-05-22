<template>
    <div class="admin_wrap">
        <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="breadcrumb"><router-link :to="{name: 'admin'}">Dashboard</router-link> > Users Table</div>
            <div class="choose_users">
                <div class="choose_form">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="user_table">Choose User Table</label>
                            <div class="col-md-4">
                                <select class="form-control" v-model="role">
                                    <option selected value="">Choose Role</option>
                                    <option value="1">Users</option>
                                    <option value="2">Supervisor</option>
                                    <option value="7">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-pry" type="button" @click.prevent="showUsers">Show Users</button>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </form>
                </div>
                <div class="create_user">
                    <form class="form-horizontal">
                        <button class="btn btn-primary" type="button" @click.prevent="openCreate"><i class="fa fa-plus"></i>Create new User</button>
                    </form>
                </div>
            </div>
            <modal name="create-user" height="auto" :draggable="true" :width="450">
                <div class="modal-header">
                    <h4 class="text-center">Create new user </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fullname" class="control-label col-md-8">FullName</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="name" v-model="newUser.fullname" v-validate="'required|max:60'">
                            <div v-show="errors.has('name')">
                                <div class="validation">
                                    {{ errors.first('name') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-8">Email Address</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" v-model="newUser.email" v-validate="'required|email'">
                            <div v-show="errors.has('email')">
                                <div class="validation">
                                    {{ errors.first('email') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role" class="control-label col-md-8">User Role</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <select class="form-control" v-model="newUser.role" name="role" v-validate="'required'">
                                <option value="" selected disabled>Choose role</option>
                                <option value=1>Front Office User</option>
                                <option value=2>Supervisor</option>
                                <option value=7>Admin</option>
                            </select>
                            <div v-show="errors.has('role')">
                                <div class="validation">
                                    {{ errors.first('role') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label col-md-8">Status</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <select class="form-control" name="status" v-model="newUser.status" v-validate="'required'">
                                <option value="" selected disabled>Choose status</option>
                                <option value=1>Enabled</option>
                                <option value=0>Disabled</option>
                            </select>
                            <div v-show="errors.has('status')">
                                <div class="validation">
                                    {{ errors.first('status') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label col-md-8">Password</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="password" ref="password" v-model="newUser.password" v-validate="'required|min:5|max:20'" data-vv-as="new password">
                            <div v-show="errors.has('password')">
                                <div class="validation">
                                    {{ errors.first('password') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confPswd" class="control-label col-md-8">Confirm Password</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="confPswd" v-model="newUser.confPswd" v-validate="'required|confirmed:password'" data-vv-as="confirm password">
                            <div v-show="errors.has('confPswd')">
                                <div class="validation">
                                    {{ errors.first('confPswd') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="createUser">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Creating user...' : 'Create User' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelUpdate">Cancel</button>
                </div>
            </modal>
            <div class="users_table" v-if="queryTables">
                <div v-if ="!showTable" class="alert alert-warning">
                    <p>You have no users for this table</p>
                </div>
                <div v-if="showTable">
                    <h4>{{ tableTitle }} <span class="badge">{{ users.length }}</span></h4>
                </div>
                <table class="table table-responsive table-bordered table-hover" v-if="showTable">
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
                            <td>{{ user.id }}</td>
                            <td>{{ user.full_name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.role_id }}</td>
                            <td>{{ user.created_at }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" @click.prevent="openUser(user)"><i class="fa fa-eye"></i>View</button>
                                <button class="btn btn-primary btn-sm" @click.prevent="editUser(user)"><i class="fa fa-pencil"></i>Edit</button>
                                <button class="btn btn-danger btn-sm" @click.prevent="delUser(user)"><i class="fa fa-trash"></i>Delete</button>
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
    data(){
        return{
            role: 0,
            queryTables: false,
            showTable: false,
            users: [],
            newUser: {
                fullname: '',
                email: '',
                role: '',
                status: '',
                password: '',
                confPswd: ''
            },
            loading: false,
            tableTitle: ''
        }
    },
    methods: {
        showUsers(){
            this.queryTables = true
            if(this.role !== ''){
                if(this.role == 7){
                    this.getAdmins()
                }else if(this.role == 1){
                    this.getUsers()
                }else if(this.role == '2'){
                    this.getSupervisors()
                }
            }
        },
        getAdmins(){
            axios.get('/getadmins').then(res =>{
                if(res.data.length > 0){
                    this.users = res.data
                    this.showTable = true
                    this.tableTitle = 'All Admins'
                }
            })
        },
        getUsers(){
            axios.get('/getusers').then(res =>{
                if(res.data.length > 0){
                    this.users = res.data
                    this.showTable = true
                    this.tableTitle = 'All Front Office Users'
                }
            })
        },
        getSupervisors(){
            axios.get('/getallsupervisors').then(res =>{
                if(res.data.length > 0){
                    this.users = res.data
                    this.showTable = true
                    this.tableTitle = 'All Supervisors'
                }
                // console.log(res.data)
            })
        },
        openUser(user){
            if(user.role_id == 1){
                this.$router.push({path: '/admin/front_office/' + user.id})
            }else if(user.role_id == 2){
                this.$router.push({path: '/admin/supervisor/' + user.id})
            }else if(user.role_id == 7){console.log(user)
                this.$router.push({path: '/admin/admins/' + user.id})
            }
        },
        openCreate(){
            this.$modal.show('create-user')
        },
        createUser(){
            this.$validator.validateAll().then(() =>{
                if(!this.errors.any() || !this.errors.has('confPswd')){
                    // this.loading = true
                    if(this.newUser.role == 1){
                        axios.post('/create_newuser', {
                            user: this.newUser
                        }).then((res)=> {
                            console.log(res.data)
                            this.hideCreate();
                            this.$toasted.show('User created successfully!',
                            {
                                type: 'success'
                            })
                        })
                    }else if(this.newUser.role == 2){
                        axios.post('/create_newsupervisor', {
                            user: this.newUser
                        }).then((res)=> {
                            console.log(res.data)
                            this.hideCreate();
                            this.$toasted.show('Supervisor created successfully!',
                            {
                                type: 'success'
                            })
                        })
                    }else if(this.newUser.role == 7){
                        axios.post('/create_newadmin', {
                            user: this.newUser
                        }).then((res)=> {
                            console.log(res.data)
                            this.hideCreate();
                            this.$toasted.show('User created successfully!',
                            {
                                type: 'success'
                            })
                        })
                    }
                }
            })
        },
        hideCreate(){
            this.$modal.hide('create-user');
            this.newUser = {}
        }
    },
}
</script>

<style lang="scss" scoped>
    .choose_users{
        margin-top: 3rem;
        // padding: 2rem;
        width: 100%;

        display: flex;
        justify-content: space-between;

        .choose_form{
            flex: 1 1 60%;
        }
        .create_user{
            flex: 1 1 40%;
            text-align: center;

            .fa{
                margin-right: 1rem;
            }
        }
    }
    .modal-body .form-group{
        margin-bottom: 5.5rem;
    }
    .users_table{
        margin: 1.5rem 4rem;

        h4{
            padding: 1.5rem 2.5rem;
        }

        td .fa{
            margin-right: 1rem;
        }

        .badge{
            background-color: #0bafe0;
        }
    }
</style>
