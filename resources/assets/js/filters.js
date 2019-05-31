import Vue from 'vue'

Vue.filter('toThousandth', (value)=>{
    return value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1, ')
});

Vue.filter('toCurrency', (value)=>{
    let amt = parseFloat(value) / 100
    return amt.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&, ')
});

Vue.filter('pluralize', function(value, string){
    if(parseInt(value) > 1){
        return value +' '+ string +'s'
    }else{
        return value + ' ' + string;
    }
})

