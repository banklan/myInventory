<template>
    <div class="settings">
        <sales-nav></sales-nav>
        <div class="main">
            <h4 class="text-center">Front Sales User Settings</h4>
            <div class="settings_wrap">
                <div class="profile">
                    <h4 class="text-center">User Profile</h4>
                    <table class="table table-responsive table-hover">
                        <tr>
                            <th>FullName:</th>
                            <td>{{ profile.full_name }}</td>
                        </tr>
                        <tr>
                            <th>Email Address:</th>
                            <td>{{ profile.email }}</td>
                        </tr>
                        <tr>
                            <th>Role Id:</th>
                            <td>{{ profile.role_id }}</td>
                        </tr>
                    </table>
                    <div class="edit_btn">
                        <a href="" @click.prevent="editProfile"><i class="fa fa-pencil"></i></a>
                    </div>
                </div>
                <modal name="edit" height="auto" :draggable="true" :width="450">
                    <div class="modal-header">
                        <h4 class="text-center">Update Profile </h4>
                    </div>
                    <div class="modal-body form-horizontal">
                        <div class="form-group">
                            <label for="name" class="control-label col-md-4">Full name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="name" v-model="updateProfile.name" v-validate="'required|max:60'" data-vv-scope="profile">
                                <div v-show="errors.has('name')" class="alert alert-danger">
                                    <div class="validation">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-md-4">Email</label>
                            <div class="col-md-8">
                                <input type="email" class="form-control" name="email" v-model="updateProfile.email" v-validate="'required|email'" data-vv-scope="profile">
                                <div v-show="errors.has('email')" class="alert alert-danger">
                                    <div class="validation">
                                        {{ errors.first('email') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal_btns">
                        <button class="btn btn-primary" :disabled="loading" @click.prevent="saveUpdates">
                            <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Saving changes...' : 'Update Profile' }}</button>
                        <button class="btn btn-danger" @click.prevent="cancelUpdate">Cancel</button>
                    </div>
                </modal>
                <div class="pswd_change form-horizontal">
                    <h4 class="text-center">Change Password</h4>
                    <div class="form-group">
                        <label for="oldPswd" class="control-label col-md-4">Old Password</label>
                        <div class="col-md-8">
                            <input type="password" name="oldPswd" class="form-control" v-model="oldPswd" @blur="checkOldPswd">
                            <span v-if="oldPswdValidation">
                                <div class="alert alert-danger">
                                    The supplied password is wrong 
                                </div>
                            </span>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="newPswd" class="control-label col-md-4">New Password</label>
                        <div class="col-md-8">
                            <input type="password" name="newPswd" ref="newPswd" class="form-control" v-model="newPswd" v-validate="'required|min:5|max:20'" data-vv-as="new password" data-vv-scope="password">
                            <div v-show="errors.has('newPswd')">
                                <div class="validation alert alert-danger">
                                    {{ errors.first('newPswd') }}
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="confPswd" class="control-label col-md-4">Confirm Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="confPswd" v-model="confPswd" v-validate="'required|confirmed:newPswd'" data-vv-as="confirm password" data-vv-scope="password">
                            <div v-show="errors.has('confPswd')">
                                <div class="validation alert alert-danger">
                                    {{ errors.first('confPswd') }}
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-4">
                            <button class="btn btn-primary" type="button" @click.prevent="changePswd">Save Password</button>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            profile: {},
            updateProfile: {
                name: '',
                email: ''
            },
            loading: false,
            oldPswd: '',
            newPswd: '',
            confPswd: '',
            oldPswdValidation: false
        }
    },
    methods: {
       getUserDetails(){
            axios.get('/getuserprofile').then((res) => {
                this.profile = res.data
                console.log(res.data)
            })
        }, 
        editProfile(){
            this.$modal.show('edit')
            this.updateProfile.name = this.profile.full_name
            this.updateProfile.email = this.profile.email
        }, 
        cancelUpdate(){
            this.$modal.hide('edit')
        },
        changePswd(){
            this.$validator.validateAll('password').then(() =>{
                if(!this.errors.any() && this.oldPswdValidation == false){
                    axios.post('/user_changepswd', {
                        newPswd: this.newPswd.trim(),
                        oldPswd: this.oldPswd.trim()
                    }).then((res) => {
                        console.log(res.data)
                        this.newPswd = '';
                        this.oldPswd = '';
                        this.confPswd = ''
                        this.$toasted.show('Password changed!',
                        {
                            type: 'success'
                        })
                    }).catch((err) => {
                        this.$toasted.show('Password change failed. Please try again!',
                        {
                            type: 'error'
                        })
                    })
                }
            })
        },
        saveUpdates(){
            this.$validator.validateAll('profile').then(() =>{
                if(!this.errors.any()){
                    this.loading = true
                    axios.post('/user_updateprofile', {
                        profile: this.updateProfile
                    }).then((res) => {
                        this.loading = false
                        this.cancelUpdate()
                        this.profile = res.data
                        this.$toasted.show('Profile updated!',
                        {
                            type: 'success'
                        })
                    }).catch((err) => {
                        this.loading = false
                    })
                }
            })
        },
        checkOldPswd(){
            axios.post('/user_confirmpswd', {
                old: this.oldPswd
            }).then((res) => {
               if(res.data !== true){
                   this.oldPswdValidation = true;
               }else{
                   this.oldPswdValidation = false;
               }
            })
        }
    },
   mounted() {
       this.getUserDetails()
   },
}
</script>

<style lang="scss" scoped>
    .main{
        margin: 4rem auto;
    }
    .settings_wrap{
        margin-top: 3rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;

        .profile, .pswd_change{
            flex: 0 1 48%;
            padding: 2rem;
            background: #fff;
            border: 1px solid #d3d2d2;
            border-radius: 4px;
            box-shadow: 10px 10px 10px rgba(43,53,53,.2);

            table tr{
                height: 4rem;
            }
        }
        .profile{
            table tr{
                display: flex;
                justify-content: space-around;
                align-items: center;

                th{
                    flex: 0 1 35%;
                }
                td{
                    flex: 1 1 65%;
                }
            }
            .edit_btn{
                display: flex;
                justify-content: center;
                align-items: center;

                .fa{
                    color: rgb(3, 60, 97);
                    font-size: 1.8rem;
                }
            }
        }
    }
</style>
