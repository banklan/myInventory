<template>
    <div class="addstock_modal">
        <modal name="add-stocks"  height="auto" :draggable="true" :width="600" @before-open="beforeOpen" @before-close="beforeClose">
            <div class="modal-header">
                <div slot="top-right">
                    <button @click="$modal.hide('add-stocks')" class="btn btn-danger btn-sm"><i class="fa fa-close"></i></button>
                </div>
                <h4 class="text-center">Add new {{ newStock.name }} - {{ newStock.size }} Stocks </h4>
                <div v-if="stockError" class="alert alert-danger">
                    <!-- {{ uploadError }} -->
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="rcvd" class="control-label col-md-2">Packs Rcvd</label>
                    <div class="col-md-4">
                        <input class="form-control" name="rcvd" type="text" v-model="newStock.packsRcvd" v-validate="'required|numeric'" data-vv-as="packs received" data-vv-scope="stock">
                        <div v-show="errors.has('rcvd')">
                            <div class="validation">
                                {{ errors.first('rcvd') }}
                            </div>
                        </div>
                    </div>
                    <label for="unitspp" class="control-label col-md-2">Units Per Pack</label>
                    <div class="col-md-4">
                        <input class="form-control" type="text" name="unitspp" v-model="newStock.unitsPp" @blur="calcUnits" v-validate="'required|numeric'" data-vv-as="units per pack" data-vv-scope="stock">
                        <div v-show="errors.has('unitspp')">
                            <div class="validation">
                                {{ errors.first('unitspp') }}
                            </div>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="form-group">
                    <label for="totunits" class="control-label col-md-2">Total Units</label>
                    <div class="col-md-4">
                        <input class="form-control" type="text" readonly v-model="newStock.totalUnits">
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="form-group">
                    <label for="pricepu" class="control-label col-md-2">Price per Unit</label>
                    <div class="col-md-4">
                        <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&#8358;</span>
                                <input type="text" class="form-control" v-model="newStock.price" readonly @blur="calcTotalCost" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <label name="totalcost" class="control-label col-md-2">Total Cost</label>
                    <div class="col-md-4">
                        <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&#8358;</span>
                                <input type="text" name="totalcost" class="form-control" v-model="newStock.totalCost" readonly>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="form-group">
                    <label for="sn" class="control-label col-md-2">Serial No</label>
                    <div class="col-md-4">
                        <input class="form-control" name="sn" key="input-sn" type="text" v-model="newStock.sn" v-validate="'required'" data-vv-as="serial number" data-vv-scope="stock">
                        <div v-show="errors.has('sn')">
                                <div class="validation">
                                    {{ errors.first('sn') }}
                                </div>
                        </div>
                    </div>
                    <label class="control-label col-md-2">Colour</label>
                    <div class="col-md-4">
                        <input class="form-control" type="text" v-model="newStock.colour">
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2" for="mfg">Manuf Date</label>
                    <div class="col-md-4">
                        <input type="date" class="form-control" v-model="newStock.mfg">
                    </div>
                    <label class="control-label col-md-2" for="exp">Expiry</label>
                    <div class="col-md-4">
                        <input type="date" class="form-control" v-model="newStock.expiry">
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
            <div class="modal-footer modal_btns">
                <button class="btn btn-primary" :disabled="loading" @click.prevent="uploadStock">
                    <i v-if="loading" class="fa fa-spin fa-spinner"></i>{{ loading ? ' Saving Updates...' : 'Save' }}</button>
                <button class="btn btn-danger" @click.prevent="cancelUpload">Cancel</button>
            </div>
        </modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            stockError: false,
            newStock:{
                name:''
            }
        }
    },
    methods: {
        uploadStock(){

        },
        cancelUpload(){

        },
        calcTotalCost(){

        },
        calcUnits(){

        }
    },
}
</script>

