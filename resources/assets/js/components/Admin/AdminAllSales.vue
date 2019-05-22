<template>
    <div class="admin_wrap">
       <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="breadcrumb"><router-link :to="{name: 'admin'}">Dashboard</router-link> > All Front Office Users</div>
            <div class="upper_strip">
                <button class="btn btn-primary" type="button" @click="openCreate"><i class="fa fa-plus"></i>Add New User</button>
                <div class="search_form">
                    <admin-search-form></admin-search-form>
                </div>
            </div>
            <modal name="create-new" height="auto" :draggable="true" :width="500">
                <div class="modal-header">
                    <h4 class="text-center">Create New User </h4>
                    <div v-if="createErr" class="alert alert-danger">
                        {{ createErrors }}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fullname" class="control-label col-md-8">Fullname</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="text" v-model="newUser.fullname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-8">Email Address</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" v-model="newUser.email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label col-md-8">Select Status</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <select class="form-control" v-model="newUser.status">
                                <option value="1">Enabled</option>
                                <option value="0">Not enabled </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 7rem">
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" v-model="newUser.password" placeholder="Password">
                        </div>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="confpswd" v-model="newUser.confpswd" placeholder="Confirm Password">
                        </div>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="createUser">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Creating...' : 'Create User' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelCreate">Cancel</button>
                </div>
            </modal>
            <modal name="edit-user" height="auto" :draggable="true" :width="500">
                <div class="modal-header">
                    <h4 class="text-center">Update User Details </h4>
                    <div v-if="EditErr" class="alert alert-danger">
                        {{ editErrors }}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fullname" class="control-label col-md-8">Fullname</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="text" v-model="editUser.fullname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-8">Email Address</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" v-model="editUser.email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="updateUser(user)">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? ' Saving Updates...' : 'Save' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelEdit">Cancel</button>
                </div>
            </modal>
            <h3 class="text-center">All Front Sales Users</h3>
            <div class="users_table">
                <div v-if="users.length === 0" class="alert alert-warning">
                    There are no users to display in your table
                </div>
                <table v-else class="table table-responsive table-bordered table-hover">
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
                        <tr v-for="(user, index) in users" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.full_name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.role_id }}</td>
                            <td>{{ user.created_at }}</td>
                            <td>
                                <button class="btn btn-info btn-sm" @click.prevent="openUser(user)"><i class="fa fa-eye"></i>View</button>
                                <button class="btn btn-primary btn-sm" @click.prevent="editUserDetails(user)"><i class="fa fa-pencil"></i>Edit</button>
                                <button class="btn btn-danger btn-sm" @click.prevent="delUser(user, index)"><i class="fa fa-trash"></i>Delete</button>
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
            users: [],
            newUser:{
                fullname: '',
                email: '',
                status: 0,
                password: '',
                confpswd: ''
            },
            loading: false,
            createErr: false,
            createErrors: '',
            EditErr: false,
            editErrors: '',
            editUser: {
                fullname: '',
                email: '',
                id: 0
            }
        }
    },
    methods: {
        openUser(user){
            this.$router.push({path: '/admin/front_office/' + user.id})
        },
        editUserDetails(user){
            this.$modal.show('edit-user')
            this.editUser.fullname = user.full_name
            this.editUser.email = user.email
            this.editUser.id = user.id
            console.log(user.role)
        },
        delUser(user, index){
            if(confirm("Do you want to delete this user? It is an unrecoverable action once done!")){
                axios.post('/admin_deleteuser/'+user.id, {
                    role: 1
                }).then((res) => {
                    console.log(res.data)
                    this.users.splice(index, 1)
                    this.$toasted.show('User Deleted!',
                    {
                        type: 'success'
                    })
                })
            }
        },
        openCreate(){
            this.$modal.show('create-new')
        },
        createUser(){
            this.loading = true
            if(this.newUser.fullname !== '' && this.newUser.email !== '' && this.newUser.status !== '' && this.newUser.password !== ''){
                if(this.newUser.password === this.newUser.confpswd){
                    axios.post('/create_user', {
                        fullname: this.newUser.fullname,
                        email: this.newUser.email,
                        status: this.newUser.status,
                        password: this.newUser.password
                    }).then((res) => {
                        this.loading = false;
                        this.$modal.hide('create-new')
                        this.users.push(res.data)
                        this.newUser=''
                        this.$toasted.show('New User Created!',
                        {
                            type: 'success'
                        })
                    }).catch((err) => {
                        this.loading = false
                        this.createErr = true;
                        this.createErrors = "Supervisor creation failed. Please try again"
                    })
                }else{
                    this.createErr = true
                    this.loading = false
                    this.createErrors = 'Password & confirm Password do not match'
                }
            }else{
                this.loading = false
                this.createErr = true;
                this.createErrors = "All fields must be filled"
            }
        },
        cancelCreate(){
            this.$modal.hide('create-new')
        },
        updateUser(){
            this.loading = true
            axios.post('/admin_updateusers/' + this.editUser.id,{
                role: 1,
                fullname: this.editUser.fullname,
                email: this.editUser.email,
            }).then((res) =>{
                console.log(res.data)
                this.loading = false
                this.getFrontSalesUsers()
                this.$modal.hide('edit-user')
                this.$toasted.show('User details updated!',
                {
                    type: 'success'
                })
            })
        },
        cancelEdit(){
            this.$modal.hide('edit-user')
        },
        getFrontSalesUsers(){
            axios.get('/getusers').then(res =>{
                if(res.data.length > 0){
                    this.users = res.data
                }
            })
        }
    },
    mounted() {
        this.getFrontSalesUsers()
    },
}
</script>

<style lang="scss">   
    
</style>
