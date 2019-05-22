<template>
    <div class="admin_wrap">
        <div class="sidebar">
            <admin-sidebar></admin-sidebar>
        </div>
        <div class="main">
            <div class="topbar"><a href="#" @click.prevent="$router.go(-1)" title="Back"><i class="fa fa-arrow-circle-left"></i><span>Back </span></a></div>
            <div class="user_wrap">
                <h4 class="text-center">Product - {{ prod.name }}</h4>
                <table class="table table-responsive">
                    <tr>
                        <th>Product Name</th>
                        <td>{{ prod.name }}</td>
                    </tr>
                    <tr>
                        <th>Product Category</th>
                        <td>{{ prod.category && prod.category.name }}</td>
                    </tr>
                    <tr>
                        <th>Size</th>
                        <td>{{ prod.size }}</td>
                    </tr>
                    <tr>
                        <th>Cost Price (&#8358;)</th>
                        <td>{{ prod.cos_price }}</td>
                    </tr>
                    <tr>
                        <th>Selling Price(&#8358;)</th>
                        <td>{{ prod.sellin_price }}</td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{ prod.created_at }}</td>
                    </tr>
                </table>
                <div class="admin_btns">
                    <button class="btn btn-primary btn-sm" @click.prevent="editProd(prod.id)"><i class="fa fa-pencil"></i>Edit Product</button>
                    <button class="btn btn-danger btn-sm" @click.prevent="delProd(prod.id)"><i class="fa fa-trash"></i>Delete</button>
                    <!-- <button class="btn btn-success btn-sm" @click.prevent="findUser()"><i class="fa fa-users"></i>Find User</button> -->
                </div>
                <modal name="edit" height="auto" :draggable="true" :width="450">
                    <div class="modal-header">
                        <h4 class="text-center">Update Product Details - {{ prod.name }} </h4>
                    </div>
                    <div class="modal-body form-horizontal">
                       <div class="form-group">
                           <label for="name" class="control-label col-md-4">Name</label>
                           <div class="col-md-8">
                               <input type="text" class="form-control" name="name" v-model="updateProd.name" v-validate="'required|max:60'">
                               <div v-show="errors.has('name')" class="alert alert-danger">
                                    <div class="validation">
                                        {{ errors.first('name') }}
                                    </div>
                                </div>
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="cat" class="control-label col-md-4">Category</label>
                           <div class="col-md-8">
                               <select class="form-control" name="cat" v-model="updateProd.cat" v-validate="'required'">
                                   <option v-for="cat in categs" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                               </select>
                               <div v-show="errors.has('cat')" class="alert alert-danger">
                                    <div class="validation">
                                        {{ errors.first('cat') }}
                                    </div>
                                </div>
                           </div>
                       </div>
                        <div class="form-group">
                           <label for="cat" class="control-label col-md-4">Size</label>
                           <div class="col-md-8">
                               <select class="form-control" name="size" v-model="updateProd.size" v-validate="'required'">
                                   <option value="Small">Small</option>
                                   <option value="Medium">Medium</option>
                                   <option value="Large">Large</option>
                               </select>
                               <div v-show="errors.has('size')" class="alert alert-danger">
                                    <div class="validation">
                                        {{ errors.first('size') }}
                                    </div>
                                </div>
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="cost" class="control-label col-md-4">Cost Price(&#8358;)</label>
                           <div class="col-md-8">
                                <input class="form-control" name="cost" type="text" v-model="updateProd.cost" v-validate="'required'" data-vv-as="product cost price">
                                <div v-show="errors.has('cost')" class="alert alert-danger">
                                    <div class="validation">
                                        {{ errors.first('cost') }}
                                    </div>
                                </div>
                           </div>
                       </div>
                       <div class="form-group">
                           <label for="selling" class="control-label col-md-4">Selling Price(&#8358;)</label>
                           <div class="col-md-8">
                                <input class="form-control" name="selling" type="text" v-model="updateProd.selling" v-validate="'required|decimal:2'" data-vv-as="product selling price">
                                <div v-show="errors.has('selling')" class="alert alert-danger">
                                    <div class="validation">
                                        {{ errors.first('selling') }}
                                    </div>
                                </div>
                           </div>
                       </div>
                    </div>
                    <div class="modal-footer modal_btns">
                        <button class="btn btn-primary" :disabled="loading" @click.prevent="updateProduct">
                            <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Saving changes...' : 'Update Product' }}</button>
                        <button class="btn btn-danger" @click.prevent="cancelUpdate">Cancel</button>
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
            prod: {},
            updateProd: {
                name: '',
                cat: '',
                cat_name: '',
                size: '',
                cost: '',
                selling: ''
            },
            categs: [],
            loading: false
        }
    },
    methods: {
        editProd(prod){
            this.$modal.show('edit');
            this.updateProd.name = this.prod.name
            this.updateProd.cat = this.prod.category.id
            this.updateProd.cat_name = this.prod.category.name
            this.updateProd.size = this.prod.size
            this.updateProd.cost = this.prod.cost_price/100
            this.updateProd.selling = this.prod.selling_price/100
        },
        delProd(prod){
            if(confirm("Are you sure you want to delete this product? It is an irrecoverable action!")){
                axios.post('/admin_delprod/' + prod).then((res) =>{
                    console.log(res.data)
                    this.$router.push({name: 'AllProducts'})
                }).catch((err) => {

                })
            }
        },
        updateProduct(){
            this.$validator.validateAll().then(() =>{
                if(!this.errors.any()){
                    axios.post('/admin_updateproduct/' + this.id, {
                        product: this.updateProd
                    }).then((res)=>{
                        this.$modal.hide('edit')
                        this.getProduct()
                        this.$toasted.show('Product Updated!',
                        {
                            type: 'success'
                        })
                    })
                }
            })
        },
        getProduct(){
            axios.get('/admin_viewproduct/' + this.id).then((res) => {
                this.prod = res.data
                console.log(res.data)
            })
        },
        cancelUpdate(){
            this.$modal.hide('edit')
        },
        // findUser(){
        //     axios.get('/getUser').then((res) => {
        //         console.log(res.data)
        //     })
        // }
    },
    mounted() {
        //get product
            this.getProduct()

        // get categs
            axios.get('/admin_getcategs').then((res) => {
                this.categs = res.data
                console.log(res.data)
            })
        }
}
</script>

<style lang="scss">
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
            width: 40%;
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
            .form-group:not(:last-child){
                margin-bottom: 3rem;
            }
            
            .resetError{
                margin-top: 5rem;
            }
        }
    }
</style>
