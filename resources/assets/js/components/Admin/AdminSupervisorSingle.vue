<template>
    <div class="admin_wrap">
        <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="topbar"><a href="#" @click.prevent="$router.go(-1)" title="Back"><i class="fa fa-arrow-circle-left"></i><span>Back </span></a></div>
            <div class="user_wrap">
                <table class="table table-responsive">
                    <tr>
                        <th>Name</th>
                        <td>{{ supervisor.full_name }}</td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td>{{ supervisor.email }}</td>
                    </tr>
                    <tr>
                        <th>User Role</th>
                        <td>{{ supervisor.role_id }}</td>
                    </tr>
                    <tr>
                        <th>User Status</th>
                        <td>{{ supervisor.status == 0 ? 'Disabled' : 'Enabled' }}</td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{ supervisor.created_at }}</td>
                    </tr>
                </table>
                <div class="admin_btns">
                    <button class="btn btn-primary btn-sm" @click.prevent="editSupervisor(supervisor.id)"><i class="fa fa-pencil"></i>Edit Supervisor Details</button>
                    <button class="btn btn-warning btn-sm" @click.prevent="changeStatus(supervisor.id)"><i class="fa fa-pause"></i>{{ supervisor.status == 0 ? 'Enable' : 'Disable' }} </button>
                    <button class="btn btn-success btn-sm" @click.prevent="resetSupervisorPswd(supervisor)"><i class="fa fa-key"></i>Reset Password</button>
                    <button class="btn btn-danger btn-sm" @click.prevent="delSupervisor(supervisor.id)"><i class="fa fa-trash"></i>Delete</button>
                </div>
                <modal name="edit" height="auto" :draggable="true" :width="450">
                    <div class="modal-header">
                        <h4 class="text-center">Edit/Update Supervisor Details - {{ supervisor.full_name }} </h4>
                    </div>
                    <div class="modal-body">
                       <div class="form-group">
                           <label for="name" class="control-label col-md-8">FullName</label>
                           <div style="clear:both"></div>
                           <div class="col-md-12">
                               <input type="text" class="form-control" name="name" v-model="updateSupervisor.full_name">
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="email" class="control-label col-md-8">Email</label>
                           <div style="clear:both"></div>
                           <div class="col-md-12">
                               <input type="text" class="form-control" name="email" v-model="updateSupervisor.email">
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
                        <h4 class="text-center">Reset Supervisor Password - {{ supervisor.full_name }} </h4>
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
                           <label for="confPassword" class="control-label col-md-8">Confirm Password</label>
                           <div style="clear:both"></div>
                           <div class="col-md-12">
                               <input type="password" class="form-control" name="confPassword" v-model="confPassword">
                           </div>
                       </div>
                       <div v-if="resetError" class="resetError">
                            <div class="alert alert-danger">
                                {{ pswdErr }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal_btns">
                        <button class="btn btn-primary" :disabled="loading" @click.prevent="resetPassword(supervisor.id)">
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
            supervisor: {},
            updateSupervisor: {
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
        editSupervisor(user){
            this.$modal.show('edit')
            this.updateSupervisor.full_name = this.supervisor.full_name
            this.updateSupervisor.email = this.supervisor.email
            this.updateSupervisor.id = this.supervisor.id
        },
        updateUser(user){
            if(this.updateSupervisor.fullname !== '' && this.updateSupervisor.email !== ''){
                this.loading = true
                axios.post('/update_admin_supervisor/'+ this.id, {
                    fullname: this.updateSupervisor.full_name,
                    email: this.updateSupervisor.email
                }).then((res) => {
                    this.supervisor = res.data
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
            // this.updateAdmin = {}
        },
        changeStatus(user){
            if(this.supervisor.status == 0){
               if(confirm("Do you want to enable this supervisor?")){
                   axios.post('/enable_supervisor/' + user).then((res) => {
                       this.supervisor.status = 1
                       this.$toasted.show('User enabled!',
                        {
                            type: 'success'
                        })
                   })
               } 
            }else{
                if(confirm("Do you want to disable this supervisor?")){
                   axios.post('/disable_supervisor/' + user).then((res) => {
                       this.supervisor.status = 0
                       this.$toasted.show('User disabled!',
                        {
                            type: 'success'
                        })
                   })
               } 
            }
        },
        resetSupervisorPswd(user){
            this.$modal.show('reset-password')
        },
        resetPassword(user){
            if(this.newPassword !== '' && this.confPassword !== ''){
                if(this.newPassword === this.confPassword){
                    this.loading = true
                    axios.post('/reset_supervisorpswd/' + user, {
                        newPassword : this.newPassword
                    }).then((res) => {
                        this.cancelReset()
                        this.loading = false
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
        delSupervisor(user){
            if(confirm("Do you really want to delete this Supervisor user? It is unrevokable once done.")){
                this.loading = true
                axios.post('/del_supervisor/' + user).then((res) => {
                    this.$router.push({name: 'all_users'})
                })
                this.$toasted.show('The Supervisor user has been deleted!',
                {
                    type: 'success'
                })
            }
        }
    },
    mounted() {
        axios.get('/getsupervisoruser/'+ this.id).then((res) => {
            this.supervisor = res.data
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
            width: 70%;
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
