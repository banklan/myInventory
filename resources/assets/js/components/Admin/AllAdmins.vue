<template>
    <div class="admin_wrap">
       <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="breadcrumb"><router-link :to="{name: 'admin'}">Dashboard</router-link> > All Admins</div>
            <div class="upper_strip">
                <button class="btn btn-primary" type="button" @click="openCreate"><i class="fa fa-plus"></i>Create New Admin</button>
                <div class="search_form">
                    <admin-search-form></admin-search-form>
                </div>
            </div>
            <modal name="create-new" height="auto" :draggable="true" :width="500">
                <div class="modal-header">
                    <h4 class="text-center">Create New Admin </h4>
                    <div v-if="createErr" class="alert alert-danger">
                        {{ createErrors }}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fullname" class="control-label col-md-8">Fullname</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="text" v-model="newAdmin.fullname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-8">Email Address</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" v-model="newAdmin.email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label col-md-8">Select Status</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <select class="form-control" v-model="newAdmin.status">
                                <option value="1">Enabled</option>
                                <option value="0">Not enabled </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 7rem">
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="password" v-model="newAdmin.password" placeholder="Password">
                        </div>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="confpswd" v-model="newAdmin.confpswd" placeholder="Confirm Password">
                        </div>
                        <div style="clear:both"></div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="createAdmin">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Creating Admin...' : 'Create Admin' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelCreate">Cancel</button>
                </div>
            </modal>
            <modal name="edit-admin" height="auto" :draggable="true" :width="500">
                <div class="modal-header">
                    <h4 class="text-center">Update Admin Details </h4>
                    <div v-if="EditErr" class="alert alert-danger">
                        {{ editErrors }}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fullname" class="control-label col-md-8">Fullname</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="text" v-model="editAdmin.fullname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-8">Email Address</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" v-model="editAdmin.email">
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="updateAdmin(user)">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? ' Saving Updates...' : 'Save' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelEdit">Cancel</button>
                </div>
            </modal>
            <h3 class="text-center">All Admininistrators</h3>
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
                                <button class="btn btn-primary btn-sm" @click.prevent="editUser(user)"><i class="fa fa-pencil"></i>Edit</button>
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
            newAdmin:{
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
            editAdmin: {
                fullname: '',
                email: '',
                id: 0
            }
        }
    },
    methods: {
        openUser(user){
            this.$router.push({path: '/admin/admins/' + user.id})
            this.previous = 'AllAdmins'
        },
        editUser(user){
            this.$modal.show('edit-admin')
            this.editAdmin.fullname = user.full_name
            this.editAdmin.email = user.email
            this.editAdmin.id = user.id
            console.log(user.role)
        },
        delUser(user, index){
            if(confirm("Do you want to delete this user? It is an unrecoverable action once done!")){
                axios.post('/admin_deleteuser/'+user.id, {
                    role: 7
                }).then((res) => {
                    console.log(res.data)
                    this.users.splice(index, 1)
                    this.$toasted.show('Admin Deleted!',
                    {
                        type: 'success'
                    })
                })
            }
        },
        openCreate(){
            this.$modal.show('create-new')
        },
        createAdmin(){
            this.loading = true
            if(this.newAdmin.fullname !== '' && this.newAdmin.email !== '' && this.newAdmin.status !== '' && this.newAdmin.password !== ''){
                if(this.newAdmin.password === this.newAdmin.confpswd){
                    axios.post('/create_admin', {
                        fullname: this.newAdmin.fullname,
                        email: this.newAdmin.email,
                        status: this.newAdmin.status,
                        password: this.newAdmin.password
                    }).then((res) => {
                        this.loading = false;
                        this.$modal.hide('create-new')
                        this.users.push(res.data)
                        this.newAdmin=''
                        this.$toasted.show('New Admin Created!',
                        {
                            type: 'success'
                        })
                    }).catch((err) => {
                        this.loading = false
                        this.createErr = true;
                        this.createErrors = "Admin creation failed. Please try again"
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
        updateAdmin(){
            this.loading = true
            axios.post('/admin_updateusers/' + this.editAdmin.id,{
                role: 7,
                fullname: this.editAdmin.fullname,
                email: this.editAdmin.email,
            }).then((res) =>{
                console.log(res.data)
                this.loading = false
                this.getAdmins()
                this.$modal.hide('edit-admin')
                this.$toasted.show('Admin details updated!',
                {
                    type: 'success'
                })
            })
        },
        cancelEdit(){
            this.$modal.hide('edit-admin')
        },
        getAdmins(){
            axios.get('/getadmins').then(res =>{
                if(res.data.length > 0){
                    this.users = res.data
                }
            })
        }
    },
    mounted() {
        this.getAdmins()
    },
}
</script>

<style lang="scss">   
    
    
</style>
