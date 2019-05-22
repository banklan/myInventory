<template>
    <div class="supervisor_wrap">
        <supervisor-nav></supervisor-nav>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="sup_main">
                        <div class="top_strip_single">
                            <router-link :to="{name: 'SupAllProducts'}"><i class="fa fa-arrow-left"></i> Back</router-link>
                        </div>
                        <div class="prod_wrap">
                            <table class="table table-responsive">
                                <tr>
                                    <th>Product Name:</th>
                                    <td>{{ product.name }}</td>
                                </tr>
                                <tr>
                                    <th>Product Category:</th>
                                    <td>{{ product.category && product.category.name }}</td>
                                </tr>
                                <tr>
                                    <th>Product Size:</th>
                                    <td>{{ product.size }}</td>
                                </tr>
                                <tr>
                                    <th>Product Cost Price(&#8358;):</th>
                                    <td>{{ product.cos_price }}</td>
                                </tr>
                                <tr>
                                    <th>Product Selling Price(&#8358;):</th>
                                    <td>{{ product.sellin_price }}</td>
                                </tr>
                            </table>
                            <div class="sup_btns">
                                <button type="button" class="btn btn-success" @click="editProduct">Edit <i class="fa fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger">Delete <i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    <modal name="edit-product" height="auto" :draggable="true" :width="450">
                        <div class="modal-header">
                            <h4 class="text-center">Update Product Details - {{ product.name }} </h4>
                        </div>
                        <div class="modal-body form-horizontal">
                            <div class="form-group">
                                <label for="name" class="control-label col-md-2">Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" v-model="updateProd.name" v-validate="'required|max:60'">
                                    <div v-show="errors.has('name')" class="alert alert-danger">
                                        <div class="validation">
                                            {{ errors.first('name') }}
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            <div class="form-group">
                                <label for="cost" class="control-label col-md-2">Cost Price</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">&#8358;</span>
                                        <input type="text" name="cost" class="form-control" v-model="updateProd.costPU" v-validate="'required|decimal:2|min_value:1'" data-vv-as="cost per unit">
                                        <div v-show="errors.has('cost')" class="alert alert-danger">
                                            <div class="validation">
                                                {{ errors.first('cost') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                            <div class="form-group">
                                <label for="selling" class="control-label col-md-2">Selling Price</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">&#8358;</span>
                                        <input type="text" name="selling" class="form-control" v-model="updateProd.sellingPU" v-validate="'required|decimal:2|min_value:1'" data-vv-as="price per unit">
                                        
                                        <div v-show="errors.has('selling')" class="alert alert-danger">
                                            <div class="validation">
                                                {{ errors.first('selling') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        </div>
                        <div class="modal-footer modal_btns">
                            <button class="btn btn-primary" :disabled="loading" @click.prevent="updateProduct">
                                <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? 'Saving changes...' : 'Save Product' }}</button>
                            <button class="btn btn-danger" @click.prevent="cancelUpdate">Cancel</button>
                        </div>
                    </modal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            product: {},
            updateProd: {
                name: '',
                sellingPU: '',
                costPU: ''
            },
            loading: false
        }
    },
    methods: {
        getProduct(){
            axios.get('/sup_getproduct/' + this.id).then((res) => {
                this.product = res.data
            })
        },
        editProduct(){
            this.$modal.show('edit-product')
            this.updateProd.name = this.product.name
            this.updateProd.costPU = this.product.cost_price / 100
            this.updateProd.sellingPU = this.product.selling_price / 100
        },
        updateProduct(){
            this.$validator.validateAll().then(() =>{
                if(!this.errors.any()){
                    console.log(this.updateProd)
                    axios.post('/sup_updateproduct/' + this.product.id, {
                        product: this.updateProd
                    }).then((res) => {
                        this.$toasted.show('Supervisors have not been enabled to update products!',
                        {
                            type: 'success'
                        })
                    })
                }
            })
        },
        cancelUpdate(){
            this.$modal.hide('edit-product')
        }
    },
    mounted() {
        this.getProduct()
    },
}
</script>

<style lang="scss">
    .prod_wrap{
        margin-top: 2rem;
        padding: 2rem;
        border: #ececec;
        border-radius: 6px;
        box-shadow: 0px 0px 7px 1px #b9b9b9db;
        background: #fff;

       tr{
            height: 4.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;

            th{
                flex: 0 1 30%;
            }
            td{
                flex: 1 1 70%;
            }
        } 

        .sup_btns{
            width: 30%;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }
    }
</style>
