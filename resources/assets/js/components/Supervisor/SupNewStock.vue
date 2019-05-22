<template>
     <div class="supervisor_wrap">
          <supervisor-nav></supervisor-nav>
          <div class="container">
               <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                         <div class="sup_main form-horizontal">
                              <h4 class="text-center">Create New Stock Item</h4>
                              <div class="form-group">
                                   <label for="name" class="control-label col-md-2">Category</label>
                                   <div class="col-md-3">
                                        <select class="form-control" name="category" v-model="stock.category" v-validate="'required'" @change="showProds">
                                             <option value="" selected disabled>- Select Category -</option>
                                             <option v-for="cat in categs" :key="cat.id" :value="cat.id"> {{cat.name}}</option>
                                        </select>
                                        <div v-show="errors.has('category')">
                                             <div class="validation">
                                                  {{ errors.first('category') }}
                                             </div>
                                        </div>
                                   </div>
                                   <label for="products" class="control-label col-md-2">Products</label>
                                   <div class="col-md-3">
                                        <select class="form-control" v-model="stock.product" name="product" v-validate="'required'">
                                             <option value="" selected disabled>- Select Product -</option>
                                             <option v-for ="prod in products" :value="prod.id" :key="prod.id">{{ prod.name }}</option>
                                        </select>
                                        <div v-show="errors.has('product')">
                                             <div class="validation">
                                                  {{ errors.first('product') }}
                                             </div>
                                        </div>
                                   </div>
                                   <div style="clear:both"></div>
                              </div>
                              <div class="form-group">
                                   <label for="size" class="control-label col-md-2">Size</label>
                                   <div class="col-md-3">
                                        <select class="form-control" v-model="stock.size" name="size" v-validate="'required'">
                                             <option value="" selected disabled>Select Size</option>
                                             <option value="Small"> Small </option>
                                             <option value="Medium"> Medium </option>
                                             <option value="Big"> Big </option>
                                        </select>
                                        <div v-show="errors.has('size')">
                                             <div class="validation">
                                                  {{ errors.first('size') }}
                                             </div>
                                        </div>
                                   </div>
                                   <label class="control-label col-md-2">Colour</label>
                                   <div class="col-md-3">
                                        <input class="form-control" type="text" v-model="stock.colour">
                                   </div>
                                   <div style="clear:both"></div>
                              </div>
                              <div class="form-group">
                                   <label for="sn" class="control-label col-md-2">Serial No</label>
                                   <div class="col-md-3">
                                        <input class="form-control" name="sn" type="text" v-model="stock.sn" v-validate="'required'" data-vv-as="serial number">
                                        <div v-show="errors.has('sn')">
                                             <div class="validation">
                                                  {{ errors.first('sn') }}
                                             </div>
                                        </div>
                                   </div>
                                   <label for="rcvd" class="control-label col-md-2">Packs Rcvd</label>
                                   <div class="col-md-3">
                                        <input class="form-control" name="rcvd" type="text" v-model="stock.packsRcvd" v-validate="'required|numeric'" data-vv-as="packs received">
                                        <div v-show="errors.has('rcvd')">
                                             <div class="validation">
                                                  {{ errors.first('rcvd') }}
                                             </div>
                                        </div>
                                   </div>
                                   <div style="clear:both"></div>
                              </div>
                              <div class="form-group">
                                   <label for="unitspp" class="control-label col-md-2">Units Per Pack</label>
                                   <div class="col-md-3">
                                        <input class="form-control" type="text" name="unitspp" v-model="stock.unitsPp" @blur="calcUnits" v-validate="'required|numeric'" data-vv-as="units per pack">
                                        <div v-show="errors.has('unitspp')">
                                             <div class="validation">
                                                  {{ errors.first('unitspp') }}
                                             </div>
                                        </div>
                                   </div>
                                   <label for="totunits" class="control-label col-md-2">Total Units</label>
                                   <div class="col-md-3">
                                        <input class="form-control" type="text" readonly v-model="stock.totalUnits">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label for="pricepu" class="control-label col-md-2">Price per Unit</label>
                                   <div class="col-md-3">
                                        <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon1">&#8358;</span>
                                             <input type="text" name="pricepu" class="form-control" v-model="stock.pricePU" @blur="calcTotalCost" placeholder="Price of item" aria-describedby="basic-addon1" v-validate="'required|decimal:2|min_value:1'" data-vv-as="price per unit">
                                        </div>
                                        <div v-show="errors.has('pricepu')">
                                             <div class="validation">
                                                  {{ errors.first('pricepu') }}
                                             </div>
                                        </div>
                                   </div>
                                   <label name="totalcost" class="control-label col-md-2">Total Cost</label>
                                   <div class="col-md-3">
                                        <div class="input-group">
                                             <span class="input-group-addon" id="basic-addon1">&#8358;</span>
                                             <input type="text" name="totalcost" class="form-control" v-model="stock.totalCost" readonly>
                                        </div>
                                   </div>
                              </div>
                              <div class="form-group">
                                   <label class="control-label col-md-2" for="mfg">Manuf Date</label>
                                   <div class="col-md-3">
                                        <input type="date" class="form-control" v-model="stock.mfg">
                                   </div>
                                   <label class="control-label col-md-2" for="exp">Expiry</label>
                                   <div class="col-md-3">
                                        <input type="date" class="form-control" v-model="stock.exp">
                                   </div>
                              </div>
                              <div class="form-group">
                                   <div class="col-md-4 col-md-offset-4">
                                        <button type="button" class="btn btn-primary btn-block" @click="saveStock">Save Stock</button>
                                   </div>
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
               categs: [],
               stock:{
                    product: '',
                    category: '',
                    size: '',
                    packsRcvd: null,
                    unitsPp: null,
                    colour: '',
                    pricePU: null,
                    totalUnits: null,
                    totalCost: null,
                    sn: '',
                    mfg: '',
                    exp: ''
               },
               products: []
          }
     },
     methods: {
          getCategs(){
               axios.get('/getcategs').then((res) => {
                    this.categs = res.data
               })
          },
          saveStock(){
               this.$validator.validateAll().then(() =>{
                    if(!this.errors.any()){
                         axios.post('/sup_addnewstock', {
                              stock: this.stock
                         }).then((res) => {
                              console.log(res.data)
                              this.$router.go();
                              this.$toasted.show('New stock has been saved!',
                              {
                                   type: 'success'
                              })
                         })
                    }
               })
          },
          calcUnits(){
               this.stock.totalUnits = parseFloat(this.stock.unitsPp) * parseFloat(this.stock.packsRcvd)
          },
          calcTotalCost(){
               this.stock.totalCost = parseFloat(this.stock.totalUnits) * parseFloat(this.stock.pricePU)
          },
          showProds(){
               console.log(this.stock.category)
               axios.get('/sup_getproductsfromcateg/' + this.stock.category).then((res) => {
                    this.products = res.data
               })
          }
     },
     mounted() {
          this.getCategs()
     },
}
</script>

<style lang="scss">
     .sup_main{
          h4{
               padding:1.5rem;
          }

          .form-group:last-child{
               margin: 4rem auto;
          }
     }
     
</style>
