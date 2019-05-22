<template>
   <div class="supervisor_wrap">
        <supervisor-nav></supervisor-nav>
        <h1>test here</h1>
    </div>
</template>

// li.activeLink{
                //     a{
                //      color: red;
                //     }
                // }

                // li:hover, li.exact-active{
                //     color: red;
                //     background: green;
                // }

                // a.exact-active, a.active{
                //     color: red;
                //     border-bottom: 1px solid red;
                // }

<table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="prod in products" :key="prod.id">
            <td>{{ prod.id }}</td>
            <td>{{ prod.name }}</td>
            <td><button class="btn btn-success btn-sm" @click.prevent="addStocks(prod)">Add Stock</button></td>
        </tr>
    </tbody>
</table>

methods
addStocks(prod){
    this.$modal.show('add-stocks')
    this.newStock.unitPrice = prod.sellin_price
    this.newStock.id = prod.id
    this.newStock.name = prod.name
},

data() {
    return {
         products: [],
         newStock: {
            id: null,
            name: '',
            size: '',
            srln: '',
            colour: '',
            mfg: '',
            expiry: '',
            selling_price: ''
        },
    }
},

<modal name="add-stocks"  height="auto" :draggable="true" :width="600">
    <div class="modal-header">
        <h4>Add new stock</h4>
    </div>
    <div class="modal-body form-horizontal">
    <div class="form-group">
        <label for="unitPrice" class="control-label col-md-2">Unit Price</label>
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">&#8358;</span>
                <input class="form-control" v-model="newStock.unitPrice" readonly aria-describedby="basic-addon1">
            </div>
        </div>
        <div style="clear:both"></div>
    </div>
    <div class="form-group">
        //other form fields
    </div>  
    <div class="modal-footer modal_btns">
        <button class="btn btn-primary" @click.prevent="uploadStock">Save</button>
        <button class="btn btn-danger" @click.prevent="cancelUpload">Cancel</button>
    </div>
</modal>

uploadStock(){
    this.$validator.validateAll('stock').then(() =>{
        if(!this.errors.any()){
            //post to api
        }
    })
},
cancelUpload(){
    this.$modal.hide('add-stocks')
    this.newStock.unitPrice = prod.sellin_price
    this.newStock.id = prod.id
    this.newStock.name = prod.name
}
                
