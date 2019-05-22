<template>
    <div class="admin_wrap">
        <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <!-- <div class="breadcrumb"><router-link :to="{name: 'admin'}">Dashboard</router-link> > <router-link :to="{name: 'all_users'}">Users</router-link> > User</div> -->
            <div class="topbar"><a href="#" @click.prevent="$router.go(-1)" title="Back"><i class="fa fa-arrow-circle-left"></i><span>Back </span></a></div>
            <div class="user_wrap">
                <table class="table table-responsive">
                    <tr>
                        <th>Name</th>
                        <td>{{ admin.full_name }}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>{{ admin.email }}</td>
                    </tr>
                    <tr>
                        <th>User Role</th>
                        <td>{{ admin.role_id }}</td>
                    </tr>
                    <tr>
                        <th>Admin Status</th>
                        <td>{{ admin.status == 0 ? 'Disabled' : 'Enabled' }}</td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{ admin.created_at }}</td>
                    </tr>
                </table>
                <div class="admin_btns">
                    <button class="btn btn-primary btn-sm" @click.prevent="editAdmin(admin.id)"><i class="fa fa-pencil"></i>Edit Admin Details</button>
                    <button class="btn btn-warning btn-sm" @click.prevent="changeStatus(admin.id)"><i class="fa fa-pause"></i>{{ admin.status == 0 ? 'Enable' : 'Disable' }} </button>
                    <button class="btn btn-success btn-sm" @click.prevent="resetAdminPswd(admin)"><i class="fa fa-key"></i>Reset Password</button>
                    <button class="btn btn-danger btn-sm" @click.prevent="delAdmin(admin.id)"><i class="fa fa-trash"></i>Delete</button>
                </div>
                <modal name="edit" height="auto" :draggable="true" :width="450">
                    <div class="modal-header">
                        <h4 class="text-center">Edit/Update Admin Details - {{ admin.full_name }} </h4>
                    </div>
                    <div class="modal-body">
                       <div class="form-group">
                           <label for="name" class="control-label col-md-8">FullName</label>
                           <div style="clear:both"></div>
                           <div class="col-md-12">
                               <input type="text" class="form-control" name="name" v-model="updateAdmin.full_name">
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="email" class="control-label col-md-8">Email</label>
                           <div style="clear:both"></div>
                           <div class="col-md-12">
                               <input type="text" class="form-control" name="email" v-model="updateAdmin.email">
                           </div>
                       </div>
                    </div>
                    <div class="modal-footer modal_btns">
                        <button class="btn btn-primary" :disabled="loading" @click.prevent="updateUser">
                            <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Saving changes...' : 'Update Admin' }}</button>
                        <button class="btn btn-danger" @click.prevent="cancelUpdate">Cancel</button>
                    </div>
                </modal>
                <modal name="reset-password" height="auto" :draggable="true" :width="450">
                    <div class="modal-header">
                        <h4 class="text-center">Reset Admin Password - {{ admin.full_name }} </h4>
                    </div>
                    <div class="modal-body">
                       <div class="form-group">
                           <label for="password" class="control-label col-md-8">New Password</label>
                           <div style="clear:both"></div>
                           <div class="col-md-12">
                               <input type="password" class="form-control" name="password" v-model="newPassword">
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="password" class="control-label col-md-8">Confirm Password</label>
                           <div style="clear:both"></div>
                           <div class="col-md-12">
                               <input type="password" class="form-control" name="email" v-model="confPassword">
                           </div>
                       </div>
                       <div v-if="resetError" class="resetError">
                            <div class="alert alert-danger">
                                {{ pswdErr }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal_btns">
                        <button class="btn btn-primary" :disabled="loading" @click.prevent="resetPassword(admin.id)">
                            <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Saving changes...' : 'Reset Password' }}</button>
                        <button class="btn btn-danger" @click.prevent="cancelReset">Cancel</button>
                    </div>
                </modal>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            admin: {},
            updateAdmin: {
                full_name: '',
                email: '',
                id: ''
            },
            loading: false,
            newPassword: '',
            confPassword: '',
            resetError: false,
            pswdErr: ''
        }
    },
    methods: {
        editAdmin(user){
            this.$modal.show('edit')
            this.updateAdmin.full_name = this.admin.full_name
            this.updateAdmin.email = this.admin.email
            this.updateAdmin.id = this.admin.id
        },
        updateUser(user){
            if(this.updateAdmin.fullname !== '' && this.updateAdmin.email !== ''){
                this.loading = true
                axios.post('/update_admin_user/'+ this.updateAdmin.id, {
                    full_name: this.updateAdmin.full_name,
                    email: this.updateAdmin.email
                }).then((res) => {
                    this.admin = res.data
                    this.loading = false
                    this.$modal.hide('edit')
                    this.$toasted.show('Your changes have been saved!',
                        {
                            type: 'success'
                        })
                })
            }
        },
        cancelUpdate(){
            this.$modal.hide('edit')
            this.updateAdmin = {}
        },
        changeStatus(admin){
            if(this.admin.status == 0){
               if(confirm("Do you want to enable this admin?")){
                   axios.post('/enable_admin/' + admin).then((res) => {
                    //    console.log(res.data)
                       this.admin.status = 1
                       this.$toasted.show('User enabled!',
                        {
                            type: 'success'
                        })
                   })
               } 
            }else{
                if(confirm("Do you want to disable this user?")){
                   axios.post('/disable_admin/' + admin).then((res) => {
                       console.log(res.data)
                       this.admin.status = 0
                       this.$toasted.show('Admin disabled!',
                        {
                            type: 'success'
                        })
                   })
               } 
            }
        },
        resetAdminPswd(admin){
            this.$modal.show('reset-password')
        },
        resetPassword(admin){
            if(this.newPassword !== '' && this.confPassword !== ''){
                if(this.newPassword === this.confPassword){
                    this.loading = true
                    axios.post('/reset_adminpswd/' + admin, {
                        newPassword : this.newPassword
                    }).then((res) => {
                        this.cancelReset()
                         this.$toasted.show('Password has been reset!',
                        {
                            type: 'success'
                        })
                    })
                }else{
                    this.resetError = true;
                    this.pswdErr = 'Passwords do not match'
                }
            }
        },
        cancelReset(){
            this.newPassword = '';
            this.confPassword = ''
            this.resetError = false
            this.$modal.hide('reset-password')
        },
        delAdmin(admin){
            if(confirm("Do you really want to delete this Admin user? It is unrevokable once done.")){
                this.loading = true
                axios.post('/del_admin/' + admin).then((res) => {
                    this.$router.push({name: 'all_users'})
                })
                this.$toasted.show('The Admin user has been deleted!',
                {
                    type: 'success'
                })
            }
        }
    },
    mounted() {
        axios.get('/getadminuser/'+ this.id).then((res) => {
            this.admin = res.data
        })
    },
}
</script>

<style lang="scss" scoped>
    .user_wrap{
        background: #fff;
        border: 1px solid #f9f9f9;
        border-radius: 4px;
        box-shadow: 0 0 9px 5px rgba(93, 93, 93, 0.2);
        margin: 2rem 4rem;
        padding: 1.5rem;

        table tr{
            height: 4.5rem;
            display: flex;
            justify-content:flex-start;

            th{
                flex: 1 1 15%;
            }

            td{
                flex: 1 1 85%;
            }
        }
        .admin_btns{
            width: 60%;
            display: flex;
            justify-content: space-around;
            align-items: center;

            button{
                margin-right: 1rem;
            }
            .fa{
                margin-right: 1rem;
            }
        }
        .modal-body{
            .form-group:first-child{
                margin-bottom: 6rem;
            }
            .form-group:last-child{
                margin-bottom: 5rem;
            }
            .resetError{
                margin-top: 5rem;
            }
        }
    }

    
</style>
