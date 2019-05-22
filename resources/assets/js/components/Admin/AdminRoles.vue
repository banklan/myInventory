<template>
    <div class="admin_wrap">
       <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="breadcrumb"><router-link :to="{name: 'admin'}">Dashboard</router-link> > Roles Management</div>
            <div class="upper_strip">
                <button class="btn btn-primary" type="button" @click="openCreate"><i class="fa fa-plus"></i>Add New Role</button>
                <p></p>
            </div>
            <modal name="create-new" height="auto" :draggable="true" :width="500">
                <div class="modal-header">
                    <h4 class="text-center">Create New Role </h4>
                    <div v-if="createErr" class="alert alert-danger">
                        {{ createErrors }}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fullname" class="control-label col-md-8">Role Name</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="text" v-model="newRole.role_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-8">Role ID</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="number" class="form-control" v-model="newRole.role_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="createRole">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Creating...' : 'Create Role' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelCreate">Cancel</button>
                </div>
            </modal>
            <modal name="edit-role" height="auto" :draggable="true" :width="500">
                <div class="modal-header">
                    <h4 class="text-center">Update Role Details </h4>
                    <div v-if="EditErr" class="alert alert-danger">
                        {{ editErrors }}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="control-label col-md-8">Role Name</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="text" v-model="editRole.role_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id" class="control-label col-md-8">Role Id</label>
                        <div style="clear:both"></div>
                        <div class="col-md-12">
                            <input type="id" class="form-control" name="id" v-model="editRole.role_id">
                        </div>
                    </div>
                </div>
                <div class="modal-footer modal_btns">
                    <button class="btn btn-primary" :disabled="loading" @click.prevent="updateRole(role)">
                        <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? ' Saving Updates...' : 'Save' }}</button>
                    <button class="btn btn-danger" @click.prevent="cancelEdit">Cancel</button>
                </div>
            </modal>
            <h3 class="text-center">All Roles <span class="badge">{{ roles.length }}</span></h3>
            <div class="users_table">
                <div v-if="roles.length === 0" class="alert alert-warning">
                    There are no roles to display in your table
                </div>
                <table v-else class="table table-responsive table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Role Name</th>
                            <th>Role Id</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(role, index) in roles" :key="role.id">
                            <td>{{ index + 1 }}</td>
                            <td>{{ role.role_name }}</td>
                            <td>{{ role.role_id }}</td>
                            <td>{{ role.created_at }}</td>
                            <td class="action">
                                <button class="btn btn-primary btn-sm" @click.prevent="editRoleDetails(role)"><i class="fa fa-pencil"></i>Edit</button>
                                <button class="btn btn-danger btn-sm" @click.prevent="delRole(role, index)"><i class="fa fa-trash"></i>Delete</button>
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
            roles: [],
            newRole:{
                role_name: '',
                role_id: '',
            },
            loading: false,
            createErr: false,
            createErrors: '',
            EditErr: false,
            editErrors: '',
            editRole: {
                role_name: '',
                role_id: '',
            }
        }
    },
    methods: {
        editRoleDetails(role){
            this.$modal.show('edit-role')
            this.editRole.role_name = role.role_name
            this.editRole.role_id = role.role_id
        },
        delRole(role, index){
            if(confirm("Do you want to delete this role? It is an unrecoverable action once done!")){
                axios.post('/admin_delrole/'+ role.id).then((res) => {
                    console.log(res.data)
                    this.roles.splice(index, 1)
                    this.$toasted.show('Role Deleted!',
                    {
                        type: 'success'
                    })
                })
            }
        },
        openCreate(){
            this.$modal.show('create-new')
        },
        createRole(){
            this.loading = true
            if(this.newRole.role_name !== '' && this.newRole.role_id){
                axios.post('/create_role', {
                    role_name: this.newRole.role_name,
                    role_id: this.newRole.role_id,
                }).then((res) => {
                    this.loading = false;
                    this.createErr = false;
                    this.$modal.hide('create-new')
                    this.roles.push(res.data)
                    this.newRole=''
                    this.$toasted.show('New Role Created!',
                    {
                        type: 'success'
                    })
                }).catch((err) => {
                    this.loading = false
                    this.createErr = true;
                    this.createErrors = "Failed to create the new Role. Please try again"
                })
            }else{
                this.createErr = true
                this.loading = false
                this.createErrors = 'Fill both the role name and id fileds'
            }
        },
        cancelCreate(){
            this.createErr = false;
            this.createErrors = ''
            this.$modal.hide('create-new')
        },
        updateRole(){
            this.loading = true
            axios.post('/admin_updaterole/' + this.editRole.role_id,{
                role_name: this.editRole.role_name,
                role_id: this.editRole.role_id,
            }).then((res) =>{
                this.loading = false
                this.$modal.hide('edit-role')
                this.getRoles()
                this.$toasted.show('Role details updated!',
                {
                    type: 'success'
                })
            })
        },
        cancelEdit(){
            this.$modal.hide('edit-role')
        },
        getRoles(){
            axios.get('/getroles').then(res =>{
                if(res.data.length > 0){
                    this.roles = res.data
                    console.log(res.data)
                }
            })
        }
    },
    mounted() {
        this.getRoles()
    },
}
</script>

<style lang="scss">   
    
    table .action{
        display: flex;
        justify-content: space-around;
        align-items: center;
    }
</style>
