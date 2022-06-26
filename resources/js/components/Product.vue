<template>
    <div>
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Bootstrap Cards</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Components</a>
                            </li>
                            <li class="breadcrumb-item active">Bootstrap Cards
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">

            <div style="padding: 20px 0;">
                <fieldset>
                    <div class="d-inline-block custom-control custom-checkbox mr-1">
                        <input type="checkbox" class="custom-control-input bg-success bg-darken-2" name="promotionCheck" id="colorCheck7" checked v-model="filtres.active" @change="getProduct" value="0">
                        <label class="custom-control-label" for="colorCheck7">Активные продукты</label>
                    </div>
                </fieldset>
            </div>

            <!-- Outline variants section start -->
            <section id="outline-variants">
                <div class="row">
                    <div class="col-12 mt-3 mb-1">
                        <h4 class="text-uppercase">Продукты</h4>
                    </div>
                </div>
                <div class="row match-height" v-if="products.length">
                    <div v-for="(product, pd_id) in products"  class="col-md-6 col-sm-12">
                        <div class="card border-primary text-center bg-transparent">
                            <div class="card-content">
                                <div class="card-body pt-3">
                                    <b-img :src="product.image" width="200" height="auto" class="mb-1" v-if="product.image"></b-img>
                                    <b-img src="/images/img-no-product.png" width="200" height="auto" class="mb-1" v-else></b-img>
                                    <h4 class="card-title mt-3">{{product.name}}</h4>
                                    <div class="card-text">
                                         <ul class="list-unstyled">
                                             <li>Цена: {{product.original_price}} <i class="fa fa-rub"></i></li>
                                             <li>Цена по скидке: {{product.price}} <i class="fa fa-rub"></i></li>
                                             <li>Состояние: {{product.state}}</li>
                                         </ul>
                                    </div>
                                    <button class="btn btn-primary">Buy Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12" v-else>
                    <div class="alert alert-info alert-dismissible mb-2" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>Нет данных!</strong>
                    </div>
                </div>

            </section>

            <section class="pagination" v-if="products.length">
                <nav style="margin: 10px auto">
                    <b-pagination
                        v-model="page"
                        :total-rows="totalPage"
                        :per-page="perPage"
                        @change="getProduct"
                        prev-text="Пред"
                        next-text="Сл"
                        first-number
                        last-number
                    ></b-pagination>
                </nav>

            </section>
            <!-- Outline variants section end -->

        </div>
    </div>
    </div>
</template>

<script>

export default {
    name: "Product",
    data(){
        return {
            filtres:{
                active:true,
            },
            products: [],
            /*pagination*/
            page:1,
            perPage:0,
            totalPage:0,
            currentPage:0
        }
    },
    mounted() {
        this.getProduct();
    },
    methods:{
        getProduct(page){

            let apiURI = this.$apiURI+"product";

            axios.get(apiURI,{
                params: {
                    page: page,
                    filter:this.filtres
                }
            }).then( response => {

                let responseData = response.data;

                this.products = [];
                this.products = responseData.data;
                this.perPage = responseData.per_page;
                this.totalPage = responseData.total;
                this.currentPage = responseData.current_page;
                this.page = responseData.current_page;


            }).catch(error=>{

                if(!!error.response.data.errors){
                    $.each(error.response.data.errors, function(key, value) {
                        toastr.error(value[0], 'Оповещение!', {"progressBar": true});
                    });
                }

                if(error.response.status === 500){
                    toastr.error(error.response.data.message, 'Оповещение!', {"progressBar": true});
                }

            })
        }
    }
}
</script>

<style scoped>

</style>
