var app  =  new Vue({
    el:'#invoice',
    data: {
        form:{},
        errors:{},
        empty:{},
        isProcessing:false,


    },
    created:function(){
        Vue.set(this.$data,'form',_form);
    },
    methods:{
        addLine() {
            this.form.products.push({name:'',price:0,qty:1})
            console.log(this.form.products);
        },
        remove(product){
        this.form.products.splice(product,1);
        },
        create(){


            //tra ve gia tri trong form qua bien form.
            this.$http.post('/invoices',this.form)
                .then(function(res){
                    if(res.data.created){
                        console.log(res.data.id);
                        window.location = '/invoices/'+res.data.id;
                    }else{
                        this.isProcessing = false;
                    }
                })
                .catch(function(res){
                   Vue.set(this.$data,'errors',res.data.errors);
                });

        },
        update(){
            this.$http.put('/invoices/'+this.form.id,this.form)
                .then(function(res){
                    if(res.data.created){
                        windown.location = '/invoices/'+res.data.id;
                    }else{
                        this.isProcessing = false;
                    }
                })
                .catch(function(res){
                    Vue.set(this.$data,'errors',res.data);

                });

        }

    },
    computed:{
        subTotal(){

            return this.form.products.reduce(function(carray,product){

                return carray+(parseFloat(product.qty)*parseFloat(product.price));
            },0)
        },
        grandTotal(){
            return this.subTotal - parseFloat(this.form.discount);
        }
    }


})