<template>

    <div class="my-2 mt-5">
         <div class="row">
             <div class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" v-model="keywords" type="search" placeholder="Search by name..." aria-label="Search">

                <label for="">Price less than</label>
                <select name="" id="" v-model="price" class="form-select form-select-sm" aria-label=".form-select-sm example">
                    <option value="20000">All Prices</option>
                    <option value="1000">1000</option>
                    <option value="2000">2000</option>
                    <option value="3000">3000</option>
                    <option value="5000">5000</option>
                    <option value="10000">10000</option>
                </select>
                <a href="/add-category" class="btn btn-primary">Add Category</a>
                <a href="/add-product" class="btn btn-success">Add Product</a>
            </div>

            <div class="d-inline-flex p-2">
                <div class="p-2 col-4" v-for="category in this.categories" style="margin_left:20px;">
                    <div class="categorybox w-100 align-items-center py-1" @click="selectedCat(category.id)">
                        <h5 class="text-center">{{category.name}}</h5>
                    </div>
                </div>
            </div>
             
            
             <div id="test" class="p-2 col-4" :items="filtredproducts" :per-page="perPage" :current-page="currentPage" v-for="product in itemsForList">
                 <div class="card" style="width: 18rem;">
                    <img class="card-img-top" :src="'images/' + product.image" :alt="product.name">
                    
                    <div class="card-body">
                        <h5 class="text-center">{{product.name}}</h5>
                    <p class="card-text">{{product.description}}</p>
                    </div>
                </div>
             </div>
            
             
            

            
            


         </div>

         <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="test"
            ></b-pagination>

             <p class="mt-3">Current Page: {{ currentPage }}</p>
    </div>
</template>

<script>
    export default {
        props:['products', 'categories'],
        data(){
            return {
                perPage: 3,
                currentPage: 1,
                selectedcategory : '',
                keywords: null,
                price: null,
                results: [],
            }
        },
        watch: {
            keywords(after, before) {
                this.fetch();
            },
            price(after, before) {
                this.fetch();
            },
        },
        methods:{
            selectedCat : function(id){
                this.selectedcategory = id;
                // this.taman = null;
            },
            fetch() {
                axios.get('/res-search', { params: { keywords: this.keywords, price: this.price } })
                    .then(response => this.products = response.data)
                    .catch(error => {});
                // this.selectedcategory = '0';
            },
        },
        computed:{
            filtredproducts : function(){
                if(this.selectedcategory === ""){
                    // this.taman = null;
                    return this.products;
                }
                
                else if (this.selectedcategory) {
                    this.results = [];
                    // this.taman = null;
                    this.keywords = null;
                    return this.products.filter((item) => item.category_id == this.selectedcategory);
                }
                
            },
            rows() {
                return this.filtredproducts.length
            },
            itemsForList() {
            return this.filtredproducts.slice(
            (this.currentPage - 1) * this.perPage,
            this.currentPage * this.perPage,
            this.currentPage= 1,
            );
        }
        }
        
    }
</script> 